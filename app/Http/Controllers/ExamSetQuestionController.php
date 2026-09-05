<?php

namespace App\Http\Controllers;

use App\Models\ExamSet;
use App\Models\ExamSetQuestion;
use App\Models\ExamSetCompetencyUnit;
use App\Models\Question;
use Barryvdh\DomPDF\Facade\Pdf;
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
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->whereHas('element', function ($query) use ($assignment) {
                    $query->where(
                        'competency_unit_id',
                        $assignment->competency_unit_id
                    );
                })
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

    public function generate(ExamSet $examSet)
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
                'exam_set' =>
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
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->whereHas('element', function ($query) use ($assignment) {
                        $query->where(
                            'competency_unit_id',
                            $assignment->competency_unit_id
                        );
                    })
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
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->whereHas('element', function ($query) use ($assignment) {
                        $query->where(
                            'competency_unit_id',
                            $assignment->competency_unit_id
                        );
                    })
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
            ->route(
                'exam-set-questions.generate',
                $examSet->id
            )
            ->with(
                'success',
                'Questions generated successfully.'
            );
    }

    public function questionCopyPdf(ExamSet $examSet)
    {
        if (!$examSet->is_active || $examSet->deleted_at !== null) {
            abort(404);
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

        if ($generatedQuestions->isEmpty()) {
            throw ValidationException::withMessages([
                'exam_set' =>
                    'No questions have been generated for this exam set.',
            ]);
        }

        $pdf = Pdf::loadView(
            'exam-set-questions.question-copy-pdf',
            [
                'examSet' => $examSet,
                'generatedQuestions' => $generatedQuestions,
            ]
        );

        return $pdf->download(
            $examSet->name . '-question-copy.pdf'
        );
    }

    public function answerCopyPdf(ExamSet $examSet)
    {
        if (!$examSet->is_active || $examSet->deleted_at !== null) {
            abort(404);
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

        if ($generatedQuestions->isEmpty()) {
            throw ValidationException::withMessages([
                'exam_set' =>
                    'No questions have been generated for this exam set.',
            ]);
        }

        $pdf = Pdf::loadView(
            'exam-set-questions.answer-copy-pdf',
            [
                'examSet' => $examSet,
                'generatedQuestions' => $generatedQuestions,
            ]
        );

        return $pdf->download(
            $examSet->name . '-answer-copy.pdf'
        );
    }
}

