<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamSetController extends Controller
{
    /**
     * Display a listing of exam sets.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $examSets = ExamSet::query()
            ->with('exam')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {

                    if (is_numeric($search)) {
                        $q->where('id', $search);
                    }

                    $q->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('question_type', 'like', "%{$search}%")
                        ->orWhere('mode', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('exam', function ($examQuery) use ($search) {
                            $examQuery->where('title', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('exam-sets.index', compact('examSets'));
    }

    /**
     * Show the form for creating a new exam set.
     */
    public function create()
    {
        $exams = Exam::query()
            ->with(['course', 'batch'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();

        return view('exam-sets.create', compact('exams'));
    }

    /**
     * Store a newly created exam set.
     */
    public function store(Request $request)
    {
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name)),
        ]);

        $validated = $request->validate([
            'exam_id' => [
                'required',
                Rule::exists('exams', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'type' => [
                'required',
                Rule::in([
                    'mid',
                    'monthly',
                ]),
            ],

            'question_type' => [
                'required',
                Rule::in([
                    'mcq',
                    'evidence',
                ]),
            ],

            'mode' => [
                'required',
                Rule::in([
                    'online',
                    'offline',
                ]),
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'draft',
                    'published',
                    'processing',
                    'completed',
                    'cancelled',
                ]),
            ],

            'set_number' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],

            'duration_minutes' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'pass_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'weight_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'shuffle_questions' => [
                'nullable',
                'boolean',
            ],

            'shuffle_options' => [
                'nullable',
                'boolean',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate duplicate set number
        |--------------------------------------------------------------------------
        */

        $exists = ExamSet::query()
            ->where('exam_id', $validated['exam_id'])
            ->where('type', $validated['type'])
            ->where('set_number', $validated['set_number'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'set_number' =>
                    'This set number already exists for the selected exam and type.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Validate pass marks
        |--------------------------------------------------------------------------
        */

        if (
            (float) $validated['pass_marks'] >
            (float) $validated['total_marks']
        ) {
            return back()
                ->withErrors([
                    'pass_marks' =>
                    'Pass marks cannot be greater than total marks.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Create Exam Set
        |--------------------------------------------------------------------------
        */

        $examSet = new ExamSet();

        $examSet->exam_id = $validated['exam_id'];
        $examSet->name = $validated['name'];
        $examSet->type = $validated['type'];
        $examSet->question_type = $validated['question_type'];
        $examSet->mode = $validated['mode'];
        $examSet->status = $validated['status'] ?? 'draft';
        $examSet->set_number = $validated['set_number'];
        $examSet->duration_minutes = $validated['duration_minutes'] ?? null;
        $examSet->total_marks = $validated['total_marks'];
        $examSet->pass_marks = $validated['pass_marks'];
        $examSet->weight_percentage = $validated['weight_percentage'];

        /*
        |--------------------------------------------------------------------------
        | Boolean Settings
        |--------------------------------------------------------------------------
        */

        $examSet->shuffle_questions =
            $request->boolean('shuffle_questions');

        $examSet->shuffle_options =
            $request->boolean('shuffle_options');

        $examSet->is_active =
            $request->boolean('is_active');

        $examSet->save();

        return redirect()
            ->route('exam-sets.index')
            ->with('success', 'Exam set created successfully.');
    }

    /**
     * Display the specified exam set.
     */
    public function show(ExamSet $examSet)
    {
        $examSet->load([
            'exam.course',
            'exam.batch',
        ]);

        return view('exam-sets.show', compact('examSet'));
    }

    /**
     * Show the form for editing the specified exam set.
     */
    public function edit(ExamSet $examSet)
    {
        $exams = Exam::query()
            ->with(['course', 'batch'])
            ->where(function ($query) use ($examSet) {
                $query->where('is_active', true)
                    ->orWhere('id', $examSet->exam_id);
            })
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();

        return view(
            'exam-sets.edit',
            compact('examSet', 'exams')
        );
    }

    /**
     * Update the specified exam set.
     */
    public function update(Request $request, ExamSet $examSet)
    {
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name)),
        ]);

        $validated = $request->validate([
            'exam_id' => [
                'required',
                Rule::exists('exams', 'id')
                    ->whereNull('deleted_at'),
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'type' => [
                'required',
                Rule::in([
                    'mid',
                    'monthly',
                ]),
            ],

            'question_type' => [
                'required',
                Rule::in([
                    'mcq',
                    'evidence',
                ]),
            ],

            'mode' => [
                'required',
                Rule::in([
                    'online',
                    'offline',
                ]),
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'draft',
                    'published',
                    'processing',
                    'completed',
                    'cancelled',
                ]),
            ],

            'set_number' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],

            'duration_minutes' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'pass_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'weight_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'shuffle_questions' => [
                'nullable',
                'boolean',
            ],

            'shuffle_options' => [
                'nullable',
                'boolean',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate duplicate set number
        |--------------------------------------------------------------------------
        */

        $exists = ExamSet::query()
            ->where('exam_id', $validated['exam_id'])
            ->where('type', $validated['type'])
            ->where('set_number', $validated['set_number'])
            ->where('id', '!=', $examSet->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'set_number' =>
                    'This set number already exists for the selected exam and type.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Validate pass marks
        |--------------------------------------------------------------------------
        */

        if (
            (float) $validated['pass_marks'] >
            (float) $validated['total_marks']
        ) {
            return back()
                ->withErrors([
                    'pass_marks' =>
                    'Pass marks cannot be greater than total marks.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Update Exam Set
        |--------------------------------------------------------------------------
        */

        $examSet->exam_id = $validated['exam_id'];
        $examSet->name = $validated['name'];
        $examSet->type = $validated['type'];
        $examSet->question_type = $validated['question_type'];
        $examSet->mode = $validated['mode'];
        $examSet->status = $validated['status'] ?? 'draft';
        $examSet->set_number = $validated['set_number'];
        $examSet->duration_minutes = $validated['duration_minutes'] ?? null;
        $examSet->total_marks = $validated['total_marks'];
        $examSet->pass_marks = $validated['pass_marks'];
        $examSet->weight_percentage = $validated['weight_percentage'];

        /*
        |--------------------------------------------------------------------------
        | Boolean Settings
        |--------------------------------------------------------------------------
        */

        $examSet->shuffle_questions =
            $request->boolean('shuffle_questions');

        $examSet->shuffle_options =
            $request->boolean('shuffle_options');

        $examSet->is_active =
            $request->boolean('is_active');

        $examSet->save();

        return redirect()
            ->route('exam-sets.index')
            ->with('success', 'Exam set updated successfully.');
    }

    /**
     * Remove the specified exam set.
     */
    public function destroy(ExamSet $examSet)
    {
        $examSet->delete();

        return redirect()
            ->route('exam-sets.index')
            ->with('success', 'Exam set deleted successfully.');
    }

    /**
     * Display all deleted exam sets.
     */
    public function deleted(Request $request)
    {
        $search = $request->input('search');

        $examSets = ExamSet::query()
            ->onlyTrashed()
            ->with('exam')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {

                    if (is_numeric($search)) {
                        $q->where('id', $search);
                    }

                    $q->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('question_type', 'like', "%{$search}%")
                        ->orWhere('mode', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('exam', function ($examQuery) use ($search) {
                            $examQuery->where(
                                'title',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('exam-sets.deleted', compact('examSets'));
    }

    /**
     * Restore deleted exam set.
     */
    public function restore(ExamSet $examSet)
    {
        $examSet->restore();

        return redirect()
            ->route('exam-sets.deleted')
            ->with('success', 'Exam set restored successfully.');
    }

    /**
     * Permanently delete exam set.
     */
    public function forceDelete(ExamSet $examSet)
    {
        $examSet->forceDelete();

        return redirect()
            ->route('exam-sets.deleted')
            ->with('success', 'Exam set permanently deleted.');
    }
}
