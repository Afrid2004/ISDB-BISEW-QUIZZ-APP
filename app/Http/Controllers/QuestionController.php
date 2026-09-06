<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Option;
use App\Models\Course;
use App\Models\Module;
use App\Models\CompetencyUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Imports\QuestionsImport;
use App\Exports\QuestionTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
class QuestionController extends Controller
{

    /**
     * Download sample CSV template.
     */
    public function exportTemplate()
    {
        return Excel::download(new QuestionTemplateExport, 'questions_template.csv');
    }

    /**
     * Import questions with atomic database transaction.
     * Downloads an error report if any validation fails.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $import = new QuestionsImport;

        // Start database transaction
        DB::beginTransaction();

        try {
            Excel::import($import, $request->file('file'));

            // Check if any row failed validation
            if ($import->failures()->isNotEmpty()) {
                // Roll back all changes so no invalid data enters the database
                DB::rollBack();

                $fileName = 'error_report_' . time() . '.csv';

                // Stream and download the CSV error file directly
                return response()->streamDownload(function () use ($import) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, ['Row', 'Field', 'Error Message']); // Headers

                    foreach ($import->failures() as $failure) {
                        fputcsv($handle, [
                            $failure->row(),
                            $failure->attribute(),
                            implode(', ', $failure->errors())
                        ]);
                    }
                    fclose($handle);
                }, $fileName, ['Content-Type' => 'text/csv']);
            }

            // Commit transaction if all rows are valid
            DB::commit();

            return back()->with('success', 'All questions imported successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import Failed: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of questions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $questions = Question::query()
            ->with(['course', 'module', 'competencyUnit', 'options'])
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('question', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }

                    $q->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('module', function ($moduleQuery) use ($search) {
                        $moduleQuery->where('name', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('competencyUnit', function ($competencyQuery) use ($search) {
                        $competencyQuery->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('questions.index', compact('questions'));
    }


    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        $courses = Course::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
        return view('questions.create', compact('courses'));
    }


    /**
     * Store a newly created question.
     */
    public function store(Request $request)
    {
        $request->validate([

            'course_id' => [
                'required',
                Rule::exists('courses', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],

            'module_id' => [
                'required',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],

            'competency_unit_id' => [
                'required',
                Rule::exists('competency_units', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],

            'marks' => ['required', 'integer', 'min:1'],

            'question' => ['required', 'string'],

            'question_type' => [
                'required',
                Rule::in([
                    'single_choice',
                    'multiple_choice'
                ])
            ],

            'options' => ['required', 'array', 'min:2'],

            'options.*' => ['required', 'string', 'max:1000'],

            'correct_answer' => ['required'],

            'is_active' => ['nullable', 'boolean']
        ]);


        /*
        |--------------------------------------------------------------------------
        | Correct Answer Validation
        |--------------------------------------------------------------------------
        */

        $options = $request->input('options');
        $correctAnswers = $request->input('correct_answer');


        /*
        |--------------------------------------------------------------------------
        | Multiple Choice
        |--------------------------------------------------------------------------
        */

        if ($request->question_type === 'multiple_choice') {

            if (!is_array($correctAnswers)) {
                $correctAnswers = [$correctAnswers];
            }

            foreach ($correctAnswers as $correctAnswer) {

                if (!array_key_exists($correctAnswer, $options)) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'correct_answer' => 'Invalid correct answer selected.'
                        ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Single Choice
        |--------------------------------------------------------------------------
        */ else {

            if (
                !is_string($correctAnswers) ||
                !array_key_exists($correctAnswers, $options)
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'correct_answer' => 'Invalid correct answer selected.'
                    ]);
            }

            $correctAnswers = [$correctAnswers];
        }


        /*
        |--------------------------------------------------------------------------
        | Create Question + Options
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($request, $options, $correctAnswers) {

            /*
            |--------------------------------------------------------------------------
            | Question
            |--------------------------------------------------------------------------
            */

            $question = new Question();

            $question->course_id = $request->course_id;
            $question->module_id = $request->module_id;
            $question->competency_unit_id = $request->competency_unit_id;
            $question->question = trim($request->question);
            $question->marks = $request->marks;
            $question->question_type = $request->question_type;
            $question->is_active = $request->boolean('is_active');

            $question->save();


            /*
            |--------------------------------------------------------------------------
            | Options
            |--------------------------------------------------------------------------
            */

            foreach ($options as $letter => $optionText) {

                Option::create([
                    'question_id' => $question->id,
                    'option' => trim($optionText),
                    'is_correct' => in_array($letter, $correctAnswers),
                ]);
            }
        });


        return redirect()
            ->route('questions.index')
            ->with('success', 'Question created successfully.');
    }

    public function getModules($courseId)
    {
        $modules = Module::where('course_id', $courseId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($modules);
    }


    public function getCompetencyUnits($moduleId)
    {
        $competencyUnits = CompetencyUnit::where('module_id', $moduleId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($competencyUnits);
    }


    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        $question->load([
            'course',
            'module',
            'competencyUnit',
            'options'
        ]);

        return view('questions.show', compact('question'));
    }


    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $question->load('options');

        $courses = Course::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $modules = Module::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $competencyUnits = CompetencyUnit::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view('questions.edit', compact(
            'question',
            'courses',
            'modules',
            'competencyUnits'
        ));
    }


    /**
     * Update the specified question.
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([

            'course_id' => [
                'required',
                Rule::exists('courses', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],

            'module_id' => [
                'required',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],

            'competency_unit_id' => [
                'required',
                Rule::exists('competency_units', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
            ],

            'marks' => [
                'required',
                'integer',
                'min:1'
            ],

            'question' => [
                'required',
                'string'
            ],

            'question_type' => [
                'required',
                Rule::in([
                    'single_choice',
                    'multiple_choice'
                ])
            ],

            'options' => [
                'required',
                'array',
                'min:2'
            ],

            'options.*' => [
                'required',
                'string',
                'max:1000'
            ],

            'correct_answer' => [
                'required'
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ]
        ]);


        $options = $request->input('options');
        $correctAnswers = $request->input('correct_answer');


        /*
        |--------------------------------------------------------------------------
        | Multiple Choice
        |--------------------------------------------------------------------------
        */

        if ($request->question_type === 'multiple_choice') {

            if (!is_array($correctAnswers)) {
                $correctAnswers = [$correctAnswers];
            }

            foreach ($correctAnswers as $correctAnswer) {

                if (!array_key_exists($correctAnswer, $options)) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'correct_answer' => 'Invalid correct answer selected.'
                        ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Single Choice
        |--------------------------------------------------------------------------
        */ else {

            if (
                !is_string($correctAnswers) ||
                !array_key_exists($correctAnswers, $options)
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'correct_answer' => 'Invalid correct answer selected.'
                    ]);
            }

            $correctAnswers = [$correctAnswers];
        }


        /*
        |--------------------------------------------------------------------------
        | Update Question + Options
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $question,
            $options,
            $correctAnswers
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update Question
            |--------------------------------------------------------------------------
            */

            $question->course_id = $request->course_id;
            $question->module_id = $request->module_id;
            $question->competency_unit_id = $request->competency_unit_id;
            $question->question = trim($request->question);
            $question->marks = $request->marks;
            $question->question_type = $request->question_type;
            $question->is_active = $request->boolean('is_active');

            $question->save();


            /*
            |--------------------------------------------------------------------------
            | Delete Old Options
            |--------------------------------------------------------------------------
            */

            $question->options()->delete();


            /*
            |--------------------------------------------------------------------------
            | Create Updated Options
            |--------------------------------------------------------------------------
            */

            foreach ($options as $letter => $optionText) {

                Option::create([
                    'question_id' => $question->id,
                    'option' => trim($optionText),
                    'is_correct' => in_array($letter, $correctAnswers),
                ]);
            }
        });


        return redirect()
            ->route('questions.index')
            ->with('success', 'Question updated successfully.');
    }


    /**
     * Remove the specified question.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()
            ->route('questions.index')
            ->with('success', 'Question deleted successfully.');
    }


    /**
     * Display all deleted questions.
     */
    public function deletedQuestions(Request $request)
    {
        $search = $request->input('search');

        $questions = Question::query()
            ->with(['course', 'module', 'competencyUnit', 'options'])
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('question', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }

                    $q->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('module', function ($moduleQuery) use ($search) {
                        $moduleQuery->where('name', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('competencyUnit', function ($competencyQuery) use ($search) {
                        $competencyQuery->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('questions.deleted', compact('questions'));
    }


    /**
     * Restore deleted question.
     */
    public function restoreQuestion(int $id)
    {
        $question = Question::withTrashed()->findOrFail($id);

        $question->restore();

        return redirect()
            ->route('questions.deleted')
            ->with('success', 'Question restored successfully.');
    }


    /**
     * Permanently delete question.
     */
    public function forceDelete(int $id)
    {
        $question = Question::withTrashed()->findOrFail($id);

        $question->forceDelete();

        return redirect()
            ->route('questions.deleted')
            ->with('success', 'Question permanently deleted.');
    }
}
