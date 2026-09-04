<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Exam;
use App\Models\ExamSet;
use App\Models\ExamSetQuestion;
use App\Models\ExamSetCompetencyUnit;
use App\Models\Question;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamSetQuestionController extends Controller
{
    public function generatePage(ExamSet $examSet)
    {
        if (!$examSet->is_active || $examSet->deleted_at !== null) {
            abort(404);
        }

        $examSet->load([
            'exam.course',
            'exam.batch',
            'competencyUnitMappings.competencyUnit.module',
        ]);

        $assignments = $examSet->competencyUnitMappings()
            ->with('competencyUnit.module')
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->get();

        foreach ($assignments as $assignment) {
            $assignment->available_questions = Question::query()
                ->where('course_id', $examSet->exam->course_id)
                ->whereHas('element', function ($query) use ($assignment) {
                    $query->where(
                        'competency_unit_id',
                        $assignment->competency_unit_id
                    );
                })
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->count();
        }

        $generatedQuestions = ExamSetQuestion::query()
            ->with([
                'question.element.competencyUnit',
                'question.options',
            ])
            ->where('exam_set_id', $examSet->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('question_order')
            ->get();

        return view(
            'exam-set-questions.generate',
            compact(
                'examSet',
                'assignments',
                'generatedQuestions'
            )
        );
    }

    public function questionCopyPdf(ExamSet $examSet)
    {
        $generatedQuestions = ExamSetQuestion::with([
            'question.element.competencyUnit',
            'question.options',
        ])
            ->where('exam_set_id', $examSet->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('question_order')
            ->get();

        $pdf = Pdf::loadView('exam-set-questions.question-copy-pdf', [
            'examSet' => $examSet,
            'generatedQuestions' => $generatedQuestions,
        ]);

        return $pdf->download(
            $examSet->name . '-question-copy.pdf'
        );
    }

    public function answerCopyPdf(ExamSet $examSet)
    {
        $generatedQuestions = ExamSetQuestion::with([
            'question.element.competencyUnit',
            'question.options',
        ])
            ->where('exam_set_id', $examSet->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('question_order')
            ->get();

        $pdf = Pdf::loadView('exam-set-questions.answer-copy-pdf', [
            'examSet' => $examSet,
            'generatedQuestions' => $generatedQuestions,
        ]);

        return $pdf->download(
            $examSet->name . '-answer-copy.pdf'
        );
    }

    public function generate(Request $request, ExamSet $examSet)
    {
        if (!$examSet->is_active || $examSet->deleted_at !== null) {
            abort(404);
        }

        $exam = $examSet->exam;

        if (!$exam) {
            throw ValidationException::withMessages([
                'exam_set' => 'Exam set exam not found.',
            ]);
        }

        $assignments = ExamSetCompetencyUnit::query()
            ->with('competencyUnit')
            ->where('exam_set_id', $examSet->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->get();

        if ($assignments->isEmpty()) {
            throw ValidationException::withMessages([
                'exam_set' => 'No competency units are assigned to this exam set.',
            ]);
        }

        DB::transaction(function () use (
            $assignments,
            $examSet,
            $exam
        ) {
            foreach ($assignments as $assignment) {
                $requiredCount = (int) $assignment->question_count;

                if ($requiredCount <= 0) {
                    continue;
                }

                $availableCount = Question::query()
                    ->where('course_id', $exam->course_id)
                    ->whereHas('element', function ($query) use ($assignment) {
                        $query->where(
                            'competency_unit_id',
                            $assignment->competency_unit_id
                        );
                    })
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->count();

                if ($availableCount < $requiredCount) {
                    $code = $assignment->competencyUnit->code ?? 'Unknown';

                    throw ValidationException::withMessages([
                        'exam_set' =>
                            "Not enough active questions available for competency unit {$code}. Required: {$requiredCount}, Available: {$availableCount}.",
                    ]);
                }
            }

            ExamSetQuestion::withTrashed()
                ->where('exam_set_id', $examSet->id)
                ->forceDelete();

            $order = 1;

            foreach ($assignments as $assignment) {
                $requiredCount = (int) $assignment->question_count;

                if ($requiredCount <= 0) {
                    continue;
                }

                $questions = Question::query()
                    ->where('course_id', $exam->course_id)
                    ->whereHas('element', function ($query) use ($assignment) {
                        $query->where(
                            'competency_unit_id',
                            $assignment->competency_unit_id
                        );
                    })
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->inRandomOrder()
                    ->limit($requiredCount)
                    ->get();

                foreach ($questions as $question) {
                    $examSetQuestion = new ExamSetQuestion();

                    $examSetQuestion->exam_set_id = $examSet->id;
                    $examSetQuestion->question_id = $question->id;
                    $examSetQuestion->question_order = $order;
                    $examSetQuestion->is_active = true;

                    $examSetQuestion->save();

                    $order++;
                }
            }
        });

        return redirect()
            ->route('exam-set-questions.generate', $examSet->id)
            ->with(
                'success',
                'Questions generated successfully.'
            );
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $examSetQuestions = ExamSetQuestion::query()
            ->with([
                'examSet.exam.batch',
                'examSet.exam.course',
                'question.element.competencyUnit.module',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('question', function ($query) use ($search) {
                        $query->where(
                            'question_text',
                            'like',
                            "%{$search}%"
                        );
                    })
                    ->orWhereHas('examSet', function ($query) use ($search) {
                        $query->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'exam-set-questions.index',
            compact('examSetQuestions')
        );
    }

    public function create()
    {
        $batches = Batch::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view(
            'exam-set-questions.create',
            compact('batches')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_id' => [
                'required',
                'exists:batches,id',
            ],
            'exam_id' => [
                'required',
                'exists:exams,id',
            ],
            'exam_set_id' => [
                'required',
                'exists:exam_sets,id',
            ],
        ]);

        $exam = Exam::query()
            ->where('id', $validated['exam_id'])
            ->where('batch_id', $validated['batch_id'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->first();

        if (!$exam) {
            throw ValidationException::withMessages([
                'exam_id' =>
                    'The selected exam does not belong to the selected batch.',
            ]);
        }

        $examSet = ExamSet::query()
            ->where('id', $validated['exam_set_id'])
            ->where('exam_id', $exam->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->first();

        if (!$examSet) {
            throw ValidationException::withMessages([
                'exam_set_id' =>
                    'The selected exam set does not belong to the selected exam.',
            ]);
        }

        $assignments = ExamSetCompetencyUnit::query()
            ->with('competencyUnit')
            ->where('exam_set_id', $examSet->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->get();

        if ($assignments->isEmpty()) {
            throw ValidationException::withMessages([
                'exam_set_id' =>
                    'No competency units are assigned to this exam set.',
            ]);
        }

        DB::transaction(function () use (
            $assignments,
            $examSet,
            $exam
        ) {
            foreach ($assignments as $assignment) {
                $requiredCount = (int) $assignment->question_count;

                if ($requiredCount <= 0) {
                    continue;
                }

                $availableCount = Question::query()
                    ->where('course_id', $exam->course_id)
                    ->whereHas('element', function ($query) use ($assignment) {
                        $query->where(
                            'competency_unit_id',
                            $assignment->competency_unit_id
                        );
                    })
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->count();

                if ($availableCount < $requiredCount) {
                    $code = $assignment->competencyUnit->code ?? 'Unknown';

                    throw ValidationException::withMessages([
                        'exam_set_id' =>
                            "Not enough active questions available for competency unit {$code}. Required: {$requiredCount}, Available: {$availableCount}.",
                    ]);
                }
            }

            ExamSetQuestion::withTrashed()
                ->where('exam_set_id', $examSet->id)
                ->forceDelete();

            $order = 1;

            foreach ($assignments as $assignment) {
                $requiredCount = (int) $assignment->question_count;

                if ($requiredCount <= 0) {
                    continue;
                }

                $questions = Question::query()
                    ->where('course_id', $exam->course_id)
                    ->whereHas('element', function ($query) use ($assignment) {
                        $query->where(
                            'competency_unit_id',
                            $assignment->competency_unit_id
                        );
                    })
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->inRandomOrder()
                    ->limit($requiredCount)
                    ->get();

                if ($questions->count() < $requiredCount) {
                    $code = $assignment->competencyUnit->code ?? 'Unknown';

                    throw ValidationException::withMessages([
                        'exam_set_id' =>
                            "Not enough active questions available for competency unit {$code}. Required: {$requiredCount}, Available: {$questions->count()}.",
                    ]);
                }

                foreach ($questions as $question) {
                    $examSetQuestion = new ExamSetQuestion();

                    $examSetQuestion->exam_set_id = $examSet->id;
                    $examSetQuestion->question_id = $question->id;
                    $examSetQuestion->question_order = $order;
                    $examSetQuestion->is_active = true;

                    $examSetQuestion->save();

                    $order++;
                }
            }
        });

        return redirect()
            ->route('exam-set-questions.index')
            ->with(
                'success',
                'Questions generated successfully.'
            );
    }

    public function show(ExamSetQuestion $examSetQuestion)
    {
        $examSetQuestion->load([
            'examSet.exam.batch',
            'examSet.exam.course',
            'question.element.competencyUnit.module',
        ]);

        return view(
            'exam-set-questions.show',
            compact('examSetQuestion')
        );
    }

    public function edit(ExamSetQuestion $examSetQuestion)
    {
        $examSetQuestion->load([
            'examSet.exam.batch',
            'examSet.exam.course',
            'question.element.competencyUnit.module',
        ]);

        return view(
            'exam-set-questions.edit',
            compact('examSetQuestion')
        );
    }

    public function update(
        Request $request,
        ExamSetQuestion $examSetQuestion
    ) {
        $validated = $request->validate([
            'question_order' => [
                'required',
                'integer',
                'min:1',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $request,
            $examSetQuestion
        ) {
            $newOrder = (int) $validated['question_order'];

            $questions = ExamSetQuestion::query()
                ->where(
                    'exam_set_id',
                    $examSetQuestion->exam_set_id
                )
                ->whereNull('deleted_at')
                ->orderBy('question_order')
                ->get();

            $totalQuestions = $questions->count();

            if ($newOrder > $totalQuestions) {
                throw ValidationException::withMessages([
                    'question_order' =>
                        "Question order cannot be greater than {$totalQuestions}.",
                ]);
            }

            $questions = $questions
                ->reject(function ($item) use ($examSetQuestion) {
                    return $item->id === $examSetQuestion->id;
                })
                ->values();

            $questions->splice(
                $newOrder - 1,
                0,
                [$examSetQuestion]
            );

            $offset = 1000000;

            foreach ($questions as $index => $question) {
                $question->question_order =
                    $offset + $index + 1;

                $question->save();
            }

            foreach ($questions as $index => $question) {
                $question->question_order = $index + 1;

                if ($question->id === $examSetQuestion->id) {
                    $question->is_active =
                        $request->boolean('is_active');
                }

                $question->save();
            }
        });

        return redirect()
            ->route('exam-set-questions.index')
            ->with(
                'success',
                'Exam set question updated successfully.'
            );
    }

    public function destroy(
        ExamSetQuestion $examSetQuestion
    ) {
        $examSetQuestion->delete();

        return redirect()
            ->route('exam-set-questions.index')
            ->with(
                'success',
                'Question removed from exam set successfully.'
            );
    }

    public function deleted()
    {
        $examSetQuestions = ExamSetQuestion::onlyTrashed()
            ->with([
                'examSet.exam.batch',
                'examSet.exam.course',
                'question.element.competencyUnit.module',
            ])
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'exam-set-questions.deleted',
            compact('examSetQuestions')
        );
    }

    public function restore($id)
    {
        $examSetQuestion = ExamSetQuestion::onlyTrashed()
            ->findOrFail($id);

        DB::transaction(function () use ($examSetQuestion) {
            $examSetId = $examSetQuestion->exam_set_id;

            $maxOrder = ExamSetQuestion::withTrashed()
                ->where('exam_set_id', $examSetId)
                ->where('id', '!=', $examSetQuestion->id)
                ->max('question_order');

            $examSetQuestion->question_order =
                ((int) $maxOrder) + 1;

            $examSetQuestion->is_active = true;

            $examSetQuestion->restore();
            $examSetQuestion->save();
        });

        return redirect()
            ->route('exam-set-questions.deleted')
            ->with(
                'success',
                'Exam set question restored successfully.'
            );
    }

    public function forceDelete($id)
    {
        $examSetQuestion = ExamSetQuestion::withTrashed()
            ->findOrFail($id);

        $examSetQuestion->forceDelete();

        return redirect()
            ->route('exam-set-questions.deleted')
            ->with(
                'success',
                'Exam set question permanently deleted.'
            );
    }

    public function getExamsByBatch(Request $request)
    {
        $request->validate([
            'batch_id' => [
                'required',
                'exists:batches,id',
            ],
        ]);

        $exams = Exam::query()
            ->where(
                'batch_id',
                $request->batch_id
            )
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('title')
            ->get([
                'id',
                'title',
            ]);

        return response()->json($exams);
    }

    public function getExamSetsByExam($examId)
    {
        $examSets = ExamSet::query()
            ->where('exam_id', $examId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('set_number')
            ->get([
                'id',
                'name',
                'set_number',
            ]);

        return response()->json($examSets);
    }

    public function getQuestionsByExamSet($examSetId)
    {
        $examSet = ExamSet::query()
            ->with('exam')
            ->where('id', $examSetId)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $assignments = ExamSetCompetencyUnit::query()
            ->with('competencyUnit')
            ->where('exam_set_id', $examSet->id)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->get();

        $result = [];

        foreach ($assignments as $assignment) {
            $result[] = [
                'id' => $assignment->id,
                'competency_unit_id' =>
                    $assignment->competency_unit_id,
                'competency_unit' =>
                    $assignment->competencyUnit,
                'required_count' =>
                    $assignment->question_count,
            ];
        }

        return response()->json([
            'exam_set' => $examSet,
            'assignments' => $result,
        ]);
    }
}

