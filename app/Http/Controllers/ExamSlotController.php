<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Exam;
use App\Models\ExamSet;
use App\Models\ExamSlot;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $rounds = Round::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        return view('exam-slots.create', compact('rounds'));
    }

    public function getBatches($roundId)
    {
        $batches = Batch::where('round_id', $roundId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($batches);
    }

    public function getExams($batchId)
    {
        $exams = Exam::where('batch_id', $batchId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get([
                'id',
                'title',
            ]);

        return response()->json($exams);
    }

    public function getExamSets($examId)
    {
        $examSets = ExamSet::where('exam_id', $examId)
            ->where('is_active', true)
            ->whereNotIn('status', ['completed', 'processing'])
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($examSets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'round_id' => [
                'required',
                Rule::exists('rounds', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
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
                'after_or_equal:now',
            ],
            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],
        ]);

        $batch = Batch::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->batch_id);

        $exam = Exam::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_id);

        $examSet = ExamSet::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_set_id);

        if ($batch->round_id != $request->round_id) {
            return back()
                ->withInput()
                ->with('error', 'Selected Batch does not belong to the selected Round.');
        }

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

        if ($examSet->status === 'completed') {
            return back()
                ->withInput()
                ->with('error', 'This Exam Set has already been completed.');
        }

        $existingSlot = ExamSlot::where('batch_id', $request->batch_id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
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
        $examSlot->status = 'scheduled';
        $examSlot->started_at = null;
        $examSlot->ended_at = null;
        $examSlot->is_active = true;
        $examSlot->save();

        $examSet->status = 'published';
        $examSet->save();

        return redirect()
            ->route('exam-slots.index')
            ->with('success', 'Exam Slot created successfully.');
    }

    public function show(ExamSlot $examSlot)
    {
        $examSlot->load([
            'batch',
            'examSet.exam',
        ]);

        return view('exam-slots.show', compact('examSlot'));
    }

    public function edit(ExamSlot $examSlot)
    {
        if ($examSlot->status !== 'scheduled') {
            return redirect()
                ->route('exam-slots.index')
                ->with('error', 'Started or ended exam slots cannot be edited.');
        }

        $examSlot->load('batch', 'examSet.exam');

        $rounds = Round::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        $selectedRoundId = $examSlot->batch->round_id ?? null;
        $selectedExamId = $examSlot->examSet->exam_id ?? null;

        return view('exam-slots.edit', compact(
            'examSlot',
            'rounds',
            'selectedRoundId',
            'selectedExamId'
        ));
    }

    public function update(Request $request, ExamSlot $examSlot)
    {
        if ($examSlot->status !== 'scheduled') {
            return redirect()
                ->route('exam-slots.index')
                ->with('error', 'Started or ended exam slots cannot be edited.');
        }

        $request->validate([
            'round_id' => [
                'required',
                Rule::exists('rounds', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
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
                'after_or_equal:now',
            ],
            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],
        ]);

        $batch = Batch::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->batch_id);

        $exam = Exam::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_id);

        $examSet = ExamSet::where('is_active', true)
            ->whereNull('deleted_at')
            ->findOrFail($request->exam_set_id);

        if ($batch->round_id != $request->round_id) {
            return back()
                ->withInput()
                ->with('error', 'Selected Batch does not belong to the selected Round.');
        }

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

        if ($examSet->status === 'completed') {
            return back()
                ->withInput()
                ->with('error', 'This Exam Set has already been completed.');
        }

        $existingSlot = ExamSlot::where('batch_id', $request->batch_id)
            ->where('id', '!=', $examSlot->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
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
        $examSlot->status = 'scheduled';
        $examSlot->started_at = null;
        $examSlot->ended_at = null;
        $examSlot->is_active = true;
        $examSlot->save();

        $examSet->status = 'published';
        $examSet->save();

        return redirect()
            ->route('exam-slots.index')
            ->with('success', 'Exam Slot updated successfully.');
    }

    public function startExam(ExamSlot $examSlot)
    {
        if ($examSlot->status !== 'scheduled') {
            return back()
                ->with('error', 'This exam cannot be started.');
        }

        if (!$examSlot->is_active || $examSlot->deleted_at !== null) {
            return back()
                ->with('error', 'This exam slot is not active.');
        }

        $now = now();

        if ($now->gte($examSlot->end_at)) {
            return back()
                ->with('error', 'The scheduled exam time has already ended. This exam cannot be started.');
        }

        $conflict = ExamSlot::query()
            ->where('batch_id', $examSlot->batch_id)
            ->where('id', '!=', $examSlot->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->where(function ($query) use ($now) {
                $query->where('status', 'start')
                    ->orWhere(function ($query) use ($now) {
                        $query->where('status', 'scheduled')
                            ->where('start_at', '<=', $now)
                            ->where('end_at', '>', $now);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()
                ->with('error', 'Another exam is already scheduled or running for this batch at this time.');
        }

        DB::transaction(function () use ($examSlot, $now) {
            $examSlot->status = 'start';
            $examSlot->started_at = $now;
            $examSlot->is_active = true;
            $examSlot->save();

            $examSet = $examSlot->examSet;

            if ($examSet) {
                $examSet->status = 'processing';
                $examSet->save();
            }
        });

        return redirect()
            ->route('exam-slots.index')
            ->with('success', 'Exam started successfully.');
    }

    public function autoStartExams()
    {
        $now = now('Asia/Dhaka');
        $started = 0;

        $examSlots = ExamSlot::where('status', 'scheduled')
            ->where('is_active', true)
            ->where('start_at', '<=', $now)
            ->where('end_at', '>', $now)
            ->get();

        foreach ($examSlots as $examSlot) {
            $conflict = ExamSlot::where('batch_id', $examSlot->batch_id)
                ->where('id', '!=', $examSlot->id)
                ->where('status', 'start')
                ->where('is_active', true)
                ->exists();

            if ($conflict) {
                continue;
            }

            DB::transaction(function () use ($examSlot, $now) {
                $examSlot->status = 'start';
                $examSlot->started_at = $now;
                $examSlot->is_active = true;
                $examSlot->save();

                $examSet = $examSlot->examSet;

                if ($examSet) {
                    $examSet->status = 'processing';
                    $examSet->save();
                }
            });

            $started++;
        }

        return response()->json([
            'success' => true,
            'started' => $started,
        ]);
    }

    public function endExam(ExamSlot $examSlot)
    {
        if ($examSlot->status !== 'start') {
            return back()
                ->with('error', 'This exam cannot be ended.');
        }

        if (!$examSlot->is_active || $examSlot->deleted_at !== null) {
            return back()
                ->with('error', 'This exam slot is not active.');
        }

        $now = now();

        DB::transaction(function () use ($examSlot, $now) {
            $examSlot->status = 'ended';
            $examSlot->ended_at = $now;
            $examSlot->is_active = false;
            $examSlot->save();

            $examSet = $examSlot->examSet;

            if ($examSet) {
                $examSet->status = 'completed';
                $examSet->save();

                $exam = $examSet->exam;

                if ($exam) {
                    $incompleteExamSet = ExamSet::where('exam_id', $exam->id)
                        ->where('status', '!=', 'completed')
                        ->where('is_active', true)
                        ->whereNull('deleted_at')
                        ->exists();

                    if (!$incompleteExamSet) {
                        $exam->is_active = false;
                        $exam->save();
                    }
                }
            }
        });

        return redirect()
            ->route('exam-slots.index')
            ->with('success', 'Exam ended successfully.');
    }

    public function destroy(ExamSlot $examSlot)
    {
        if ($examSlot->status === 'start') {
            return back()
                ->with('error', 'Running exam cannot be deleted.');
        }

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

        $conflict = ExamSlot::where('batch_id', $examSlot->batch_id)
            ->where('id', '!=', $examSlot->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->where(function ($query) use ($examSlot) {
                $query->where('start_at', '<', $examSlot->end_at)
                    ->where('end_at', '>', $examSlot->start_at);
            })
            ->exists();

        if ($conflict) {
            return back()
                ->with('error', 'This batch already has another exam slot during this time.');
        }

        $examSlot->restore();
        $examSlot->status = 'scheduled';
        $examSlot->started_at = null;
        $examSlot->ended_at = null;
        $examSlot->is_active = true;
        $examSlot->save();

        if ($examSlot->examSet) {
            $examSlot->examSet->status = 'published';
            $examSlot->examSet->save();
        }

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
