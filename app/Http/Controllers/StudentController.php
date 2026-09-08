<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\Batch;
use App\Models\Round;

class StudentController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls'],
        ]);

        try {
            $import = new StudentImport();

            Excel::import($import, $request->file('file'));

            $failures = $import->failures();
            $skipped = $import->skippedRows();

            // Download error CSV if errors exist
            if ($failures->isNotEmpty() || !empty($skipped)) {
                $errorRows = [];

                // Add validation errors
                foreach ($failures as $failure) {
                    $row = $failure['data'];
                    $row['error'] = $failure['error'];
                    $errorRows[] = $row;
                }

                // Add skipped rows
                foreach ($skipped as $skippedRow) {
                    $row = $skippedRow['data'];
                    $row['error'] = $skippedRow['error'];
                    $errorRows[] = $row;
                }

                // Generate error CSV
                return response()->streamDownload(function () use ($errorRows) {
                    $handle = fopen('php://output', 'w');

                    if (!empty($errorRows)) {
                        $headings = array_keys($errorRows[0]);
                        fputcsv($handle, $headings);

                        foreach ($errorRows as $row) {
                            fputcsv($handle, array_map(
                                fn($value) => is_array($value) ? json_encode($value) : $value,
                                array_values($row)
                            ));
                        }
                    }

                    fclose($handle);
                }, 'student_import_errors.csv');
            }

            // Redirect after successful import
            return redirect()->back()->with('success', 'Students imported successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    // Download student CSV template
    public function exportTemplate()
    {
        return Excel::download(new StudentExport, 'student_import_template.csv');
    }

    public function index() {}

    public function create()
    {
        $rounds = Round::all();
        $batches = Batch::all();

        return view('students.create', compact('rounds', 'batches'));
    }

    public function store(Request $request) {}

    public function show(Student $student) {}

    public function edit(Student $student) {}

    public function update(Request $request, Student $student) {}

    public function destroy(Student $student) {}
}
