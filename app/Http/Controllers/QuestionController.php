<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Option;
use App\Models\Course;
use App\Models\Module;
use App\Models\CompetencyUnit;
use App\Models\Element;
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
        return Excel::download(
            new QuestionTemplateExport,
            'questions_template.csv'
        );
    }

    /**
     * Import questions from CSV/Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt,xlsx,xls',
                'max:5120',
            ],
        ]);

        $import = new QuestionsImport();

        DB::beginTransaction();

        try {
            Excel::import(
                $import,
                $request->file('file')
            );

            /*
            |--------------------------------------------------------------------------
            | Check Validation Failures
            |--------------------------------------------------------------------------
            */

            if ($import->failures()->isNotEmpty()) {

                DB::rollBack();

                $fileName = 'error_report_' . time() . '.csv';

                return response()->streamDownload(
                    function () use ($import) {

                        $handle = fopen(
                            'php://output',
                            'w'
                        );

                        fputcsv(
                            $handle,
                            [
                                'Row',
                                'Field',
                                'Error Message'
                            ]
                        );

                        foreach ($import->failures() as $failure) {

                            fputcsv(
                                $handle,
                                [
                                    $failure->row(),
                                    $failure->attribute(),
                                    implode(
                                        ', ',
                                        $failure->errors()
                                    ),
                                ]
                            );
                        }

                        fclose($handle);
                    },
                    $fileName,
                    [
                        'Content-Type' => 'text/csv',
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Commit Import
            |--------------------------------------------------------------------------
            */

            DB::commit();

            return back()->with(
                'success',
                'All questions imported successfully!'
            );
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Import Failed: ' . $e->getMessage()
                );
        }
    }

    /**
     * Display a listing of questions.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $questions = Question::query()

            // Course
            ->leftJoin(
                'courses',
                'questions.course_id',
                '=',
                'courses.id'
            )

            // Module
            ->leftJoin(
                'modules',
                function ($join) {
                    $join->on(
                        'questions.module_id',
                        '=',
                        'modules.id'
                    )
                        ->on(
                            'questions.course_id',
                            '=',
                            'modules.course_id'
                        );
                }
            )

            // Competency Unit
            ->leftJoin(
                'competency_units',
                function ($join) {
                    $join->on(
                        'questions.competency_unit_id',
                        '=',
                        'competency_units.id'
                    )
                        ->on(
                            'questions.module_id',
                            '=',
                            'competency_units.module_id'
                        );
                }
            )

            // Element
            ->leftJoin(
                'elements',
                function ($join) {
                    $join->on(
                        'questions.element_id',
                        '=',
                        'elements.id'
                    )
                        ->on(
                            'questions.competency_unit_id',
                            '=',
                            'elements.competency_unit_id'
                        );
                }
            )

            ->select(
                'questions.*',

                // Course
                'courses.name as course_name',
                'courses.code as course_code',

                // Module
                'modules.name as module_name',
                'modules.module_number as module_number',

                // Competency Unit
                'competency_units.code as competency_unit_code',
                'competency_units.serial as competency_unit_serial',

                // Element
                'elements.name as element_name'
            )

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    // Question
                    $q->where(
                        'questions.question_text',
                        'like',
                        "%{$search}%"
                    );

                    // Question ID
                    if (is_numeric($search)) {
                        $q->orWhere(
                            'questions.id',
                            $search
                        );
                    }

                    // Course
                    $q->orWhere(
                        'courses.name',
                        'like',
                        "%{$search}%"
                    );

                    $q->orWhere(
                        'courses.code',
                        'like',
                        "%{$search}%"
                    );

                    // Module
                    $q->orWhere(
                        'modules.name',
                        'like',
                        "%{$search}%"
                    );

                    if (is_numeric($search)) {
                        $q->orWhere(
                            'modules.module_number',
                            $search
                        );
                    }

                    // Competency Unit
                    $q->orWhere(
                        'competency_units.code',
                        'like',
                        "%{$search}%"
                    );

                    if (is_numeric($search)) {
                        $q->orWhere(
                            'competency_units.serial',
                            $search
                        );
                    }

                    // Element
                    $q->orWhere(
                        'elements.name',
                        'like',
                        "%{$search}%"
                    );
                });
            })

            ->orderByDesc('questions.id')

            ->paginate(10)

            ->withQueryString();

        return view(
            'questions.index',
            compact('questions')
        );
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

        return view(
            'questions.create',
            compact('courses')
        );
    }

    /**
     * Store a newly created question.
     */
    public function store(Request $request)
    {
        $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Course
            |--------------------------------------------------------------------------
            */

            'course_id' => [
                'required',
                Rule::exists('courses', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Module
            |--------------------------------------------------------------------------
            */

            'module_id' => [
                'required',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Competency Unit
            |--------------------------------------------------------------------------
            */

            'competency_unit_id' => [
                'required',
                Rule::exists(
                    'competency_units',
                    'id'
                )
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Element
            |--------------------------------------------------------------------------
            */

            'element_id' => [
                'required',
                Rule::exists('elements', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Question
            |--------------------------------------------------------------------------
            */

            'question_text' => [
                'required',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Marks
            |--------------------------------------------------------------------------
            */

            'marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Difficulty
            |--------------------------------------------------------------------------
            */

            'difficulty_level' => [
                'required',
                Rule::in([
                    'easy',
                    'medium',
                    'hard',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Question Type
            |--------------------------------------------------------------------------
            */

            'question_type' => [
                'required',
                Rule::in([
                    'single_choice',
                    'multiple_choice',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Options
            |--------------------------------------------------------------------------
            */

            'options' => [
                'required',
                'array',
                'min:2',
            ],

            'options.*' => [
                'required',
                'string',
                'max:1000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Correct Answer
            |--------------------------------------------------------------------------
            */

            'correct_answer' => [
                'required',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'is_active' => [
                'nullable',
                'boolean',
            ],
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

                if (!array_key_exists(
                    $correctAnswer,
                    $options
                )) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'correct_answer' =>
                            'Invalid correct answer selected.',
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
                !array_key_exists(
                    $correctAnswers,
                    $options
                )
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'correct_answer' =>
                        'Invalid correct answer selected.',
                    ]);
            }

            $correctAnswers = [$correctAnswers];
        }

        /*
        |--------------------------------------------------------------------------
        | Create Question + Options
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $options,
            $correctAnswers
        ) {

            /*
            |--------------------------------------------------------------------------
            | Create Question
            |--------------------------------------------------------------------------
            */

            $question = new Question();

            $question->course_id =
                $request->course_id;

            $question->module_id =
                $request->module_id;

            $question->competency_unit_id =
                $request->competency_unit_id;

            $question->element_id =
                $request->element_id;

            $question->question_text =
                trim($request->question_text);

            $question->marks =
                $request->marks;

            $question->difficulty_level =
                $request->difficulty_level;

            $question->question_type =
                $request->question_type;

            $question->is_active =
                $request->boolean('is_active');

            $question->created_by =
                auth()->id();

            $question->save();

            /*
            |--------------------------------------------------------------------------
            | Create Options
            |--------------------------------------------------------------------------
            */

            foreach ($options as $letter => $optionText) {

                Option::create([
                    'question_id' => $question->id,

                    'option' =>
                    trim($optionText),

                    'is_correct' =>
                    in_array(
                        $letter,
                        $correctAnswers
                    ),
                ]);
            }
        });

        return redirect()
            ->route('questions.index')
            ->with(
                'success',
                'Question created successfully.'
            );
    }

    /**
     * Get modules by course.
     */
    public function getModules($courseId)
    {
        $modules = Module::where(
            'course_id',
            $courseId
        )
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($modules);
    }

    /**
     * Get competency units by module.
     */
    public function getCompetencyUnits($moduleId)
    {
        $competencyUnits = CompetencyUnit::where(
            'module_id',
            $moduleId
        )
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($competencyUnits);
    }

    /**
     * Get elements by competency unit.
     */
    public function getElements($competencyUnitId)
    {
        $elements = Element::where(
            'competency_unit_id',
            $competencyUnitId
        )
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($elements);
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
            'element',
            'options',
        ]);

        return view(
            'questions.show',
            compact('question')
        );
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $question->load([
            'options',
            'element',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Courses
        |--------------------------------------------------------------------------
        */

        $courses = Course::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Modules
        |--------------------------------------------------------------------------
        */

        $modules = Module::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Competency Units
        |--------------------------------------------------------------------------
        */

        $competencyUnits = CompetencyUnit::where(
            'is_active',
            true
        )
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        $elements = Element::where(
            'is_active',
            true
        )
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view(
            'questions.edit',
            compact(
                'question',
                'courses',
                'modules',
                'competencyUnits',
                'elements'
            )
        );
    }

    /**
     * Update the specified question.
     */
    public function update(
        Request $request,
        Question $question
    ) {
        $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Course
            |--------------------------------------------------------------------------
            */

            'course_id' => [
                'required',
                Rule::exists('courses', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Module
            |--------------------------------------------------------------------------
            */

            'module_id' => [
                'required',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Competency Unit
            |--------------------------------------------------------------------------
            */

            'competency_unit_id' => [
                'required',
                Rule::exists(
                    'competency_units',
                    'id'
                )
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Element
            |--------------------------------------------------------------------------
            */

            'element_id' => [
                'required',
                Rule::exists('elements', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Question
            |--------------------------------------------------------------------------
            */

            'question_text' => [
                'required',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Marks
            |--------------------------------------------------------------------------
            */

            'marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Difficulty
            |--------------------------------------------------------------------------
            */

            'difficulty_level' => [
                'required',
                Rule::in([
                    'easy',
                    'medium',
                    'hard',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Question Type
            |--------------------------------------------------------------------------
            */

            'question_type' => [
                'required',
                Rule::in([
                    'single_choice',
                    'multiple_choice',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Options
            |--------------------------------------------------------------------------
            */

            'options' => [
                'required',
                'array',
                'min:2',
            ],

            'options.*' => [
                'required',
                'string',
                'max:1000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Correct Answer
            |--------------------------------------------------------------------------
            */

            'correct_answer' => [
                'required',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'is_active' => [
                'nullable',
                'boolean',
            ],
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

                if (!array_key_exists(
                    $correctAnswer,
                    $options
                )) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'correct_answer' =>
                            'Invalid correct answer selected.',
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
                !array_key_exists(
                    $correctAnswers,
                    $options
                )
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'correct_answer' =>
                        'Invalid correct answer selected.',
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

            $question->course_id =
                $request->course_id;

            $question->module_id =
                $request->module_id;

            $question->competency_unit_id =
                $request->competency_unit_id;

            $question->element_id =
                $request->element_id;

            $question->question_text =
                trim($request->question_text);

            $question->marks =
                $request->marks;

            $question->difficulty_level =
                $request->difficulty_level;

            $question->question_type =
                $request->question_type;

            $question->is_active =
                $request->boolean('is_active');

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

                    'option' =>
                    trim($optionText),

                    'is_correct' =>
                    in_array(
                        $letter,
                        $correctAnswers
                    ),
                ]);
            }
        });

        return redirect()
            ->route('questions.index')
            ->with(
                'success',
                'Question updated successfully.'
            );
    }

    /**
     * Remove the specified question.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()
            ->route('questions.index')
            ->with(
                'success',
                'Question deleted successfully.'
            );
    }

    /**
     * Display all deleted questions.
     */
    public function deletedQuestions(Request $request)
    {
        $search = $request->input('search');

        $questions = Question::query()
            ->with([
                'course',
                'module',
                'competencyUnit',
                'element',
                'options',
            ])
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    /*
                    |--------------------------------------------------------------------------
                    | Search Question
                    |--------------------------------------------------------------------------
                    */

                    $q->where(
                        'question_text',
                        'like',
                        "%{$search}%"
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Search ID
                    |--------------------------------------------------------------------------
                    */

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Search Course
                    |--------------------------------------------------------------------------
                    */

                    $q->orWhereHas(
                        'course',
                        function ($courseQuery) use ($search) {

                            $courseQuery
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'code',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Search Module
                    |--------------------------------------------------------------------------
                    */

                    $q->orWhereHas(
                        'module',
                        function ($moduleQuery) use ($search) {

                            $moduleQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Search Competency Unit
                    |--------------------------------------------------------------------------
                    */

                    $q->orWhereHas(
                        'competencyUnit',
                        function ($competencyQuery) use ($search) {

                            $competencyQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Search Element
                    |--------------------------------------------------------------------------
                    */

                    $q->orWhereHas(
                        'element',
                        function ($elementQuery) use ($search) {

                            $elementQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
                });
            })
            ->onlyTrashed()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'questions.deleted',
            compact('questions')
        );
    }

    /**
     * Restore deleted question.
     */
    public function restoreQuestion(int $id)
    {
        $question = Question::withTrashed()
            ->findOrFail($id);

        $question->restore();

        return redirect()
            ->route('questions.deleted')
            ->with(
                'success',
                'Question restored successfully.'
            );
    }

    /**
     * Permanently delete question.
     */
    public function forceDelete(int $id)
    {
        $question = Question::withTrashed()
            ->findOrFail($id);

        $question->forceDelete();

        return redirect()
            ->route('questions.deleted')
            ->with(
                'success',
                'Question permanently deleted.'
            );
    }
}
