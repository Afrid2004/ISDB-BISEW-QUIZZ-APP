<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Exam;
use App\Models\ExamSet;
use App\Models\ExamSlot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamSlotController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $examSlots = ExamSlot::query()
            ->with(['batch', 'examSet.exam'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)
                            ->orWhere('batch_id', $search)
                            ->orWhere('exam_set_id', $search);
                    } else {
                        $q->whereHas('batch', function ($batchQuery) use ($search) {
                            $batchQuery->where('name', 'like', "%{$search}%");
                        })
                            ->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                                $examSetQuery->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('examSet.exam', function ($examQuery) use ($search) {
                                $examQuery->where('title', 'like', "%{$search}%");
                            });
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('exam-slots.index', compact('examSlots'));
    }

    public function create()
    {
        $batches = Batch::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        return view('exam-slots.create', compact('batches'));
    }

    public function getExams($batchId)
    {
        $exams = Exam::where('batch_id', $batchId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get([
                'id',
                'title'
            ]);

        return response()->json($exams);
    }

    public function getExamSets($examId)
    {
        $examSets = ExamSet::where('exam_id', $examId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get([
                'id',
                'name'
            ]);

        return response()->json($examSets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => [
                'required',
                Rule::exists('batches', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'exam_id' => [
                'required',
                Rule::exists('exams', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'exam_set_id' => [
                'required',
                Rule::exists('exam_sets', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'start_at' => [
                'required',
                'date',
            ],

            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $exam = Exam::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_id);

        $examSet = ExamSet::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_set_id);

        if ($exam->batch_id != $request->batch_id) {
            return back()
                ->withInput()
                ->with('error', 'Selected Exam does not belong to the selected Batch.');
        }

        if ($examSet->exam_id != $exam->id) {
            return back()
                ->withInput()
                ->with('error', 'Selected Exam Set does not belong to the selected Exam.');
        }

        $existingSlot = ExamSlot::where('batch_id', $request->batch_id)
            ->where(function ($query) use ($request) {
                $query->where('start_at', '<', $request->end_at)
                    ->where('end_at', '>', $request->start_at);
            })
            ->first();

        if ($existingSlot) {
            return back()
                ->withInput()
                ->with('error', 'This batch already has an exam slot during the selected time.');
        }

        $examSlot = new ExamSlot();

        $examSlot->batch_id = $request->batch_id;
        $examSlot->exam_set_id = $request->exam_set_id;
        $examSlot->start_at = $request->start_at;
        $examSlot->end_at = $request->end_at;
        $examSlot->is_active = $request->has('is_active');

        $examSlot->save();

        return redirect()
            ->route('exam-slots.index')
            ->with('success', 'Exam Slot created successfully.');
    }

    public function show(ExamSlot $examSlot)
    {
        $examSlot->load([
            'batch',
            'examSet.exam'
        ]);

        return view('exam-slots.show', compact('examSlot'));
    }

    public function edit(ExamSlot $examSlot)
    {
        $examSlot->load('examSet.exam');

        $batches = Batch::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        $selectedExamId = $examSlot->examSet->exam_id ?? null;

        return view('exam-slots.edit', compact(
            'examSlot',
            'batches',
            'selectedExamId'
        ));
    }

    public function update(Request $request, ExamSlot $examSlot)
    {
        $request->validate([
            'batch_id' => [
                'required',
                Rule::exists('batches', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'exam_id' => [
                'required',
                Rule::exists('exams', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'exam_set_id' => [
                'required',
                Rule::exists('exam_sets', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'start_at' => [
                'required',
                'date',
            ],

            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $exam = Exam::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_id);

        $examSet = ExamSet::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_set_id);

        if ($exam->batch_id != $request->batch_id) {
            return back()
                ->withInput()
                ->with('error', 'Selected Exam does not belong to the selected Batch.');
        }

        if ($examSet->exam_id != $exam->id) {
            return back()
                ->withInput()
                ->with('error', 'Selected Exam Set does not belong to the selected Exam.');
        }

        $existingSlot = ExamSlot::where('batch_id', $request->batch_id)
            ->where('id', '!=', $examSlot->id)
            ->where(function ($query) use ($request) {
                $query->where('start_at', '<', $request->end_at)
                    ->where('end_at', '>', $request->start_at);
            })
            ->first();

        if ($existingSlot) {
            return back()
                ->withInput()
                ->with('error', 'This batch already has an exam slot during the selected time.');
        }

        $examSlot->batch_id = $request->batch_id;
        $examSlot->exam_set_id = $request->exam_set_id;
        $examSlot->start_at = $request->start_at;
        $examSlot->end_at = $request->end_at;
        $examSlot->is_active = $request->has('is_active');

        $examSlot->save();

        return redirect()
            ->route('exam-slots.index')
            ->with('success', 'Exam Slot updated successfully.');
    }

    public function destroy(ExamSlot $examSlot)
    {
        $examSlot->delete();

        return redirect()
            ->route('exam-slots.index')
            ->with('success', 'Exam Slot deleted successfully.');
    }

    public function deletedSlots(Request $request)
    {
        $search = $request->input('search');

        $examSlots = ExamSlot::onlyTrashed()
            ->with(['batch', 'examSet.exam'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    if (is_numeric($search)) {
                        $q->where('id', $search)
                            ->orWhere('batch_id', $search)
                            ->orWhere('exam_set_id', $search);
                    } else {
                        $q->whereHas('batch', function ($batchQuery) use ($search) {
                            $batchQuery->where('name', 'like', "%{$search}%");
                        })
                            ->orWhereHas('examSet', function ($examSetQuery) use ($search) {
                                $examSetQuery->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('examSet.exam', function ($examQuery) use ($search) {
                                $examQuery->where('title', 'like', "%{$search}%");
                            });
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('exam-slots.deleted', compact('examSlots'));
    }

    public function restoreSlots(int $id)
    {
        $examSlot = ExamSlot::withTrashed()->findOrFail($id);

        $examSlot->restore();

        return redirect()
            ->route('exam-slots.deleted')
            ->with('success', 'Exam Slot restored successfully.');
    }

    public function forceDelete(int $id)
    {
        $examSlot = ExamSlot::withTrashed()->findOrFail($id);

        $examSlot->forceDelete();

        return redirect()
            ->route('exam-slots.deleted')
            ->with('success', 'Exam Slot permanently deleted.');
    }
}
