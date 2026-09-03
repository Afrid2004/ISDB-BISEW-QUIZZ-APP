<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\CompetencyUnit;
use App\Models\Exam;
use App\Models\ExamSet;
use App\Models\ExamSetCompetencyUnit;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ExamSetCompetencyUnitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $examSetCompetencyUnits = ExamSetCompetencyUnit::query()
            ->with([
                'examSet.exam.course',
                'examSet.exam.batch',
                'competencyUnit.module.course',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)
                            ->orWhere('question_count', $search);
                    }

                    $q->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                        $examSetQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });

                    $q->orWhereHas('examSet.exam', function ($examQuery) use ($search) {
                        $examQuery->where(
                            'title',
                            'like',
                            "%{$search}%"
                        );
                    });

                    $q->orWhereHas('competencyUnit', function ($competencyUnitQuery) use ($search) {
                        $competencyUnitQuery->where(
                            'code',
                            'like',
                            "%{$search}%"
                        );
                    });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'exam-set-competency-units.index',
            compact('examSetCompetencyUnits')
        );
    }

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
            ->get([
                'id',
                'title',
                'course_id',
                'batch_id',
            ]);

        return response()->json($exams);
    }

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
            ->get([
                'id',
                'name',
                'module_number',
                'course_id',
            ]);

        return response()->json($modules);
    }

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
            ->get([
                'id',
                'name',
                'set_number',
                'exam_id',
            ]);

        return response()->json($examSets);
    }

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
            ->get([
                'id',
                'code',
                'prefix',
                'serial',
                'module_id',
            ]);

        return response()->json($competencyUnits);
    }

    public function create()
    {
        $batches = Batch::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view(
            'exam-set-competency-units.create',
            compact('batches')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateAssignment($request);

        $batch = $this->getBatch($validated['batch_id']);
        $exam = $this->getExam($validated['exam_id']);
        $examSet = $this->getExamSet($validated['exam_set_id']);
        $module = $this->getModule($validated['module_id']);

        $this->validateRelationships(
            $batch,
            $exam,
            $examSet,
            $module
        );

        $selectedCompetencyUnits = $this->getSelectedCompetencyUnits(
            $validated['competency_units']
        );

        if ($selectedCompetencyUnits->isEmpty()) {
            return back()
                ->withErrors([
                    'competency_units' => 'Please select at least one competency unit.',
                ])
                ->withInput();
        }

        $this->validateCompetencyUnits(
            $selectedCompetencyUnits,
            $module
        );

        DB::transaction(function () use (
            $selectedCompetencyUnits,
            $examSet
        ) {
            foreach ($selectedCompetencyUnits as $competencyUnitId => $unit) {
                $mapping = ExamSetCompetencyUnit::withTrashed()
                    ->where('exam_set_id', $examSet->id)
                    ->where('competency_unit_id', $competencyUnitId)
                    ->first();

                if ($mapping) {
                    $mapping->question_count = $unit['question_count'];
                    $mapping->is_active = true;

                    if ($mapping->trashed()) {
                        $mapping->restore();
                    }

                    $mapping->save();
                } else {
                    ExamSetCompetencyUnit::create([
                        'exam_set_id' => $examSet->id,
                        'competency_unit_id' => $competencyUnitId,
                        'question_count' => $unit['question_count'],
                        'is_active' => true,
                    ]);
                }
            }
        });

        return redirect()
            ->route('exam-set-competency-units.index')
            ->with(
                'success',
                'Competency units assigned to exam set successfully.'
            );
    }

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

        $moduleId = $examSetCompetencyUnit->competencyUnit->module_id;
        $examSetId = $examSetCompetencyUnit->exam_set_id;

        $existingMappings = ExamSetCompetencyUnit::query()
            ->where('exam_set_id', $examSetId)
            ->whereHas('competencyUnit', function ($query) use ($moduleId) {
                $query->where('module_id', $moduleId);
            })
            ->get()
            ->keyBy('competency_unit_id');

        return view(
            'exam-set-competency-units.edit',
            compact(
                'examSetCompetencyUnit',
                'batches',
                'existingMappings'
            )
        );
    }

    public function update(
        Request $request,
        ExamSetCompetencyUnit $examSetCompetencyUnit
    ) {
        $validated = $this->validateAssignment($request);

        $batch = $this->getBatch($validated['batch_id']);
        $exam = $this->getExam($validated['exam_id']);
        $examSet = $this->getExamSet($validated['exam_set_id']);
        $module = $this->getModule($validated['module_id']);

        $this->validateRelationships(
            $batch,
            $exam,
            $examSet,
            $module
        );

        $selectedCompetencyUnits = $this->getSelectedCompetencyUnits(
            $validated['competency_units']
        );

        if ($selectedCompetencyUnits->isEmpty()) {
            return back()
                ->withErrors([
                    'competency_units' => 'Please select at least one competency unit.',
                ])
                ->withInput();
        }

        $this->validateCompetencyUnits(
            $selectedCompetencyUnits,
            $module
        );

        DB::transaction(function () use (
            $selectedCompetencyUnits,
            $examSet
        ) {
            $selectedIds = $selectedCompetencyUnits
                ->keys()
                ->map(fn($id) => (int) $id)
                ->values()
                ->toArray();

            $existingMappings = ExamSetCompetencyUnit::withTrashed()
                ->where('exam_set_id', $examSet->id)
                ->get();

            foreach ($existingMappings as $mapping) {
                if (!in_array(
                    (int) $mapping->competency_unit_id,
                    $selectedIds,
                    true
                )) {
                    if (!$mapping->trashed()) {
                        $mapping->delete();
                    }
                }
            }

            foreach ($selectedCompetencyUnits as $competencyUnitId => $unit) {
                $mapping = ExamSetCompetencyUnit::withTrashed()
                    ->where('exam_set_id', $examSet->id)
                    ->where('competency_unit_id', $competencyUnitId)
                    ->first();

                if ($mapping) {
                    $mapping->question_count = $unit['question_count'];
                    $mapping->is_active = true;

                    if ($mapping->trashed()) {
                        $mapping->restore();
                    }

                    $mapping->save();
                } else {
                    ExamSetCompetencyUnit::create([
                        'exam_set_id' => $examSet->id,
                        'competency_unit_id' => $competencyUnitId,
                        'question_count' => $unit['question_count'],
                        'is_active' => true,
                    ]);
                }
            }
        });

        return redirect()
            ->route('exam-set-competency-units.index')
            ->with(
                'success',
                'Exam set competency units updated successfully.'
            );
    }

    public function destroy(ExamSetCompetencyUnit $examSetCompetencyUnit)
    {
        $examSetCompetencyUnit->delete();

        return redirect()
            ->route('exam-set-competency-units.index')
            ->with(
                'success',
                'Exam set competency unit deleted successfully.'
            );
    }

    public function deleted(Request $request)
    {
        $search = $request->input('search');

        $examSetCompetencyUnits = ExamSetCompetencyUnit::onlyTrashed()
            ->with([
                'examSet.exam.course',
                'examSet.exam.batch',
                'competencyUnit.module.course',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)
                            ->orWhere('question_count', $search);
                    }

                    $q->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                        $examSetQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });

                    $q->orWhereHas('examSet.exam', function ($examQuery) use ($search) {
                        $examQuery->where(
                            'title',
                            'like',
                            "%{$search}%"
                        );
                    });

                    $q->orWhereHas('competencyUnit', function ($competencyUnitQuery) use ($search) {
                        $competencyUnitQuery->where(
                            'code',
                            'like',
                            "%{$search}%"
                        );
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

    public function restore($id)
    {
        $mapping = ExamSetCompetencyUnit::withTrashed()
            ->findOrFail($id);

        $duplicate = ExamSetCompetencyUnit::query()
            ->where('exam_set_id', $mapping->exam_set_id)
            ->where('competency_unit_id', $mapping->competency_unit_id)
            ->where('id', '!=', $mapping->id)
            ->exists();

        if ($duplicate) {
            return redirect()
                ->route('exam-set-competency-units.deleted')
                ->with(
                    'error',
                    'This competency unit is already assigned to the exam set.'
                );
        }

        $mapping->restore();
        $mapping->is_active = true;
        $mapping->save();

        return redirect()
            ->route('exam-set-competency-units.deleted')
            ->with(
                'success',
                'Exam set competency unit restored successfully.'
            );
    }

    public function forceDelete($id)
    {
        $mapping = ExamSetCompetencyUnit::withTrashed()
            ->findOrFail($id);

        $mapping->forceDelete();

        return redirect()
            ->route('exam-set-competency-units.deleted')
            ->with(
                'success',
                'Exam set competency unit permanently deleted.'
            );
    }

    private function validateAssignment(Request $request)
    {
        return $request->validate([
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
            'competency_units' => [
                'required',
                'array',
                'min:1',
            ],
            'competency_units.*.selected' => [
                'nullable',
                'boolean',
            ],
            'competency_units.*.question_count' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);
    }

    private function getSelectedCompetencyUnits(array $competencyUnits)
    {
        return collect($competencyUnits)
            ->filter(fn($unit) => !empty($unit['selected']));
    }

    private function getBatch($id)
    {
        return Batch::query()
            ->where('id', $id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();
    }

    private function getExam($id)
    {
        return Exam::query()
            ->where('id', $id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();
    }

    private function getExamSet($id)
    {
        return ExamSet::query()
            ->where('id', $id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();
    }

    private function getModule($id)
    {
        return Module::query()
            ->where('id', $id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();
    }

    private function validateRelationships(
        Batch $batch,
        Exam $exam,
        ExamSet $examSet,
        Module $module
    ) {
        if ((int) $exam->batch_id !== (int) $batch->id) {
            abort(
                422,
                'The selected exam does not belong to the selected batch.'
            );
        }

        if ((int) $exam->course_id !== (int) $batch->course_id) {
            abort(
                422,
                'The selected exam does not belong to the selected batch course.'
            );
        }

        if ((int) $examSet->exam_id !== (int) $exam->id) {
            abort(
                422,
                'The selected exam set does not belong to the selected exam.'
            );
        }

        if ((int) $module->course_id !== (int) $batch->course_id) {
            abort(
                422,
                'The selected module does not belong to the selected batch course.'
            );
        }

        if ((int) $exam->course_id !== (int) $module->course_id) {
            abort(
                422,
                'The selected module does not belong to the selected exam course.'
            );
        }
    }

    private function validateCompetencyUnits(
        $selectedCompetencyUnits,
        Module $module
    ) {
        foreach ($selectedCompetencyUnits as $competencyUnitId => $unit) {
            $competencyUnit = CompetencyUnit::query()
                ->where('id', $competencyUnitId)
                ->where('module_id', $module->id)
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->first();

            if (!$competencyUnit) {
                abort(
                    422,
                    'One or more selected competency units are invalid.'
                );
            }

            if (
                !isset($unit['question_count']) ||
                (int) $unit['question_count'] < 1
            ) {
                abort(
                    422,
                    "Please enter question count for {$competencyUnit->code}."
                );
            }
        }
    }
}
