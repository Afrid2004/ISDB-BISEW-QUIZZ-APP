<?php

namespace App\Imports;

use App\Models\Batch;
use App\Models\Round;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class StudentImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    protected array $failures = [];
    protected array $skipped = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            // Get round
            $roundNumber = trim((string) ($row['round_id'] ?? ''));
            $round = Round::where('round_number', $roundNumber)->first();

            if (!$round) {
                $this->addSkipped($rowNumber, $row, "Round '{$roundNumber}' not found.");
                continue;
            }

            // Get batch number
            $batchId = trim((string) ($row['batch_id'] ?? ''));
            $batchParts = explode('/', $batchId);
            $batchNumber = trim(end($batchParts));

            // Get batch
            $batch = Batch::where('round_id', $round->id)->where('batch_number', $batchNumber)->first();

            if (!$batch) {
                $this->addSkipped($rowNumber, $row, "Batch '{$batchNumber}' not found for Round {$roundNumber}.");
                continue;
            }

            // Get student information
            $email = trim((string) ($row['email'] ?? ''));
            $phone = trim((string) ($row['phone'] ?? ''));
            $name = trim((string) ($row['name'] ?? ''));

            // Check duplicate
            $existingStudent = Student::where('round_id', $round->id)->where('batch_id', $batch->id)->where(function ($query) use ($email, $phone) {
                $query->where('email', $email)->orWhere('phone', $phone);
            })->first();

            // Skip duplicate
            if ($existingStudent) {
                $this->addSkipped($rowNumber, $row, 'Student already exists in this round and batch.');
                continue;
            }

            // Parse DOB
            try {
                $dob = $this->parseDate($row['dob'] ?? '');
            } catch (\Exception $e) {
                $this->addSkipped($rowNumber, $row, "Invalid date '" . ($row['dob'] ?? '') . "'.");
                continue;
            }

            // Create student
            try {
                $student = new Student();
                $student->round_id = $round->id;
                $student->batch_id = $batch->id;
                $student->name = $name;
                $student->email = $email;
                $student->phone = $phone;
                $student->dob = $dob;
                $student->photo = !empty($row['photo']) ? trim((string) $row['photo']) : null;
                $student->status = !empty($row['status']) ? trim((string) $row['status']) : 'active';
                $student->save();
            } catch (\Throwable $e) {
                $this->addSkipped($rowNumber, $row, 'Database error: ' . $e->getMessage());
                continue;
            }
        }
    }

    // Add skipped row
    private function addSkipped(int $rowNumber, $row, string $error): void
    {
        $this->skipped[] = [
            'row' => $rowNumber,
            'data' => $row->toArray(),
            'error' => $error,
        ];
    }

    // Parse date
    private function parseDate($value): string
    {
        if ($value === null || $value === '') {
            throw new \Exception('Empty date');
        }

        // Convert Excel serial date
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('Y-m-d');
        }

        $value = trim((string) $value);

        // Supported date formats
        $formats = ['n/j/Y', 'm/d/Y', 'd/m/Y', 'd-m-Y', 'Y-m-d', 'm-d-Y', 'd.m.Y', 'Y/m/d'];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $value)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        // Try automatic date parsing
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            throw new \Exception("Unable to parse date: {$value}");
        }
    }

    // Validation rules
    public function rules(): array
    {
        return [
            'round_id' => ['required', 'numeric'],
            'batch_id' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'max:30'],
            'dob' => ['required'],
            'photo' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:active,inactive'],
        ];
    }

    // Validation messages
    public function customValidationMessages(): array
    {
        return [
            'round_id.required' => 'Round number is required.',
            'round_id.numeric' => 'Round number must be numeric.',
            'batch_id.required' => 'Batch ID is required.',
            'name.required' => 'Student name is required.',
            'email.required' => 'Student email is required.',
            'email.email' => 'Please provide a valid email address.',
            'phone.required' => 'Student phone number is required.',
            'dob.required' => 'Date of birth is required.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }

    // Store validation failures
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row' => $failure->row(),
                'data' => $failure->values(),
                'error' => implode(' | ', $failure->errors()),
            ];
        }
    }

    // Get validation failures
    public function failures(): Collection
    {
        return collect($this->failures);
    }

    // Get skipped rows
    public function skippedRows(): array
    {
        return $this->skipped;
    }

    // Get all errors
    public function errors(): array
    {
        return array_merge($this->failures, $this->skipped);
    }

    // Check errors
    public function hasErrors(): bool
    {
        return !empty($this->failures) || !empty($this->skipped);
    }
}
