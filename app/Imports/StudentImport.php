<?php

namespace App\Imports;

use Carbon\Carbon;

use App\Models\Batch;
use App\Models\Round;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class StudentImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    protected array $failures = [];
    protected array $skipped = [];

    /**
     * Import students.
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {

            $round = Round::where('round_number', $row['round_id'])->first();

            if (!$round) {
                $this->skipped[] = "Row " . ($index + 2) . ": Round '{$row['round_id']}' not found.";
                continue;
            }

            $batch = Batch::where('round_id', $round->id)
                ->where('name', trim($row['batch_id']))
                ->first();

            if (!$batch) {
                $this->skipped[] = "Row " . ($index + 2) . ": Batch '{$row['batch_id']}' not found for round {$row['round_id']}.";
                continue;
            }

            // Parse date safely - handles M/D/Y format from CSV
            try {
                $dob = Carbon::createFromFormat('n/j/Y', trim($row['dob']))->format('Y-m-d');
            } catch (\Exception $e) {
                $this->skipped[] = "Row " . ($index + 2) . ": Invalid date format '{$row['dob']}'.";
                continue;
            }

            $student = new Student();

            $student->round_id = $round->id;
            $student->batch_id = $batch->id;
            $student->name = trim($row['name']);
            $student->email = trim($row['email']);
            $student->phone = (string) trim($row['phone']);
            $student->dob = $dob;

            $student->status = !empty($row['status'])
                ? trim($row['status'])
                : 'active';

            $student->save();
        }
    }

    /**
     * Validation rules — must match actual CSV column headers.
     */
    public function rules(): array
    {
        return [
            'round_id' => [
                'required',
                'integer',
                'exists:rounds,round_number',
            ],
            'batch_id' => [
                'required',
                'max:100',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'regex:/^[0-9+\-\s()]+$/',
                'max:30',
            ],
            'dob' => [
                'required',
                'date',
            ],
            'status' => [
                'nullable',
                'in:active,inactive',
            ],
        ];
    }

    /**
     * Custom validation error messages (optional but helpful).
     */
    public function customValidationMessages()
    {
        return [
            'round_id.exists' => 'Round number :input does not exist in rounds table.',
        ];
    }

    /**
     * Store validation failures.
     */
    public function onFailure(Failure ...$failures): void
    {
        $this->failures = array_merge($this->failures, $failures);
    }

    /**
     * Return validation failures (rows rejected by rules()).
     */
    public function failures(): Collection
    {
        return collect($this->failures);
    }

    /**
     * Return rows skipped inside collection() (round/batch not found).
     */
    public function skippedRows(): array
    {
        return $this->skipped;
    }
}
