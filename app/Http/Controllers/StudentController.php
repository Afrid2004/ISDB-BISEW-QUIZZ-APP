<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\Batch;
use App\Models\Round;
use Maatwebsite\Excel\Validators\ValidationException;

class StudentController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt',
            ],
        ]);

        try {
            $import = new StudentImport;
            Excel::import($import, $request->file('file'));

            $failures = $import->failures();
            $skipped  = $import->skippedRows();

            if ($failures->isNotEmpty() || !empty($skipped)) {
                return redirect()->back()
                    ->with('failures', $failures)
                    ->with('skipped', $skipped)
                    ->with('error', 'Some student records could not be imported. See details below.');
            }

            return redirect()->back()->with('success', 'Students imported successfully.');
        } catch (ValidationException $e) {
            $failures = $e->failures();

            return redirect()->back()
                ->with('failures', $failures)
                ->with('error', 'Some student records could not be imported.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Download student CSV template
     */
    public function exportTemplate()
    {
        return Excel::download(new StudentExport, 'student_import_template.csv');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rounds = Round::all();
        $batches = Batch::all();
        //all rounds to populate the dropdown in the form

        return view('students.create', compact('rounds', 'batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
