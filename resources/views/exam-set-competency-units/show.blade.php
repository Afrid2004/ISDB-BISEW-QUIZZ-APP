@extends('layouts.backend.app')

@section('content')


    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('exam-set-competency-units.index') }}" class="transition hover:text-primary">
                        Exam Set Competency Units
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>View</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    Competency Unit Assignment
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View exam set and competency unit assignment details.
                </p>

            </div>

            {{-- Back --}}
            <div>

                <a href="{{ route('exam-set-competency-units.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg
                       border border-slate-200 bg-white
                       px-4 py-2.5 text-sm font-medium
                       text-slate-600 transition
                       hover:bg-slate-50">

                    <i class="bi bi-arrow-left"></i>

                    Back

                </a>

            </div>

        </div>


        {{-- Main Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200
                bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="flex items-center justify-between
                    border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    {{-- Icon --}}
                    <div
                        class="flex h-10 w-10 items-center justify-center
                           rounded-lg bg-primary/10 text-primary">

                        <i class="bi bi-diagram-3 text-lg"></i>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Assignment Information
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Details of this exam set competency unit assignment.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Information --}}
            <div class="divide-y divide-slate-100">

                {{-- Exam Set --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Exam Set
                    </p>

                    @if ($examSetCompetencyUnit->examSet)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSetCompetencyUnit->examSet->name }}
                            </span>

                            <span
                                class="inline-flex items-center rounded-md
                                   bg-slate-100 px-2.5 py-1
                                   text-xs font-medium text-slate-600">

                                #{{ $examSetCompetencyUnit->examSet->id }}

                            </span>

                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No exam set available.
                        </p>
                    @endif

                </div>


                {{-- Exam --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Exam
                    </p>

                    @if ($examSetCompetencyUnit->examSet?->exam)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSetCompetencyUnit->examSet->exam->title }}
                            </span>

                            <span
                                class="inline-flex items-center rounded-md
                                   bg-slate-100 px-2.5 py-1
                                   text-xs font-medium text-slate-600">

                                #{{ $examSetCompetencyUnit->examSet->exam->id }}

                            </span>

                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No exam available.
                        </p>
                    @endif

                </div>


                {{-- Course --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Course
                    </p>

                    @if ($examSetCompetencyUnit->competencyUnit?->module?->course)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSetCompetencyUnit->competencyUnit->module->course->name }}
                            </span>

                            @if ($examSetCompetencyUnit->competencyUnit->module->course->code)
                                <span
                                    class="inline-flex items-center rounded-md
                                       bg-slate-100 px-2.5 py-1
                                       text-xs font-medium text-slate-600">

                                    {{ $examSetCompetencyUnit->competencyUnit->module->course->code }}

                                </span>
                            @endif

                        </div>
                    @elseif ($examSetCompetencyUnit->examSet?->exam?->course)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSetCompetencyUnit->examSet->exam->course->name }}
                            </span>

                            @if ($examSetCompetencyUnit->examSet->exam->course->code)
                                <span
                                    class="inline-flex items-center rounded-md
                                       bg-slate-100 px-2.5 py-1
                                       text-xs font-medium text-slate-600">

                                    {{ $examSetCompetencyUnit->examSet->exam->course->code }}

                                </span>
                            @endif

                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No course available.
                        </p>
                    @endif

                </div>


                {{-- Module --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Module
                    </p>

                    @if ($examSetCompetencyUnit->competencyUnit?->module)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSetCompetencyUnit->competencyUnit->module->name }}
                            </span>

                            <span
                                class="inline-flex items-center rounded-md
                                   bg-slate-100 px-2.5 py-1
                                   text-xs font-medium text-slate-600">

                                #{{ $examSetCompetencyUnit->competencyUnit->module->id }}

                            </span>

                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No module available.
                        </p>
                    @endif

                </div>


                {{-- Competency Unit --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Competency Unit
                    </p>

                    @if ($examSetCompetencyUnit->competencyUnit)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSetCompetencyUnit->competencyUnit->name }}
                            </span>

                            @if ($examSetCompetencyUnit->competencyUnit->code)
                                <span
                                    class="inline-flex items-center rounded-md
                                       bg-slate-100 px-2.5 py-1
                                       text-xs font-medium text-slate-600">

                                    {{ $examSetCompetencyUnit->competencyUnit->code }}

                                </span>
                            @endif

                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No competency unit available.
                        </p>
                    @endif

                </div>


                {{-- Question Count --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Question Count
                    </p>

                    <div class="flex items-center gap-2">

                        <div
                            class="flex h-9 w-9 items-center justify-center
                               rounded-lg bg-primary/10 text-primary">

                            <i class="bi bi-question-circle"></i>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-700">

                                {{ $examSetCompetencyUnit->question_count }}

                                {{ $examSetCompetencyUnit->question_count == 1 ? 'Question' : 'Questions' }}

                            </p>

                            <p class="text-xs text-slate-400">
                                Questions required from this competency unit
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Status --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Status
                    </p>

                    @if ($examSetCompetencyUnit->is_active)
                        <span
                            class="inline-flex items-center gap-1.5
                               rounded-full bg-emerald-50
                               px-3 py-1.5 text-xs font-semibold
                               text-emerald-600">

                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                            Active

                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5
                               rounded-full bg-slate-100
                               px-3 py-1.5 text-xs font-semibold
                               text-slate-500">

                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                            Inactive

                        </span>
                    @endif

                </div>


                {{-- Created At --}}
                <div
                    class="flex flex-col gap-2 px-5 py-5
                       sm:flex-row sm:items-center
                       sm:justify-between sm:px-6">

                    <div>

                        <p
                            class="text-xs font-semibold uppercase
                               tracking-wide text-slate-400">

                            Created At

                        </p>

                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-calendar3 text-primary"></i>

                        @if ($examSetCompetencyUnit->created_at)
                            {{ $examSetCompetencyUnit->created_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $examSetCompetencyUnit->created_at->format('h:i A') }}
                        @else
                            N/A
                        @endif

                    </div>

                </div>


                {{-- Updated At --}}
                <div
                    class="flex flex-col gap-2 px-5 py-5
                       sm:flex-row sm:items-center
                       sm:justify-between sm:px-6">

                    <div>

                        <p
                            class="text-xs font-semibold uppercase
                               tracking-wide text-slate-400">

                            Last Updated

                        </p>

                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-clock-history text-primary"></i>

                        @if ($examSetCompetencyUnit->updated_at)
                            {{ $examSetCompetencyUnit->updated_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $examSetCompetencyUnit->updated_at->format('h:i A') }}
                        @else
                            N/A
                        @endif

                    </div>

                </div>

            </div>


            {{-- Footer Actions --}}
            <div
                class="flex flex-col-reverse gap-3
                   border-t border-slate-100
                   px-5 py-4 sm:flex-row
                   sm:justify-end sm:px-6">

                {{-- Delete --}}
                <form data-item="exam set competency unit"
                    action="{{ route('exam-set-competency-units.destroy', $examSetCompetencyUnit) }}" method="POST"
                    class="delete-form flex-1">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex w-full items-center
                           justify-center gap-2 rounded-lg
                           border border-red-200 bg-white
                           px-4 py-2.5 text-sm font-semibold
                           text-red-500 transition
                           hover:bg-red-50
                           sm:w-auto cursor-pointer">

                        <i class="bi bi-trash3"></i>

                        Delete

                    </button>

                </form>


                {{-- Edit --}}
                <a href="{{ route('exam-set-competency-units.edit', $examSetCompetencyUnit) }}"
                    class="inline-flex items-center justify-center
                       gap-2 rounded-lg bg-primary
                       px-4 py-2.5 text-sm font-semibold
                       text-white transition
                       hover:bg-primary/90">

                    <i class="bi bi-pencil-square"></i>

                    Edit Assignment

                </a>

            </div>

        </div>

    </div>


@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
