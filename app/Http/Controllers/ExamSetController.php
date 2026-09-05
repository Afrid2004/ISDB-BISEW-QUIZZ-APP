<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamSetController extends Controller
{
    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', Rule::in(['mid', 'monthly'])],
            'question_type' => ['required', Rule::in(['mcq', 'evidence'])],
            'mode' => ['required', Rule::in(['online', 'offline'])],
            'status' => ['required', Rule::in(['draft', 'published', 'processing', 'completed', 'cancelled'])],
            'set_number' => ['required', 'integer', 'min:1', 'max:255', Rule::unique('exam_sets')->where(fn($query) => $query->where('exam_id', $exam->id)->where('type', $request->type))],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'total_marks' => ['required', 'numeric', 'min:0'],
            'pass_marks' => ['required', 'numeric', 'min:0'],
            'weight_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        if ($validated['pass_marks'] > $validated['total_marks']) {
            return back()->withInput()->withErrors(['pass_marks' => 'Pass marks cannot be greater than total marks.']);
        }

        $examSet = new ExamSet();
        $examSet->exam_id = $exam->id;
        $examSet->name = $validated['name'];
        $examSet->type = $validated['type'];
        $examSet->question_type = $validated['question_type'];
        $examSet->mode = $validated['mode'];
        $examSet->status = $validated['status'];
        $examSet->set_number = $validated['set_number'];
        $examSet->duration_minutes = $validated['duration_minutes'] ?? null;
        $examSet->total_marks = $validated['total_marks'];
        $examSet->pass_marks = $validated['pass_marks'];
        $examSet->weight_percentage = $validated['weight_percentage'];
        $examSet->shuffle_questions = $request->boolean('shuffle_questions');
        $examSet->shuffle_options = $request->boolean('shuffle_options');
        $examSet->is_active = $request->boolean('is_active');
        $examSet->save();

        return redirect()->route('exams.show', $exam)->with('success', 'Exam Set created successfully.');
    }

    public function update(Request $request, Exam $exam, ExamSet $examSet)
    {
        $this->ensureExamSetBelongsToExam($exam, $examSet);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', Rule::in(['mid', 'monthly'])],
            'question_type' => ['required', Rule::in(['mcq', 'evidence'])],
            'mode' => ['required', Rule::in(['online', 'offline'])],
            'status' => ['required', Rule::in(['draft', 'published', 'processing', 'completed', 'cancelled'])],
            'set_number' => ['required', 'integer', 'min:1', 'max:255', Rule::unique('exam_sets')->where(fn($query) => $query->where('exam_id', $exam->id)->where('type', $request->type))->ignore($examSet->id)],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'total_marks' => ['required', 'numeric', 'min:0'],
            'pass_marks' => ['required', 'numeric', 'min:0'],
            'weight_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        if ($validated['pass_marks'] > $validated['total_marks']) {
            return back()->withInput()->withErrors(['pass_marks' => 'Pass marks cannot be greater than total marks.']);
        }

        $examSet->name = $validated['name'];
        $examSet->type = $validated['type'];
        $examSet->question_type = $validated['question_type'];
        $examSet->mode = $validated['mode'];
        $examSet->status = $validated['status'];
        $examSet->set_number = $validated['set_number'];
        $examSet->duration_minutes = $validated['duration_minutes'] ?? null;
        $examSet->total_marks = $validated['total_marks'];
        $examSet->pass_marks = $validated['pass_marks'];
        $examSet->weight_percentage = $validated['weight_percentage'];
        $examSet->shuffle_questions = $request->boolean('shuffle_questions');
        $examSet->shuffle_options = $request->boolean('shuffle_options');
        $examSet->is_active = $request->boolean('is_active');
        $examSet->save();

        return redirect()->route('exams.show', $exam)->with('success', 'Exam Set updated successfully.');
    }

    public function destroy(Exam $exam, ExamSet $examSet)
    {
        $this->ensureExamSetBelongsToExam($exam, $examSet);

        $examSet->delete();

        return redirect()->route('exams.show', $exam)->with('success', 'Exam Set deleted successfully.');
    }

    private function ensureExamSetBelongsToExam(Exam $exam, ExamSet $examSet): void
    {
        abort_unless((int) $examSet->exam_id === (int) $exam->id, 404);
    }
}
