<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\CompetencyUnit;
use App\Models\Exam;
use App\Models\ExamSet;
use App\Models\ExamSetCompetencyUnit;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamSetCompetencyUnitController extends Controller
{
    // Display all exam set competency units
    public function index(Request $request)
    {
        $search = $request->input('search');

        $examSetCompetencyUnits = ExamSetCompetencyUnit::query()
            ->with(['examSet.exam.course', 'examSet.exam.batch', 'competencyUnit.module.course'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)
                            ->orWhere('question_count', $search);
                    }

                    $q->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                        $examSetQuery->where('name', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('examSet.exam', function ($examQuery) use ($search) {
                        $examQuery->where('title', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('competencyUnit', function ($competencyUnitQuery) use ($search) {
                        $competencyUnitQuery->where('code', 'like', "%{$search}%");
                    });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('exam-set-competency-units.index', compact('examSetCompetencyUnits'));
    }

    // Get exams by batch
    public function getExamsByBatch(Request $request)
    {
        $request->validate([
            'batch_id' => ['required', 'integer'],
        ]);

        $batch = Batch::query()
            ->where('id', $request->batch_id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $exams = Exam::query()
            ->where('batch_id', $batch->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('title')
            ->get(['id', 'title', 'course_id', 'batch_id']);

        return response()->json($exams);
    }

    // Get modules by batch course
    public function getModulesByBatch(Request $request)
    {
        $request->validate([
            'batch_id' => ['required', 'integer'],
        ]);

        $batch = Batch::query()
            ->where('id', $request->batch_id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $modules = Module::query()
            ->where('course_id', $batch->course_id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('module_number')
            ->get(['id', 'name', 'module_number', 'course_id']);

        return response()->json($modules);
    }

    // Get exam sets by exam
    public function getExamSetsByExam($examId)
    {
        $exam = Exam::query()
            ->where('id', $examId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $examSets = ExamSet::query()
            ->where('exam_id', $exam->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('set_number')
            ->get(['id', 'name', 'set_number', 'exam_id']);

        return response()->json($examSets);
    }

    // Get competency units by module
    public function getCompetencyUnitsByModule($moduleId)
    {
        $module = Module::query()
            ->where('id', $moduleId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $competencyUnits = CompetencyUnit::query()
            ->where('module_id', $module->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('serial')
            ->get(['id', 'code', 'prefix', 'serial', 'module_id']);

        return response()->json($competencyUnits);
    }

    // Show create form
    public function create()
    {
        $batches = Batch::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view('exam-set-competency-units.create', compact('batches'));
    }

    // Store exam set competency unit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_id' => [
                'required',
                'integer',
                Rule::exists('batches', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'module_id' => [
                'required',
                'integer',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'exam_id' => [
                'required',
                'integer',
                Rule::exists('exams', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'exam_set_id' => [
                'required',
                'integer',
                Rule::exists('exam_sets', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'competency_unit_id' => [
                'required',
                'integer',
                Rule::exists('competency_units', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'question_count' => ['required', 'integer', 'min:1'],
        ]);

        $batch = Batch::query()
            ->where('id', $validated['batch_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $exam = Exam::query()
            ->where('id', $validated['exam_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $examSet = ExamSet::query()
            ->where('id', $validated['exam_set_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $module = Module::query()
            ->where('id', $validated['module_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $competencyUnit = CompetencyUnit::query()
            ->where('id', $validated['competency_unit_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        // Make sure exam belongs to selected batch
        if ($exam->batch_id != $batch->id) {
            return back()
                ->withErrors([
                    'exam_id' => 'The selected exam does not belong to the selected batch.',
                ])
                ->withInput();
        }

        // Make sure exam course belongs to selected batch course
        if ($exam->course_id != $batch->course_id) {
            return back()
                ->withErrors([
                    'exam_id' => 'The selected exam does not belong to the selected batch course.',
                ])
                ->withInput();
        }

        // Make sure exam set belongs to selected exam
        if ($examSet->exam_id != $exam->id) {
            return back()
                ->withErrors([
                    'exam_set_id' => 'The selected exam set does not belong to the selected exam.',
                ])
                ->withInput();
        }

        // Make sure module belongs to batch course
        if ($module->course_id != $batch->course_id) {
            return back()
                ->withErrors([
                    'module_id' => 'The selected module does not belong to the selected batch course.',
                ])
                ->withInput();
        }

        // Make sure competency unit belongs to selected module
        if ($competencyUnit->module_id != $module->id) {
            return back()
                ->withErrors([
                    'competency_unit_id' => 'The selected competency unit does not belong to the selected module.',
                ])
                ->withInput();
        }

        // Make sure exam course and module course are same
        if ($exam->course_id != $module->course_id) {
            return back()
                ->withErrors([
                    'module_id' => 'The selected module does not belong to the selected exam course.',
                ])
                ->withInput();
        }

        // Check duplicate assignment
        $exists = ExamSetCompetencyUnit::query()
            ->where('exam_set_id', $validated['exam_set_id'])
            ->where('competency_unit_id', $validated['competency_unit_id'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'competency_unit_id' => 'This competency unit is already assigned to the selected exam set.',
                ])
                ->withInput();
        }

        $examSetCompetencyUnit = new ExamSetCompetencyUnit();
        $examSetCompetencyUnit->exam_set_id = $validated['exam_set_id'];
        $examSetCompetencyUnit->competency_unit_id = $validated['competency_unit_id'];
        $examSetCompetencyUnit->question_count = $validated['question_count'];
        $examSetCompetencyUnit->save();

        return redirect()
            ->route('exam-set-competency-units.index')
            ->with('success', 'Competency unit assigned to exam set successfully.');
    }

    // Display mapping details
    public function show(ExamSetCompetencyUnit $examSetCompetencyUnit)
    {
        $examSetCompetencyUnit->load([
            'examSet.exam.course',
            'examSet.exam.batch',
            'competencyUnit.module.course',
        ]);

        return view(
            'exam-set-competency-units.show',
            compact('examSetCompetencyUnit')
        );
    }

    // Show edit form
    public function edit(ExamSetCompetencyUnit $examSetCompetencyUnit)
    {
        $examSetCompetencyUnit->load([
            'examSet.exam.course',
            'examSet.exam.batch',
            'competencyUnit.module.course',
        ]);

        $batches = Batch::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view(
            'exam-set-competency-units.edit',
            compact('examSetCompetencyUnit', 'batches')
        );
    }

    // Update mapping
    public function update(Request $request, ExamSetCompetencyUnit $examSetCompetencyUnit)
    {
        $validated = $request->validate([
            'batch_id' => [
                'required',
                'integer',
                Rule::exists('batches', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'module_id' => [
                'required',
                'integer',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'exam_id' => [
                'required',
                'integer',
                Rule::exists('exams', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'exam_set_id' => [
                'required',
                'integer',
                Rule::exists('exam_sets', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'competency_unit_id' => [
                'required',
                'integer',
                Rule::exists('competency_units', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'question_count' => ['required', 'integer', 'min:1'],
        ]);

        $batch = Batch::query()
            ->where('id', $validated['batch_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $exam = Exam::query()
            ->where('id', $validated['exam_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $examSet = ExamSet::query()
            ->where('id', $validated['exam_set_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $module = Module::query()
            ->where('id', $validated['module_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $competencyUnit = CompetencyUnit::query()
            ->where('id', $validated['competency_unit_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        // Make sure exam belongs to selected batch
        if ($exam->batch_id != $batch->id) {
            return back()
                ->withErrors([
                    'exam_id' => 'The selected exam does not belong to the selected batch.',
                ])
                ->withInput();
        }

        // Make sure exam course belongs to selected batch course
        if ($exam->course_id != $batch->course_id) {
            return back()
                ->withErrors([
                    'exam_id' => 'The selected exam does not belong to the selected batch course.',
                ])
                ->withInput();
        }

        // Make sure exam set belongs to selected exam
        if ($examSet->exam_id != $exam->id) {
            return back()
                ->withErrors([
                    'exam_set_id' => 'The selected exam set does not belong to the selected exam.',
                ])
                ->withInput();
        }

        // Make sure module belongs to batch course
        if ($module->course_id != $batch->course_id) {
            return back()
                ->withErrors([
                    'module_id' => 'The selected module does not belong to the selected batch course.',
                ])
                ->withInput();
        }

        // Make sure competency unit belongs to selected module
        if ($competencyUnit->module_id != $module->id) {
            return back()
                ->withErrors([
                    'competency_unit_id' => 'The selected competency unit does not belong to the selected module.',
                ])
                ->withInput();
        }

        // Make sure exam course and module course are same
        if ($exam->course_id != $module->course_id) {
            return back()
                ->withErrors([
                    'module_id' => 'The selected module does not belong to the selected exam course.',
                ])
                ->withInput();
        }

        // Check duplicate assignment except current record
        $exists = ExamSetCompetencyUnit::query()
            ->where('exam_set_id', $validated['exam_set_id'])
            ->where('competency_unit_id', $validated['competency_unit_id'])
            ->where('id', '!=', $examSetCompetencyUnit->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'competency_unit_id' => 'This competency unit is already assigned to the selected exam set.',
                ])
                ->withInput();
        }

        $examSetCompetencyUnit->exam_set_id = $validated['exam_set_id'];
        $examSetCompetencyUnit->competency_unit_id = $validated['competency_unit_id'];
        $examSetCompetencyUnit->question_count = $validated['question_count'];
        $examSetCompetencyUnit->save();

        return redirect()
            ->route('exam-set-competency-units.index')
            ->with('success', 'Exam set competency unit updated successfully.');
    }

    // Delete mapping
    public function destroy(ExamSetCompetencyUnit $examSetCompetencyUnit)
    {
        $examSetCompetencyUnit->delete();

        return redirect()
            ->route('exam-set-competency-units.index')
            ->with('success', 'Exam set competency unit deleted successfully.');
    }

    // Display deleted mappings
    public function deleted(Request $request)
    {
        $search = $request->input('search');

        $examSetCompetencyUnits = ExamSetCompetencyUnit::query()
            ->onlyTrashed()
            ->with([
                'examSet.exam.course',
                'examSet.exam.batch',
                'competencyUnit.module.course',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search);
                    }

                    $q->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                        $examSetQuery->where('name', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('examSet.exam', function ($examQuery) use ($search) {
                        $examQuery->where('title', 'like', "%{$search}%");
                    });

                    $q->orWhereHas('competencyUnit', function ($competencyUnitQuery) use ($search) {
                        $competencyUnitQuery->where('code', 'like', "%{$search}%");
                    });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'exam-set-competency-units.deleted',
            compact('examSetCompetencyUnits')
        );
    }

    // Restore deleted mapping
    public function restore($id)
    {
        $examSetCompetencyUnit = ExamSetCompetencyUnit::withTrashed()->findOrFail($id);

        // Check if same assignment already exists
        $exists = ExamSetCompetencyUnit::query()
            ->where('exam_set_id', $examSetCompetencyUnit->exam_set_id)
            ->where('competency_unit_id', $examSetCompetencyUnit->competency_unit_id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('exam-set-competency-units.deleted')
                ->with('error', 'This competency unit is already assigned to the exam set.');
        }

        $examSetCompetencyUnit->restore();

        return redirect()
            ->route('exam-set-competency-units.deleted')
            ->with('success', 'Exam set competency unit restored successfully.');
    }

    // Permanently delete mapping
    public function forceDelete($id)
    {
        $examSetCompetencyUnit = ExamSetCompetencyUnit::withTrashed()->findOrFail($id);

        $examSetCompetencyUnit->forceDelete();

        return redirect()
            ->route('exam-set-competency-units.deleted')
            ->with('success', 'Exam set competency unit permanently deleted.');
    }
}