@extends('layouts.backend.app')

@section('content')

<div class="min-h-screen bg-[#f7f8fc]">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Question Information
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage questions for your online exam management system.
            </p>
        </div>

        {{-- Add Question Button --}}
        <a
            href="{{ route('questions.create') }}"
            class="inline-flex items-center justify-center gap-2
                   rounded-lg bg-primary px-5 py-2.5
                   text-sm font-semibold text-white
                   shadow-sm transition
                   hover:bg-primary/90
                   focus:outline-none focus:ring-2
                   focus:ring-primary/30
                   focus:ring-offset-2"
        >
            <i class="bi bi-plus-lg text-sm"></i>
            Add Question
        </a>

    </div>


    {{-- Table Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        {{-- Card Header --}}
        <x-backend.card-header
            title="Questions"
            :count="$questions->total()"
            singular="question"
            plural="questions"
            action="{{ route('questions.index') }}"
            placeholder="Search questions..."
        />

        {{-- Alerts --}}
        <x-_alerts class="m-3" />


        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="w-full min-w-[1200px] text-left">

                {{-- Table Header --}}
                <thead class="border-b border-slate-100 bg-slate-50/60">

                    <tr>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Question
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Course
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Module
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Competency Unit
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Element
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Type
                        </th>

                        <th class="px-5 py-3 text-center text-[11px]
                                   font-bold uppercase tracking-wide
                                   text-slate-400">
                            Marks
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                            Difficulty
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

                    @forelse ($questions as $question)

                        <tr class="transition hover:bg-slate-50/70">

                            {{-- Question --}}
                            <td class="max-w-sm px-5 py-4">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center
                                               justify-center rounded-lg
                                               bg-primary/10 text-primary"
                                    >
                                        <i class="bi bi-question-lg text-sm"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p
                                            class="line-clamp-2 text-[13px]
                                                   font-semibold leading-5
                                                   text-slate-700"
                                        >
                                            {{ $question->question_text }}
                                        </p>

                                        <p class="mt-1 text-[11px] text-slate-400">
                                            #{{ $question->id }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Course --}}
                            <td class="max-w-[180px] px-5 py-4">

                                @if ($question->course_name)

                                    <p class="truncate text-sm text-slate-700">
                                        {{ $question->course_name }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        {{ $question->course_code }}
                                    </p>

                                @else

                                    <p class="text-sm text-slate-400">
                                        No Course
                                    </p>

                                @endif

                            </td>


                            {{-- Module --}}
                            <td class="px-5 py-4">

                                @if ($question->module_name)

                                    <div class="flex items-center gap-2">

                                        <div
                                            class="flex h-8 w-8 shrink-0
                                                   items-center justify-center
                                                   rounded-lg bg-slate-100
                                                   text-xs font-bold
                                                   text-slate-600"
                                        >
                                            {{ sprintf('%02d', $question->module_number) }}
                                        </div>

                                        <div>

                                            <p class="text-sm font-medium text-slate-700">
                                                Module
                                                {{ sprintf('%02d', $question->module_number) }}
                                            </p>

                                            <p
                                                class="max-w-[140px] truncate
                                                       text-xs text-slate-400"
                                            >
                                                {{ $question->module_name }}
                                            </p>

                                        </div>

                                    </div>

                                @else

                                    <span class="text-sm text-slate-400">
                                        No Module
                                    </span>

                                @endif

                            </td>


                            {{-- Competency Unit --}}
                            <td class="px-5 py-4">

                                @if ($question->competency_unit_code)

                                    <div>

                                        <span
                                            class="inline-flex items-center
                                                   rounded-md bg-primary/10
                                                   px-2.5 py-1 text-xs
                                                   font-semibold text-primary"
                                        >
                                            {{ $question->competency_unit_code }}
                                        </span>

                                        <p class="mt-1 text-[11px] text-slate-400">
                                            Unit
                                            {{ sprintf('%02d', $question->competency_unit_serial) }}
                                        </p>

                                    </div>

                                @else

                                    <span class="text-sm text-slate-400">
                                        No Unit
                                    </span>

                                @endif

                            </td>


                            {{-- Element --}}
                            <td class="max-w-[180px] px-5 py-4">

                                @if ($question->element_name)

                                    <p class="truncate text-sm text-slate-600">
                                        {{ $question->element_name }}
                                    </p>

                                @else

                                    <p class="text-sm text-slate-400">
                                        No Element
                                    </p>

                                @endif

                            </td>


                            {{-- Question Type --}}
                            <td class="px-5 py-4">

                                @if ($question->question_type === 'single_choice')

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-blue-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-blue-600"
                                    >
                                        <i class="bi bi-circle"></i>
                                        Single
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-violet-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-violet-600"
                                    >
                                        <i class="bi bi-check2-square"></i>
                                        Multiple
                                    </span>

                                @endif

                            </td>


                            {{-- Marks --}}
                            <td class="px-5 py-4 text-center">

                                <span
                                    class="inline-flex min-w-10
                                           items-center justify-center
                                           rounded-md bg-slate-100
                                           px-2 py-1 text-xs
                                           font-bold text-slate-600"
                                >
                                    {{ number_format($question->marks, 2) }}
                                </span>

                            </td>


                            {{-- Difficulty --}}
                            <td class="px-5 py-4">

                                @if ($question->difficulty_level === 'easy')

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-emerald-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-emerald-600"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-emerald-500"
                                        ></span>

                                        Easy
                                    </span>

                                @elseif ($question->difficulty_level === 'hard')

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-red-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-red-600"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-red-500"
                                        ></span>

                                        Hard
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-amber-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-amber-600"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-amber-500"
                                        ></span>

                                        Medium
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-4">

                                @if ($question->is_active)

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-emerald-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-emerald-600"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-emerald-500"
                                        ></span>

                                        Active
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-amber-50
                                               px-2.5 py-1 text-xs
                                               font-semibold text-amber-600"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-amber-500"
                                        ></span>

                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('questions.show', $question) }}"
                                        title="View Question"
                                        class="inline-flex h-8 w-8 items-center
                                               justify-center rounded-lg
                                               border border-slate-200
                                               bg-white text-slate-500
                                               transition
                                               hover:border-primary/30
                                               hover:bg-primary/10
                                               hover:text-primary"
                                    >
                                        <i class="bi bi-eye text-sm"></i>
                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('questions.edit', $question) }}"
                                        title="Edit Question"
                                        class="inline-flex h-8 w-8 items-center
                                               justify-center rounded-lg
                                               border border-slate-200
                                               bg-white text-slate-500
                                               transition
                                               hover:border-primary/30
                                               hover:bg-primary/10
                                               hover:text-primary"
                                    >
                                        <i class="bi bi-pencil-square text-sm"></i>
                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        method="POST"
                                        action="{{ route('questions.destroy', $question) }}"
                                        data-item="question"
                                        class="delete-form"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete Question"
                                            class="inline-flex h-8 w-8 cursor-pointer
                                                   items-center justify-center
                                                   rounded-lg border border-red-100
                                                   bg-red-50 text-red-500
                                                   transition hover:bg-red-100
                                                   hover:text-red-600"
                                        >
                                            <i class="bi bi-trash3 text-sm"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10" class="px-5 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <div
                                        class="mb-3 flex h-12 w-12
                                               items-center justify-center
                                               rounded-full bg-slate-100"
                                    >
                                        <i
                                            class="bi bi-question-circle
                                                   text-xl text-slate-400"
                                        ></i>
                                    </div>

                                    <p class="text-sm font-medium text-slate-600">
                                        No questions found
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Create your first question to get started.
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

            @forelse ($questions as $question)

                <div class="p-4">

                    {{-- Top --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="flex min-w-0 items-start gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0
                                       items-center justify-center
                                       rounded-lg bg-primary/10
                                       text-primary"
                            >
                                <i class="bi bi-question-lg"></i>
                            </div>

                            <div class="min-w-0">

                                <h3
                                    class="line-clamp-3 text-sm font-semibold
                                           leading-5 text-slate-700"
                                >
                                    {{ $question->question_text }}
                                </h3>

                                <p class="mt-1 text-xs text-slate-400">
                                    Question #{{ $question->id }}
                                </p>

                            </div>

                        </div>


                        {{-- Status --}}
                        @if ($question->is_active)

                            <span
                                class="inline-flex shrink-0 items-center gap-1.5
                                       rounded-full bg-emerald-50
                                       px-2.5 py-1 text-xs
                                       font-semibold text-emerald-600"
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                           bg-emerald-500"
                                ></span>

                                Active
                            </span>

                        @else

                            <span
                                class="inline-flex shrink-0 items-center gap-1.5
                                       rounded-full bg-amber-50
                                       px-2.5 py-1 text-xs
                                       font-semibold text-amber-600"
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                           bg-amber-500"
                                ></span>

                                Inactive
                            </span>

                        @endif

                    </div>


                    {{-- Details --}}
                    <div class="mt-4 grid grid-cols-2 gap-3">

                        {{-- Course --}}
                        <div class="rounded-lg bg-slate-50 p-3">

                            <p
                                class="text-[10px] font-bold uppercase
                                       tracking-wide text-slate-400"
                            >
                                Course
                            </p>

                            <p
                                class="mt-1 truncate text-xs font-semibold
                                       text-slate-600"
                            >
                                {{ $question->course_code ?? 'No Course' }}
                            </p>

                        </div>


                        {{-- Module --}}
                        <div class="rounded-lg bg-slate-50 p-3">

                            <p
                                class="text-[10px] font-bold uppercase
                                       tracking-wide text-slate-400"
                            >
                                Module
                            </p>

                            <p
                                class="mt-1 text-xs font-semibold
                                       text-slate-600"
                            >
                                @if ($question->module_number)

                                    Module
                                    {{ sprintf('%02d', $question->module_number) }}

                                @else

                                    No Module

                                @endif
                            </p>

                        </div>


                        {{-- Competency Unit --}}
                        <div class="rounded-lg bg-slate-50 p-3">

                            <p
                                class="text-[10px] font-bold uppercase
                                       tracking-wide text-slate-400"
                            >
                                Unit
                            </p>

                            <p
                                class="mt-1 truncate text-xs font-semibold
                                       text-slate-600"
                            >
                                {{ $question->competency_unit_code ?? 'No Unit' }}
                            </p>

                        </div>


                        {{-- Element --}}
                        <div class="rounded-lg bg-slate-50 p-3">

                            <p
                                class="text-[10px] font-bold uppercase
                                       tracking-wide text-slate-400"
                            >
                                Element
                            </p>

                            <p
                                class="mt-1 truncate text-xs font-semibold
                                       text-slate-600"
                            >
                                {{ $question->element_name ?? 'No Element' }}
                            </p>

                        </div>

                    </div>


                    {{-- Question Meta --}}
                    <div class="mt-4 flex flex-wrap items-center gap-2">

                        {{-- Type --}}
                        @if ($question->question_type === 'single_choice')

                            <span
                                class="inline-flex items-center gap-1.5
                                       rounded-full bg-blue-50
                                       px-2.5 py-1 text-xs
                                       font-semibold text-blue-600"
                            >
                                <i class="bi bi-circle"></i>
                                Single Choice
                            </span>

                        @else

                            <span
                                class="inline-flex items-center gap-1.5
                                       rounded-full bg-violet-50
                                       px-2.5 py-1 text-xs
                                       font-semibold text-violet-600"
                            >
                                <i class="bi bi-check2-square"></i>
                                Multiple Choice
                            </span>

                        @endif


                        {{-- Marks --}}
                        <span
                            class="inline-flex items-center gap-1.5
                                   rounded-full bg-slate-100
                                   px-2.5 py-1 text-xs
                                   font-semibold text-slate-600"
                        >
                            <i class="bi bi-award"></i>

                            {{ number_format($question->marks, 2) }}
                            Marks
                        </span>


                        {{-- Difficulty --}}
                        @if ($question->difficulty_level === 'easy')

                            <span
                                class="inline-flex items-center gap-1.5
                                       rounded-full bg-emerald-50
                                       px-2.5 py-1 text-xs
                                       font-semibold text-emerald-600"
                            >
                                Easy
                            </span>

                        @elseif ($question->difficulty_level === 'hard')

                            <span
                                class="inline-flex items-center gap-1.5
                                       rounded-full bg-red-50
                                       px-2.5 py-1 text-xs
                                       font-semibold text-red-600"
                            >
                                Hard
                            </span>

                        @else

                            <span
                                class="inline-flex items-center gap-1.5
                                       rounded-full bg-amber-50
                                       px-2.5 py-1 text-xs
                                       font-semibold text-amber-600"
                            >
                                Medium
                            </span>

                        @endif

                    </div>


                    {{-- Created At --}}
                    <p class="mt-3 text-xs text-slate-400">

                        <i class="bi bi-calendar3 mr-1"></i>

                        {{ $question->created_at?->format('d M, Y') }}

                    </p>


                    {{-- Mobile Actions --}}
                    <div
                        class="mt-4 flex items-center gap-2
                               border-t border-slate-100 pt-4"
                    >

                        {{-- View --}}
                        <a
                            href="{{ route('questions.show', $question) }}"
                            class="inline-flex flex-1 items-center
                                   justify-center gap-2 rounded-lg
                                   border border-slate-200 bg-white
                                   px-3 py-2 text-xs font-semibold
                                   text-slate-600 transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary"
                        >
                            <i class="bi bi-eye"></i>
                            View
                        </a>


                        {{-- Edit --}}
                        <a
                            href="{{ route('questions.edit', $question) }}"
                            class="inline-flex flex-1 items-center
                                   justify-center gap-2 rounded-lg
                                   border border-slate-200 bg-white
                                   px-3 py-2 text-xs font-semibold
                                   text-slate-600 transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary"
                        >
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </a>


                        {{-- Delete --}}
                        <form
                            method="POST"
                            action="{{ route('questions.destroy', $question) }}"
                            data-item="question"
                            class="delete-form flex-1"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex w-full cursor-pointer
                                       items-center justify-center gap-2
                                       rounded-lg border border-red-100
                                       bg-red-50 px-3 py-2
                                       text-xs font-semibold
                                       text-red-500 transition
                                       hover:bg-red-100
                                       hover:text-red-600"
                            >
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
                            class="flex h-12 w-12 items-center
                                   justify-center rounded-full
                                   bg-slate-100"
                        >
                            <i
                                class="bi bi-question-circle
                                       text-xl text-slate-400"
                            ></i>
                        </div>

                    </div>

                    <p class="text-sm font-medium text-slate-600">
                        No questions found
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Create your first question to get started.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if ($questions->hasPages())

            <div
                class="flex flex-col gap-4 border-t border-slate-100
                       px-4 py-4 sm:flex-row sm:items-center
                       sm:justify-between sm:px-5"
            >

                {{-- Result Information --}}
                <p class="text-xs text-slate-500">

                    Showing

                    <span class="font-semibold text-slate-700">
                        {{ $questions->firstItem() }}
                    </span>

                    <span class="px-0.5 text-slate-400">
                        –
                    </span>

                    <span class="font-semibold text-slate-700">
                        {{ $questions->lastItem() }}
                    </span>

                    of

                    <span class="font-semibold text-slate-700">
                        {{ $questions->total() }}
                    </span>

                    results

                </p>


                {{-- Pagination --}}
                <div class="overflow-x-auto">

                    {{ $questions->onEachSide(1)->links() }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection


@push('scripts')

<script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>

@endpush