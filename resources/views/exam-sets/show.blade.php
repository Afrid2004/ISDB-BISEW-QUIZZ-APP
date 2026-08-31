@extends('layouts.backend.app')

@section('content')


    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('exam-sets.index') }}" class="transition hover:text-primary">
                        Exam Sets
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>View</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    {{ $examSet->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View exam set information and details.
                </p>

            </div>

            {{-- Back --}}
            <div>

                <a href="{{ route('exam-sets.index') }}"
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

                        <i class="bi bi-collection text-lg"></i>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Exam Set Information
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Details of this exam set.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Information --}}
            <div class="divide-y divide-slate-100">

                {{-- Exam Set Title --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Exam Set Title
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $examSet->name ?: 'No title' }}
                    </p>

                </div>


                {{-- Exam --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Exam
                    </p>

                    @if ($examSet->exam)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSet->exam->title }}
                            </span>

                            <span
                                class="inline-flex items-center rounded-md
                                   bg-slate-100 px-2.5 py-1
                                   text-xs font-medium text-slate-600">

                                #{{ $examSet->exam->id }}

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

                    @if ($examSet->exam?->course)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSet->exam->course->name }}
                            </span>

                            @if ($examSet->exam->course->code)
                                <span
                                    class="inline-flex items-center rounded-md
                                       bg-slate-100 px-2.5 py-1
                                       text-xs font-medium text-slate-600">

                                    {{ $examSet->exam->course->code }}

                                </span>
                            @endif

                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No course available.
                        </p>
                    @endif

                </div>


                {{-- Batch --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Batch
                    </p>

                    @if ($examSet->exam?->batch)
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $examSet->exam->batch->name ?? 'Batch #' . $examSet->exam->batch->id }}
                            </span>

                            @if (isset($examSet->exam->batch->code) && $examSet->exam->batch->code)
                                <span
                                    class="inline-flex items-center rounded-md
                                       bg-slate-100 px-2.5 py-1
                                       text-xs font-medium text-slate-600">

                                    {{ $examSet->exam->batch->code }}

                                </span>
                            @endif

                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No batch available.
                        </p>
                    @endif

                </div>


                {{-- Questions --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Questions
                    </p>

                    <div class="flex items-center gap-2">

                        <div
                            class="flex h-9 w-9 items-center justify-center
                               rounded-lg bg-primary/10 text-primary">

                            <i class="bi bi-question-circle"></i>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $examSet->questions_count ?? ($examSet->questions?->count() ?? 0) }}
                                Questions
                            </p>

                            <p class="text-xs text-slate-400">
                                Total questions in this set
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Total Marks --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Total Marks
                    </p>

                    <div class="flex items-center gap-2">

                        <div
                            class="flex h-9 w-9 items-center justify-center
                               rounded-lg bg-primary/10 text-primary">

                            <i class="bi bi-award"></i>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-700">

                                {{ $examSet->total_marks ?? 0 }}

                                {{ ($examSet->total_marks ?? 0) == 1 ? 'Mark' : 'Marks' }}

                            </p>

                            <p class="text-xs text-slate-400">
                                Total marks of this set
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Duration --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Duration
                    </p>

                    <div class="flex items-center gap-2">

                        <div
                            class="flex h-9 w-9 items-center justify-center
                               rounded-lg bg-primary/10 text-primary">

                            <i class="bi bi-clock"></i>

                        </div>

                        <div>

                            @if ($examSet->duration)
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $examSet->duration }} minutes
                                </p>
                            @else
                                <p class="text-sm italic text-slate-400">
                                    No duration set.
                                </p>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- Status --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                          tracking-wide text-slate-400">
                        Status
                    </p>

                    @if ($examSet->is_active)
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

                        @if ($examSet->created_at)
                            {{ $examSet->created_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $examSet->created_at->format('h:i A') }}
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

                        <p class="text-xs font-semibold uppercase
                           tracking-wide text-slate-400">

                            Last Updated

                        </p>

                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-clock-history text-primary"></i>

                        @if ($examSet->updated_at)
                            {{ $examSet->updated_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $examSet->updated_at->format('h:i A') }}
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
                <form data-item="exam set" action="{{ route('exam-sets.destroy', $examSet) }}" method="POST"
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
                <a href="{{ route('exam-sets.edit', $examSet) }}"
                    class="inline-flex items-center justify-center
                       gap-2 rounded-lg bg-primary
                       px-4 py-2.5 text-sm font-semibold
                       text-white transition
                       hover:bg-primary/90">

                    <i class="bi bi-pencil-square"></i>

                    Edit Exam Set

                </a>

            </div>

        </div>

    </div>


@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
