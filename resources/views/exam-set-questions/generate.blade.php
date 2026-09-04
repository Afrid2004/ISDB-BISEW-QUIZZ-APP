@extends('layouts.backend.app')

@section('content')

    <div class="space-y-6">


        <div class="flex items-center justify-between gap-4">

            <div>
                <h1 class="text-xl font-bold text-slate-800">
                    Generate Exam
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Generate questions for this exam set.
                </p>
            </div>

            <a href="{{ route('exams.show', $examSet->exam_id) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">

                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600">
                        {{ $error }}
                    </p>
                @endforeach

            </div>
        @endif

        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div>
                <h2 class="text-base font-semibold text-slate-800">
                    Exam Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Information for this exam set.
                </p>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">

                <div>
                    <p class="text-xs text-slate-400">
                        Exam
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $examSet->exam->title }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400">
                        Batch
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $examSet->exam->batch->name ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400">
                        Exam Set
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $examSet->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400">
                        Mode
                    </p>

                    <span class="mt-1 inline-flex rounded-lg bg-primary/5 px-3 py-1.5 text-sm font-semibold text-primary">
                        {{ ucfirst($examSet->mode) }}
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-400">
                        Total Marks
                    </p>

                    <p class="mt-1 text-lg font-bold text-primary">
                        {{ $examSet->total_marks }}
                    </p>
                </div>

            </div>

        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-base font-semibold text-slate-800">
                        Question Distribution
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Required questions for each competency unit.
                    </p>
                </div>

                <form action="{{ route('exam-set-questions.generate.store', $examSet->id) }}" method="POST">

                    @csrf

                    <button type="submit"
                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90 sm:w-auto">
                        <i class="bi bi-shuffle"></i>
                        Generate
                    </button>

                </form>

            </div>

            <div class="mt-5 space-y-3">

                @forelse ($assignments as $assignment)
                    <div
                        class="flex flex-col gap-4 rounded-lg border border-slate-200 bg-slate-50 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="min-w-0">

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $assignment->competencyUnit->code ?? 'N/A' }}
                                —
                                {{ $assignment->competencyUnit->module->name ?? 'N/A' }}
                            </p>

                        </div>

                        <div class="flex items-center gap-6">

                            <div class="text-right">

                                <p class="text-xs text-slate-400">
                                    Required Questions
                                </p>

                                <p class="mt-1 text-sm font-bold text-primary">
                                    {{ $assignment->question_count }}
                                </p>

                            </div>

                            <div class="text-right">

                                <p class="text-xs text-slate-400">
                                    Available Questions
                                </p>

                                <p class="mt-1 text-sm font-bold text-slate-700">
                                    {{ $assignment->available_questions }}
                                </p>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="rounded-lg border border-dashed border-slate-300 px-4 py-8 text-center">

                        <p class="text-sm text-slate-400">
                            No competency units assigned to this exam set.
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-base font-semibold text-slate-800">
                        Generated Questions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Questions currently assigned to this exam set.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">

                    <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-semibold text-slate-600">
                        {{ $generatedQuestions->count() }} Questions
                    </span>

                    @if ($generatedQuestions->count())
                        <a href="{{ route('exam-set-questions.question-copy-pdf', $examSet->id) }}" target="_blank"
                            title="Question Copy PDF"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-primary/30 bg-primary/10 px-4 py-2.5 text-sm font-bold text-primary transition hover:border-primary/50 hover:bg-primary/15 hover:shadow">
                            <i class="bi bi-file-earmark-text-fill text-base"></i>
                            <span>Question Copy</span>
                        </a>

                        <a href="{{ route('exam-set-questions.answer-copy-pdf', $examSet->id) }}" target="_blank"
                            title="Answer Copy PDF"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-primary/30 bg-primary px-4 py-2.5 text-sm font-bold text-white transition hover:bg-primary/90 hover:shadow">
                            <i class="bi bi-file-earmark-check-fill text-base"></i>
                            <span>Answer Copy</span>
                        </a>
                    @endif

                </div>

            </div>

            <div class="mt-5 space-y-4">

                @forelse ($generatedQuestions as $index => $examSetQuestion)
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-primary text-sm font-bold text-white">
                                {{ $index + 1 }}
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">

                                    <span class="rounded-md bg-white px-2 py-1 text-xs font-medium text-slate-500">
                                        {{ $examSetQuestion->question->element->competencyUnit->code ?? 'N/A' }}
                                    </span>

                                    <span class="rounded-md bg-white px-2 py-1 text-xs font-medium text-slate-500">
                                        {{ $examSetQuestion->question->marks }} Marks
                                    </span>

                                    <span class="rounded-md bg-white px-2 py-1 text-xs font-medium text-slate-500">
                                        {{ ucfirst($examSetQuestion->question->difficulty_level) }}
                                    </span>

                                </div>

                                <p class="mt-3 text-sm font-medium leading-6 text-slate-700">
                                    <strong>
                                        {{ $examSetQuestion->question->question_text }}
                                    </strong>
                                </p>

                                @if ($examSetQuestion->question->question_type === 'multiple_choice')
                                    <p class="mt-1 text-xs font-semibold text-primary">
                                        Select
                                        {{ $examSetQuestion->question->options->where('is_correct', true)->count() }}
                                        answers </p>
                                @endif



                                @if ($examSetQuestion->question->options->count())
                                    <div class="mt-3 space-y-2">

                                        @foreach ($examSetQuestion->question->options as $option)
                                            <div
                                                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600">
                                                {{ chr(65 + $loop->index) }}.
                                                {{ $option->option }}
                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="rounded-lg border border-dashed border-slate-300 px-4 py-12 text-center">

                        <i class="bi bi-file-earmark-question text-3xl text-slate-300"></i>

                        <p class="mt-3 text-sm font-medium text-slate-500">
                            No questions generated yet.
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Click the Generate button to generate questions.
                        </p>

                    </div>
                @endforelse

            </div>

        </div>


    </div>

@endsection
