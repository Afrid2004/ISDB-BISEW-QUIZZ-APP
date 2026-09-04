@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Exam Information
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage exams for your online exam management system.
                </p>
            </div>

            {{-- Add Exam Button --}}
            <a href="{{ route('exams.create') }}"
                class="inline-flex items-center justify-center gap-2
                   rounded-lg bg-primary px-5 py-2.5
                   text-sm font-semibold text-white
                   shadow-sm transition
                   hover:bg-primary/90
                   focus:outline-none focus:ring-2
                   focus:ring-primary/30
                   focus:ring-offset-2">

                <i class="bi bi-plus-lg text-sm"></i>
                Add Exam

            </a>

        </div>

        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Card Header --}}
            <x-backend.card-header title="Exams" :count="$exams->total()" singular="exam" plural="exams"
                action="{{ route('exams.index') }}" placeholder="Search exams..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1100px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            {{-- ID --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                ID
                            </th>

                            {{-- Exam --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Exam
                            </th>

                            {{-- Course --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Course
                            </th>

                            {{-- Batch --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Batch
                            </th>

                            {{-- Status --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                  uppercase tracking-wide text-slate-400">
                                Status
                            </th>

                            {{-- Created --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Created
                            </th>

                            {{-- Actions --}}
                            <th
                                class="px-5 py-3 text-center text-[11px]
                                   font-bold uppercase tracking-wide
                                   text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($exams as $exam)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- ID --}}
                                <td class="px-5 py-4">

                                    <div
                                        class="flex h-9 w-9 items-center
                                           justify-center rounded-lg
                                           bg-primary/10 text-sm
                                           font-bold text-primary">

                                        {{ $exam->id }}

                                    </div>

                                </td>

                                {{-- Exam --}}
                                <td class="max-w-sm px-5 py-4">

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-700">
                                            {{ $exam->title }}
                                        </p>

                                        @if ($exam->description)
                                            <p class="mt-1 truncate text-xs text-slate-400">
                                                {{ $exam->description }}
                                            </p>
                                        @else
                                            <p class="mt-1 text-xs italic text-slate-400">
                                                No description
                                            </p>
                                        @endif

                                    </div>

                                </td>

                                {{-- Course --}}
                                <td class="max-w-md px-5 py-4">

                                    @if ($exam->course)
                                        <div class="min-w-0">

                                            <p class="truncate text-sm text-slate-700">
                                                {{ $exam->course->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $exam->course->code ?? 'No Code' }}
                                            </p>

                                        </div>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Course
                                        </p>
                                    @endif

                                </td>

                                {{-- Batch --}}
                                <td class="max-w-md px-5 py-4">

                                    @if ($exam->batch)
                                        <div class="min-w-0">

                                            <p class="truncate text-sm text-slate-700">
                                                {{ $exam->batch->name ?? 'Batch #' . $exam->batch->id }}
                                            </p>

                                        </div>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Batch
                                        </p>
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">
                                    @if ($exam->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full
                   bg-emerald-50 px-2.5 py-1 text-xs font-semibold
                   text-emerald-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full
                   bg-slate-100 px-2.5 py-1 text-xs font-semibold
                   text-slate-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>



                                {{-- Created --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-500">
                                        {{ $exam->created_at?->format('d M, Y') }}
                                    </p>

                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">


                                        {{-- Manage Exam Sets --}}
                                        <a href="{{ route('exams.show', $exam) }}" title="Manage Exam Sets"
                                            class="inline-flex h-8 items-center justify-center gap-2 rounded-lg bg-primary px-3 text-sm font-medium text-white transition hover:bg-primary/90">
                                            <span>Manage Exam Sets</span>
                                            <i class="bi bi-arrow-right text-sm"></i>
                                        </a>



                                        {{-- Edit --}}
                                        <a href="{{ route('exams.edit', $exam) }}" title="Edit Exam"
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
                                        <form method="POST" action="{{ route('exams.destroy', $exam) }}" data-item="exam"
                                            class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Exam"
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

                                <td colspan="6" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12
                                               items-center justify-center
                                               rounded-full bg-slate-100">

                                            <i
                                                class="bi bi-file-earmark-x
                                                   text-xl text-slate-400">
                                            </i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No exams found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Create your first exam to get started.
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

                @forelse ($exams as $exam)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0
                                       items-center justify-center
                                       rounded-lg bg-primary/10
                                       text-sm font-bold text-primary">

                                    <i class="bi bi-file-earmark-text"></i>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-semibold text-slate-700">
                                        {{ $exam->title }}
                                    </h3>

                                    @if ($exam->course)
                                        <p class="mt-1 truncate text-xs text-slate-400">
                                            {{ $exam->course->name }}
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs italic text-slate-400">
                                            No course
                                        </p>
                                    @endif

                                </div>

                            </div>

                        </div>

                        {{-- Course & Batch --}}
                        <div class="mt-4 grid grid-cols-2 gap-3">

                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Course
                                </p>

                                <p class="mt-1 truncate text-xs font-medium text-slate-600">
                                    {{ $exam->course->name ?? 'No Course' }}
                                </p>

                                @if ($exam->course?->code)
                                    <p class="mt-0.5 truncate text-[11px] text-slate-400">
                                        {{ $exam->course->code }}
                                    </p>
                                @endif

                            </div>

                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Batch
                                </p>

                                <p class="mt-1 truncate text-xs font-medium text-slate-600">
                                    {{ $exam->batch->batch_number ?? 'Batch #' . ($exam->batch->id ?? '') }}
                                </p>

                                @if ($exam->batch?->name)
                                    <p class="mt-0.5 truncate text-[11px] text-slate-400">
                                        {{ $exam->batch->name }}
                                    </p>
                                @endif

                            </div>

                        </div>

                        {{-- Description --}}
                        @if ($exam->description)
                            <p class="mt-4 text-sm leading-6 text-slate-500">
                                {{ $exam->description }}
                            </p>
                        @else
                            <p class="mt-4 text-sm italic text-slate-400">
                                No description available
                            </p>
                        @endif

                        {{-- Created At --}}
                        <p class="mt-3 text-xs text-slate-400">

                            <i class="bi bi-calendar3 mr-1"></i>

                            {{ $exam->created_at?->format('d M, Y') }}

                        </p>

                        {{-- Mobile Actions --}}
                        <div
                            class="mt-4 flex items-center gap-2
                               border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('exams.show', $exam) }}"
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
                            <a href="{{ route('exams.edit', $exam) }}"
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
                            <form method="POST" action="{{ route('exams.destroy', $exam) }}" data-item="exam"
                                class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex w-full items-center
                                       justify-center gap-2 rounded-lg
                                       border border-red-100
                                       bg-red-50 px-3 py-2
                                       text-xs font-semibold
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
                                class="flex h-12 w-12 items-center
                                   justify-center rounded-full
                                   bg-slate-100">

                                <i
                                    class="bi bi-file-earmark-x
                                       text-xl text-slate-400">
                                </i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No exams found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Create your first exam to get started.
                        </p>

                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($exams->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100
                       px-4 py-4 sm:flex-row sm:items-center
                       sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $exams->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">–</span>

                        <span class="font-semibold text-slate-700">
                            {{ $exams->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $exams->total() }}
                        </span>

                        results

                    </p>

                    {{-- Pagination --}}
                    <div class="overflow-x-auto">

                        {{ $exams->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
