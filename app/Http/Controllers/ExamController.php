<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $exams = Exam::query()
            ->with(['course', 'batch'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search);
                    } else {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhereHas('course', function ($courseQuery) use ($search) {
                                $courseQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('code', 'like', "%{$search}%");
                            })
                            ->orWhereHas('batch', function ($batchQuery) use ($search) {
                                $batchQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('batch_number', 'like', "%{$search}%");
                            });
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view('exams.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Remove extra spaces from title
        $request->merge([
            'title' => preg_replace('/\s+/', ' ', trim($request->title)),
        ]);

        $request->validate([
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where('is_active', true)->whereNull('deleted_at'),
            ],
            'batch_id' => [
                'required',
                Rule::exists('batches', 'id')->where('is_active', true)->whereNull('deleted_at'),
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        // Make sure selected batch belongs to selected course
        $batchExists = Batch::query()->where('id', $request->batch_id)->where('course_id', $request->course_id)->where('is_active', true)->whereNull('deleted_at')->exists();

        if (!$batchExists) {
            return back()->withErrors(['batch_id' => 'The selected batch does not belong to the selected course.'])->withInput();
        }

        $exam = new Exam();
        $exam->course_id = $request->course_id;
        $exam->batch_id = $request->batch_id;
        $exam->title = $request->title;
        $exam->description = $request->description;
        // Checkbox checked = true, unchecked = false
        $exam->is_active = $request->boolean('is_active');
        $exam->save();

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        $exam->load([
            'course',
            'batch',
            'examSets' => function ($query) {
                $query->with([
                    'competencyUnitMappings.competencyUnit',
                ])
                    ->orderBy('type')
                    ->orderBy('set_number');
            },
        ]);

        $modules = Module::query()
            ->where('course_id', $exam->course_id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('module_number')
            ->get([
                'id',
                'name',
                'module_number',
                'course_id',
            ]);

        return view('exams.show', compact(
            'exam',
            'modules'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $courses = Course::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $batches = Batch::query()
            ->where('course_id', $exam->course_id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view('exams.edit', compact('exam', 'courses', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        // Remove extra spaces from title
        $request->merge([
            'title' => preg_replace('/\s+/', ' ', trim($request->title)),
        ]);

        $request->validate([
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where('is_active', true)->whereNull('deleted_at'),
            ],
            'batch_id' => [
                'required',
                Rule::exists('batches', 'id')->where('is_active', true)->whereNull('deleted_at'),
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        // Make sure selected batch belongs to selected course
        $batchExists = Batch::query()->where('id', $request->batch_id)->where('course_id', $request->course_id)->where('is_active', true)->whereNull('deleted_at')->exists();

        if (!$batchExists) {
            return back()->withErrors(['batch_id' => 'The selected batch does not belong to the selected course.'])->withInput();
        }

        $exam->course_id = $request->course_id;
        $exam->batch_id = $request->batch_id;
        $exam->title = $request->title;
        $exam->description = $request->description;
        // Checkbox checked = true, unchecked = false
        $exam->is_active = $request->boolean('is_active');
        $exam->update();

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    /**
     * Get batches by course.
     */
    public function getBatchesByCourse($courseId)
    {
        $batches = Batch::query()->where('course_id', $courseId)->where('is_active', true)->whereNull('deleted_at')->orderBy('name')->get();

        return response()->json($batches);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    /**
     * Display all deleted exams.
     */
    public function deletedExams(Request $request)
    {
        $search = $request->input('search');

        $exams = Exam::query()
            ->onlyTrashed()
            ->with(['course', 'batch'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search);
                    }

                    $q->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($courseQuery) use ($search) {
                            $courseQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                        })
                        ->orWhereHas('batch', function ($batchQuery) use ($search) {
                            $batchQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('batch_number', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('exams.deleted', compact('exams'));
    }

    /**
     * Restore deleted exam.
     */
    public function restoreExams(int $id)
    {
        $exam = Exam::withTrashed()->findOrFail($id);
        $exam->restore();

        return redirect()->route('exams.deleted')->with('success', 'Exam restored successfully.');
    }

    /**
     * Permanently delete exam.
     */
    public function forceDelete(int $id)
    {
        $exam = Exam::withTrashed()->findOrFail($id);
        $exam->forceDelete();

        return redirect()->route('exams.deleted')->with('success', 'Exam permanently deleted.');
    }
}
