<?php

namespace App\Http\Controllers;

use App\Models\ExamSet;
use App\Models\ExamSetCompetencyUnit;
use App\Models\CompetencyUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamSetCompetencyUnitController extends Controller
{
    // Display all exam set competency units
    public function index(Request $request)
    {
        $search = $request->input('search');

        $examSetCompetencyUnits = ExamSetCompetencyUnit::query()
            ->with([
                'examSet.exam',
                'competencyUnit.module.course'
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {

                    if (is_numeric($search)) {
                        $q->where('id', $search)
                            ->orWhere('question_count', $search);
                    }

                    // Search by Exam Set Name
                    $q->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                        $examSetQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });

                    // Search by Exam Title
                    $q->orWhereHas('examSet.exam', function ($examQuery) use ($search) {
                        $examQuery->where(
                            'title',
                            'like',
                            "%{$search}%"
                        );
                    });

                    // Search by Competency Unit Code
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

    // Show create form
    public function create()
    {
        $examSets = ExamSet::query()
            ->with('exam')
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();

        $competencyUnits = CompetencyUnit::query()
            ->with('module.course')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return view(
            'exam-set-competency-units.create',
            compact('examSets', 'competencyUnits')
        );
    }

    // Store mapping
    public function store(Request $request)
    {
        $validated = $request->validate([
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
            'question_count' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $exists = ExamSetCompetencyUnit::query()
            ->where('exam_set_id', $validated['exam_set_id'])
            ->where('competency_unit_id', $validated['competency_unit_id'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'competency_unit_id' =>
                    'This competency unit is already assigned to the selected exam set.',
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
            ->with(
                'success',
                'Competency unit assigned to exam set successfully.'
            );
    }

    // Display mapping
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
        $examSets = ExamSet::query()
            ->with('exam')
            ->where(function ($query) use ($examSetCompetencyUnit) {
                $query->where('is_active', true)
                    ->orWhere('id', $examSetCompetencyUnit->exam_set_id);
            })
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();

        $competencyUnits = CompetencyUnit::query()
            ->with('module.course')
            ->where(function ($query) use ($examSetCompetencyUnit) {
                $query->where('is_active', true)
                    ->orWhere('id', $examSetCompetencyUnit->competency_unit_id);
            })
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        return view(
            'exam-set-competency-units.edit',
            compact(
                'examSetCompetencyUnit',
                'examSets',
                'competencyUnits'
            )
        );
    }

    // Update mapping
    public function update(
        Request $request,
        ExamSetCompetencyUnit $examSetCompetencyUnit
    ) {
        $validated = $request->validate([
            'exam_set_id' => [
                'required',
                'integer',
                Rule::exists('exam_sets', 'id')
                    ->whereNull('deleted_at'),
            ],
            'competency_unit_id' => [
                'required',
                'integer',
                Rule::exists('competency_units', 'id')
                    ->whereNull('deleted_at'),
            ],
            'question_count' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $exists = ExamSetCompetencyUnit::query()
            ->where('exam_set_id', $validated['exam_set_id'])
            ->where('competency_unit_id', $validated['competency_unit_id'])
            ->where('id', '!=', $examSetCompetencyUnit->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'competency_unit_id' =>
                    'This competency unit is already assigned to the selected exam set.',
                ])
                ->withInput();
        }

        $examSetCompetencyUnit->exam_set_id = $validated['exam_set_id'];
        $examSetCompetencyUnit->competency_unit_id = $validated['competency_unit_id'];
        $examSetCompetencyUnit->question_count = $validated['question_count'];

        $examSetCompetencyUnit->save();

        return redirect()
            ->route('exam-set-competency-units.index')
            ->with(
                'success',
                'Exam set competency unit updated successfully.'
            );
    }

    // Delete mapping
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

        $examSetCompetencyUnits = ExamSetCompetencyUnit::query()
            ->onlyTrashed()
            ->with(['examSet', 'competencyUnit'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search);
                    }

                    $q->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                        $examSetQuery->where('name', 'like', "%{$search}%");
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

    public function restore(ExamSetCompetencyUnit $examSetCompetencyUnit)
    {
        $examSetCompetencyUnit->restore();

        return redirect()
            ->route('exam-set-competency-units.deleted')
            ->with('success', 'Exam set competency unit restored successfully.');
    }

    public function forceDelete(ExamSetCompetencyUnit $examSetCompetencyUnit)
    {
        $examSetCompetencyUnit->forceDelete();

        return redirect()
            ->route('exam-set-competency-units.deleted')
            ->with('success', 'Exam set competency unit permanently deleted.');
    }
}
