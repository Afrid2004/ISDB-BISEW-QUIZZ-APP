<?php

namespace App\Http\Controllers;

use App\Models\CompetencyUnit;
use App\Models\ExamSet;
use App\Models\ExamSetCompetencyUnit;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ExamSetCompetencyUnitController extends Controller
{
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

    public function updateQuestions(Request $request, ExamSet $examSet)
    {
        if (!$examSet->is_active || $examSet->deleted_at !== null) {
            abort(404);
        }

        $validated = $request->validate([
            'modules' => [
                'nullable',
                'array',
            ],
            'modules.*.module_id' => [
                'required',
                'integer',
                Rule::exists('modules', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'modules.*.competency_units' => [
                'nullable',
                'array',
            ],
            'modules.*.competency_units.*.selected' => [
                'nullable',
                'boolean',
            ],
            'modules.*.competency_units.*.question_count' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $exam = $examSet->exam;

        if (!$exam) {
            abort(422, 'Exam set exam not found.');
        }

        $selectedCompetencyUnits = [];
        $selectedModules = [];

        foreach ($validated['modules'] ?? [] as $moduleData) {
            $moduleId = (int) $moduleData['module_id'];

            if (in_array($moduleId, $selectedModules, true)) {
                return back()
                    ->withErrors([
                        'modules' => 'The same module cannot be selected more than once.',
                    ])
                    ->withInput();
            }

            $selectedModules[] = $moduleId;

            $module = Module::query()
                ->where('id', $moduleId)
                ->where('course_id', $exam->course_id)
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->first();

            if (!$module) {
                return back()
                    ->withErrors([
                        'modules' => 'One or more selected modules are invalid.',
                    ])
                    ->withInput();
            }

            foreach ($moduleData['competency_units'] ?? [] as $competencyUnitId => $unit) {
                if (empty($unit['selected'])) {
                    continue;
                }

                $competencyUnit = CompetencyUnit::query()
                    ->where('id', $competencyUnitId)
                    ->where('module_id', $module->id)
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->first();

                if (!$competencyUnit) {
                    return back()
                        ->withErrors([
                            'modules' => 'One or more selected competency units are invalid.',
                        ])
                        ->withInput();
                }

                if (
                    !isset($unit['question_count']) ||
                    (int) $unit['question_count'] < 1
                ) {
                    return back()
                        ->withErrors([
                            'modules' => "Please enter question count for {$competencyUnit->code}.",
                        ])
                        ->withInput();
                }

                $selectedCompetencyUnits[] = [
                    'id' => $competencyUnit->id,
                    'module_id' => $module->id,
                    'question_count' => (int) $unit['question_count'],
                ];
            }
        }

        DB::transaction(function () use (
            $examSet,
            $selectedCompetencyUnits,
            $validated
        ) {
            $selectedIds = [];

            foreach ($selectedCompetencyUnits as $unit) {
                $selectedIds[] = (int) $unit['id'];
            }

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

            foreach ($selectedCompetencyUnits as $unit) {
                $mapping = ExamSetCompetencyUnit::withTrashed()
                    ->where('exam_set_id', $examSet->id)
                    ->where('competency_unit_id', $unit['id'])
                    ->first();

                if ($mapping) {
                    $mapping->question_count = $unit['question_count'];
                    $mapping->is_active = (bool) $validated['is_active'];

                    if ($mapping->trashed()) {
                        $mapping->restore();
                    }

                    $mapping->save();
                } else {
                    $mapping = new ExamSetCompetencyUnit();

                    $mapping->exam_set_id = $examSet->id;
                    $mapping->competency_unit_id = $unit['id'];
                    $mapping->question_count = $unit['question_count'];
                    $mapping->is_active = (bool) $validated['is_active'];

                    $mapping->save();
                }
            }
        });

        return redirect()
            ->route('exams.show', $exam->id)
            ->with(
                'success',
                'Questions assigned to exam set successfully.'
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

                    $q->orWhereHas('examSet', function ($query) use ($search) {
                        $query->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });

                    $q->orWhereHas('examSet.exam', function ($query) use ($search) {
                        $query->where(
                            'title',
                            'like',
                            "%{$search}%"
                        );
                    });

                    $q->orWhereHas('competencyUnit', function ($query) use ($search) {
                        $query->where(
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
}
