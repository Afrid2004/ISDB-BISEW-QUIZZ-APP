@extends('layouts.backend.app')

@section('content') <div class="min-h-screen bg-[#f7f8fc]">


    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Exam Set Questions
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage questions assigned to your exam sets.
            </p>
        </div>

        <div class="flex items-center gap-2">

            {{-- Deleted Questions --}}
            <a href="{{ route('exam-set-questions.deleted') }}"
                class="inline-flex items-center justify-center gap-2
                       rounded-lg border border-slate-200 bg-white
                       px-4 py-2.5 text-sm font-semibold text-slate-600
                       shadow-sm transition
                       hover:border-red-200 hover:bg-red-50
                       hover:text-red-500
                       focus:outline-none focus:ring-2
                       focus:ring-red-200">

                <i class="bi bi-trash3 text-sm"></i>
                Deleted
            </a>

            {{-- Generate Questions --}}
            <a href="{{ route('exam-set-questions.create') }}"
                class="inline-flex items-center justify-center gap-2
                       rounded-lg bg-primary px-5 py-2.5
                       text-sm font-semibold text-white
                       shadow-sm transition
                       hover:bg-primary/90
                       focus:outline-none focus:ring-2
                       focus:ring-primary/30
                       focus:ring-offset-2">

                <i class="bi bi-plus-lg text-sm"></i>
                Generate Questions
            </a>

        </div>
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        {{-- Card Header --}}
        <x-backend.card-header
            title="Exam Set Questions"
            :count="$examSetQuestions->total()"
            singular="question"
            plural="questions"
            action="{{ route('exam-set-questions.index') }}"
            placeholder="Search questions..."
        />

        {{-- Alerts --}}
        <x-_alerts class="m-3" />

        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="w-full min-w-[1250px] text-left">

                {{-- Table Header --}}
                <thead class="border-b border-slate-100 bg-slate-50/60">
                    <tr>

                        <th class="w-24 px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Order
                        </th>

                        <th class="min-w-[350px] px-5 py-3 text-[11px]
                                   font-bold uppercase tracking-wide
                                   text-slate-400">
                            Question
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Exam Set
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Exam
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Competency Unit
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Module
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Status
                        </th>

                        <th class="px-5 py-3 text-center text-[11px]
                                   font-bold uppercase tracking-wide
                                   text-slate-400">
                            Actions
                        </th>

                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse ($examSetQuestions as $examSetQuestion)

                        @php
                            $question = $examSetQuestion->question;
                            $element = $question?->element;
                            $competencyUnit = $element?->competencyUnit;
                            $module = $competencyUnit?->module;
                            $examSet = $examSetQuestion->examSet;
                            $exam = $examSet?->exam;
                        @endphp

                        <tr class="transition hover:bg-slate-50/70">

                            {{-- Order --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center
                                               justify-center rounded-lg
                                               bg-primary/10 text-sm font-bold
                                               text-primary">

                                        {{ sprintf('%02d', $examSetQuestion->question_order) }}

                                    </div>

                                    <span class="text-xs font-medium text-slate-400">
                                        Q{{ $examSetQuestion->question_order }}
                                    </span>

                                </div>

                            </td>

                            {{-- Question --}}
                            <td class="max-w-lg px-5 py-4">

                                @if ($question)

                                    <p class="line-clamp-2 text-sm font-medium
                                              leading-6 text-slate-700">

                                        {{ $question->question_text }}

                                    </p>

                                    <div class="mt-1.5 flex items-center gap-2">

                                        @if ($question->question_type)
                                            <span class="rounded-md bg-slate-100 px-2 py-0.5
                                                         text-[10px] font-semibold
                                                         uppercase text-slate-500">

                                                {{ str_replace('_', ' ', $question->question_type) }}

                                            </span>
                                        @endif

                                        @if ($question->marks !== null)
                                            <span class="text-[11px] text-slate-400">
                                                {{ $question->marks }} marks
                                            </span>
                                        @endif

                                    </div>

                                @else

                                    <p class="text-sm italic text-slate-400">
                                        Question not available
                                    </p>

                                @endif

                            </td>

                            {{-- Exam Set --}}
                            <td class="max-w-[180px] px-5 py-4">

                                @if ($examSet)

                                    <p class="truncate text-sm font-semibold text-slate-700">
                                        {{ $examSet->name }}
                                    </p>

                                    @if ($examSet->set_number !== null)
                                        <p class="mt-1 text-xs text-slate-400">
                                            Set {{ $examSet->set_number }}
                                        </p>
                                    @endif

                                @else

                                    <span class="text-sm text-slate-400">
                                        No Exam Set
                                    </span>

                                @endif

                            </td>

                            {{-- Exam --}}
                            <td class="max-w-[200px] px-5 py-4">

                                @if ($exam)

                                    <p class="truncate text-sm text-slate-700">
                                        {{ $exam->title }}
                                    </p>

                                    @if ($exam->batch)
                                        <p class="mt-1 truncate text-xs text-slate-400">
                                            {{ $exam->batch->name }}
                                        </p>
                                    @endif

                                @else

                                    <span class="text-sm text-slate-400">
                                        No Exam
                                    </span>

                                @endif

                            </td>

                            {{-- Competency Unit --}}
                            <td class="max-w-[180px] px-5 py-4">

                                @if ($competencyUnit)

                                    <span
                                        class="inline-flex items-center rounded-md
                                               bg-primary/10 px-2.5 py-1
                                               text-xs font-semibold text-primary">

                                        {{ $competencyUnit->code }}

                                    </span>

                                    @if ($element)
                                        <p class="mt-1.5 truncate text-xs text-slate-400">
                                            Element: {{ $element->name }}
                                        </p>
                                    @endif

                                @else

                                    <span class="text-sm text-slate-400">
                                        No Competency Unit
                                    </span>

                                @endif

                            </td>

                            {{-- Module --}}
                            <td class="max-w-[180px] px-5 py-4">

                                @if ($module)

                                    <p class="truncate text-sm text-slate-700">
                                        {{ $module->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Module {{ sprintf('%02d', $module->module_number) }}
                                    </p>

                                @else

                                    <span class="text-sm text-slate-400">
                                        No Module
                                    </span>

                                @endif

                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">

                                @if ($examSetQuestion->is_active)

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-emerald-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-emerald-600">

                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-emerald-500">
                                        </span>

                                        Active

                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-amber-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-amber-600">

                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-amber-500">
                                        </span>

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- View --}}
                                    <a href="{{ route('exam-set-questions.show', $examSetQuestion) }}"
                                        title="View Question"
                                        class="inline-flex h-8 w-8 items-center
                                               justify-center rounded-lg
                                               border border-slate-200
                                               bg-white text-slate-500
                                               transition
                                               hover:border-primary/30
                                               hover:bg-primary/10
                                               hover:text-primary">

                                        <i class="bi bi-eye text-sm"></i>

                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('exam-set-questions.edit', $examSetQuestion) }}"
                                        title="Edit Question"
                                        class="inline-flex h-8 w-8 items-center
                                               justify-center rounded-lg
                                               border border-slate-200
                                               bg-white text-slate-500
                                               transition
                                               hover:border-primary/30
                                               hover:bg-primary/10
                                               hover:text-primary">

                                        <i class="bi bi-pencil-square text-sm"></i>

                                    </a>

                                    {{-- Delete --}}
                                    <form method="POST"
                                        action="{{ route('exam-set-questions.destroy', $examSetQuestion) }}"
                                        data-item="exam set question"
                                        class="delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            title="Remove Question"
                                            class="inline-flex h-8 w-8 items-center
                                                   justify-center rounded-lg
                                                   border border-red-100
                                                   bg-red-50 text-red-500
                                                   transition
                                                   hover:bg-red-100
                                                   hover:text-red-600
                                                   cursor-pointer">

                                            <i class="bi bi-trash3 text-sm"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="px-5 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <div
                                        class="mb-3 flex h-12 w-12
                                               items-center justify-center
                                               rounded-full bg-slate-100">

                                        <i class="bi bi-question-circle
                                                  text-xl text-slate-400">
                                        </i>

                                    </div>

                                    <p class="text-sm font-medium text-slate-600">
                                        No exam set questions found
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Generate questions for an exam set to get started.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Mobile Cards --}}
        <div class="divide-y divide-slate-100 md:hidden">

            @forelse ($examSetQuestions as $examSetQuestion)

                @php
                    $question = $examSetQuestion->question;
                    $element = $question?->element;
                    $competencyUnit = $element?->competencyUnit;
                    $module = $competencyUnit?->module;
                    $examSet = $examSetQuestion->examSet;
                    $exam = $examSet?->exam;
                @endphp

                <div class="p-4">

                    {{-- Top --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="flex min-w-0 items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center
                                       justify-center rounded-lg
                                       bg-primary/10 text-sm font-bold
                                       text-primary">

                                {{ sprintf('%02d', $examSetQuestion->question_order) }}

                            </div>

                            <div class="min-w-0">

                                <p class="text-[11px] font-semibold uppercase
                                          tracking-wide text-slate-400">

                                    Question {{ $examSetQuestion->question_order }}

                                </p>

                                <h3 class="mt-0.5 truncate text-sm font-semibold text-slate-700">

                                    {{ $examSet?->name ?? 'No Exam Set' }}

                                </h3>

                            </div>

                        </div>

                        {{-- Status --}}
                        @if ($examSetQuestion->is_active)

                            <span
                                class="inline-flex shrink-0 items-center gap-1.5
                                       rounded-full bg-emerald-50 px-2.5 py-1
                                       text-xs font-semibold text-emerald-600">

                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                Active

                            </span>

                        @else

                            <span
                                class="inline-flex shrink-0 items-center gap-1.5
                                       rounded-full bg-amber-50 px-2.5 py-1
                                       text-xs font-semibold text-amber-600">

                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                Inactive

                            </span>

                        @endif

                    </div>

                    {{-- Question Text --}}
                    <div class="mt-4 rounded-lg border border-slate-100
                                bg-slate-50/60 p-3">

                        @if ($question)

                            <p class="text-sm leading-6 text-slate-700">
                                {{ $question->question_text }}
                            </p>

                            <div class="mt-2 flex flex-wrap items-center gap-2">

                                @if ($question->question_type)
                                    <span
                                        class="rounded-md bg-white px-2 py-1
                                               text-[10px] font-semibold
                                               uppercase text-slate-500">

                                        {{ str_replace('_', ' ', $question->question_type) }}

                                    </span>
                                @endif

                                @if ($question->marks !== null)
                                    <span class="text-[11px] text-slate-400">
                                        {{ $question->marks }} marks
                                    </span>
                                @endif

                            </div>

                        @else

                            <p class="text-sm italic text-slate-400">
                                Question not available
                            </p>

                        @endif

                    </div>

                    {{-- Information --}}
                    <div class="mt-4 grid grid-cols-1 gap-3">

                        {{-- Exam --}}
                        <div>

                            <p class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                Exam
                            </p>

                            <p class="mt-1 text-sm text-slate-600">
                                {{ $exam?->title ?? 'No Exam' }}
                            </p>

                            @if ($exam?->batch)
                                <p class="mt-0.5 text-xs text-slate-400">
                                    {{ $exam->batch->name }}
                                </p>
                            @endif

                        </div>

                        {{-- Competency Unit --}}
                        <div>

                            <p class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                Competency Unit
                            </p>

                            @if ($competencyUnit)

                                <span
                                    class="mt-1 inline-flex rounded-md
                                           bg-primary/10 px-2 py-1
                                           text-xs font-semibold text-primary">

                                    {{ $competencyUnit->code }}

                                </span>

                            @else

                                <p class="mt-1 text-sm text-slate-400">
                                    No Competency Unit
                                </p>

                            @endif

                        </div>

                        {{-- Element --}}
                        <div>

                            <p class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                Element
                            </p>

                            <p class="mt-1 text-sm text-slate-600">
                                {{ $element?->name ?? 'No Element' }}
                            </p>

                        </div>

                        {{-- Module --}}
                        <div>

                            <p class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                Module
                            </p>

                            <p class="mt-1 text-sm text-slate-600">
                                {{ $module?->name ?? 'No Module' }}
                            </p>

                        </div>

                    </div>

                    {{-- Created At --}}
                    <p class="mt-4 text-xs text-slate-400">

                        <i class="bi bi-calendar3 mr-1"></i>

                        {{ $examSetQuestion->created_at?->format('d M, Y') }}

                    </p>

                    {{-- Mobile Actions --}}
                    <div
                        class="mt-4 flex items-center gap-2
                               border-t border-slate-100 pt-4">

                        {{-- View --}}
                        <a href="{{ route('exam-set-questions.show', $examSetQuestion) }}"
                            class="inline-flex flex-1 items-center
                                   justify-center gap-2 rounded-lg
                                   border border-slate-200 bg-white
                                   px-3 py-2 text-xs font-semibold
                                   text-slate-600 transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary">

                            <i class="bi bi-eye"></i>
                            View

                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('exam-set-questions.edit', $examSetQuestion) }}"
                            class="inline-flex flex-1 items-center
                                   justify-center gap-2 rounded-lg
                                   border border-slate-200 bg-white
                                   px-3 py-2 text-xs font-semibold
                                   text-slate-600 transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary">

                            <i class="bi bi-pencil-square"></i>
                            Edit

                        </a>

                        {{-- Delete --}}
                        <form method="POST"
                            action="{{ route('exam-set-questions.destroy', $examSetQuestion) }}"
                            data-item="exam set question"
                            class="delete-form flex-1">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex w-full items-center
                                       justify-center gap-2 rounded-lg
                                       border border-red-100 bg-red-50
                                       px-3 py-2 text-xs font-semibold
                                       text-red-500 transition
                                       hover:bg-red-100
                                       hover:text-red-600">

                                <i class="bi bi-trash3"></i>
                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="px-4 py-12 text-center">

                    <div class="mb-3 flex justify-center">

                        <div
                            class="flex h-12 w-12 items-center justify-center
                                   rounded-full bg-slate-100">

                            <i class="bi bi-question-circle
                                      text-xl text-slate-400">
                            </i>

                        </div>

                    </div>

                    <p class="text-sm font-medium text-slate-600">
                        No exam set questions found
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Generate questions for an exam set to get started.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($examSetQuestions->hasPages())

            <div
                class="flex flex-col gap-4 border-t border-slate-100
                       px-4 py-4 sm:flex-row sm:items-center
                       sm:justify-between sm:px-5">

                {{-- Result Information --}}
                <p class="text-xs text-slate-500">

                    Showing

                    <span class="font-semibold text-slate-700">
                        {{ $examSetQuestions->firstItem() }}
                    </span>

                    <span class="px-0.5 text-slate-400">–</span>

                    <span class="font-semibold text-slate-700">
                        {{ $examSetQuestions->lastItem() }}
                    </span>

                    of

                    <span class="font-semibold text-slate-700">
                        {{ $examSetQuestions->total() }}
                    </span>

                    results

                </p>

                {{-- Pagination --}}
                <div class="overflow-x-auto">
                    {{ $examSetQuestions->onEachSide(1)->links() }}
                </div>

            </div>

        @endif

    </div>

</div>


@endsection

@push('scripts') <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
