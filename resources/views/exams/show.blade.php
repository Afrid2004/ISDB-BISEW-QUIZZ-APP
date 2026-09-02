@extends('layouts.backend.app')
@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">
        {{-- =========================================================
             PAGE HEADER
        ========================================================== --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">
                    <a href="{{ route('exams.index') }}" class="transition hover:text-primary">
                        Exams
                    </a>
                    <i class="bi bi-chevron-right text-[9px]"></i>
                    <span>View</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-800">
                    {{ $exam->title }}
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    View exam information and details.
                </p>
            </div>
            {{-- Back --}}
            <div>
                <a href="{{ route('exams.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        {{-- =========================================================
             EXAM INFORMATION
        ========================================================== --}}
        <div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            {{-- Card Header --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3">
                    {{-- Icon --}}
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                        <i class="bi bi-file-earmark-text text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Exam Information
                        </h2>
                        <p class="mt-0.5 text-xs text-slate-400">
                            Details of this exam.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Information --}}
            <div class="divide-y divide-slate-100">
                {{-- Exam Title --}}
                <div class="px-5 py-5 sm:px-6">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Exam Title
                    </p>
                    <p class="text-sm font-semibold text-slate-700">
                        {{ $exam->title ?: 'No title' }}
                    </p>
                </div>
                {{-- Course --}}
                <div class="px-5 py-5 sm:px-6">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Course
                    </p>
                    @if ($exam->course)
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-semibold text-slate-700">
                                {{ $exam->course->name }}
                            </span>
                            @if ($exam->course->code)
                                <span
                                    class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                    {{ $exam->course->code }}
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
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Batch
                    </p>
                    @if ($exam->batch)
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-semibold text-slate-700">
                                {{ $exam->batch->name ?? 'Batch #' . $exam->batch->id }}
                            </span>
                            @if (isset($exam->batch->code) && $exam->batch->code)
                                <span
                                    class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                    {{ $exam->batch->code }}
                                </span>
                            @endif
                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No batch available.
                        </p>
                    @endif
                </div>
                {{-- Description --}}
                <div class="px-5 py-5 sm:px-6">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Description
                    </p>
                    @if ($exam->description)
                        <p class="text-sm leading-6 text-slate-600">
                            {{ $exam->description }}
                        </p>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No description available.
                        </p>
                    @endif
                </div>
                {{-- Created At --}}
                <div class="flex flex-col gap-2 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Created At
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i class="bi bi-calendar3 text-primary"></i>
                        @if ($exam->created_at)
                            {{ $exam->created_at->format('d M, Y') }}
                            <span class="text-slate-300">•</span>
                            {{ $exam->created_at->format('h:i A') }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                {{-- Updated At --}}
                <div class="flex flex-col gap-2 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Last Updated
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i class="bi bi-clock-history text-primary"></i>
                        @if ($exam->updated_at)
                            {{ $exam->updated_at->format('d M, Y') }}
                            <span class="text-slate-300">•</span>
                            {{ $exam->updated_at->format('h:i A') }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
            </div>
            {{-- Footer Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                {{-- Delete --}}
                <form data-item="exam" action="{{ route('exams.destroy', $exam) }}" method="POST"
                    class="delete-form flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-500 transition hover:bg-red-50 sm:w-auto">
                        <i class="bi bi-trash3"></i>
                        Delete
                    </button>
                </form>
                {{-- Edit --}}
                <a href="{{ route('exams.edit', $exam) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                    <i class="bi bi-pencil-square"></i>
                    Edit Exam
                </a>
            </div>
        </div>
        {{-- =========================================================
             EXAM SETS
        ========================================================== --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            {{-- Exam Sets Header --}}
            <div
                class="flex flex-col gap-4 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                        <i class="bi bi-collection text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Exam Sets
                        </h2>
                        <p class="mt-0.5 text-xs text-slate-400">
                            Manage exam sets for this exam.
                        </p>
                    </div>
                </div>
                {{-- Create Button --}}
                <button type="button" onclick="openExamSetCreateModal()"
                    class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                    <i class="bi bi-plus-lg"></i>
                    Create Exam Set
                </button>
            </div>
            {{-- =====================================================
                 DESKTOP TABLE
            ====================================================== --}}
            @if ($exam->examSets->count())
                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full text-left">
                        <thead class="border-b border-slate-100 bg-slate-50">
                            <tr>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    #
                                </th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Name
                                </th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Type
                                </th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Question
                                </th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Mode
                                </th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Marks
                                </th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Status
                                </th>
                                <th
                                    class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($exam->examSets as $examSet)
                                <tr class="transition hover:bg-slate-50">
                                    {{-- Number --}}
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                                        {{ $examSet->set_number }}
                                    </td>
                                    {{-- Name --}}
                                    <td class="px-5 py-4">
                                        <div class="text-sm font-semibold text-slate-700">
                                            {{ $examSet->name }}
                                        </div>
                                        @if ($examSet->duration_minutes)
                                            <div class="mt-1 text-xs text-slate-400">
                                                <i class="bi bi-clock mr-1"></i>
                                                {{ $examSet->duration_minutes }} minutes
                                            </div>
                                        @endif
                                    </td>
                                    {{-- Type --}}
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span
                                            class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium capitalize text-slate-600">
                                            {{ $examSet->type }}
                                        </span>
                                    </td>
                                    {{-- Question Type --}}
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span
                                            class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium uppercase text-slate-600">
                                            {{ $examSet->question_type }}
                                        </span>
                                    </td>
                                    {{-- Mode --}}
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="text-sm capitalize text-slate-600">
                                            {{ $examSet->mode }}
                                        </span>
                                    </td>
                                    {{-- Marks --}}
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <div class="text-sm font-medium text-slate-700">
                                            {{ number_format($examSet->total_marks, 2) }}
                                        </div>
                                        <div class="mt-1 text-xs text-slate-400">
                                            Pass:
                                            {{ number_format($examSet->pass_marks, 2) }}
                                        </div>
                                    </td>
                                    {{-- Status --}}
                                    <td class="whitespace-nowrap px-5 py-4">
                                        @php
                                            $statusClasses = match ($examSet->status) {
                                                'published' => 'bg-green-50 text-green-600',
                                                'completed' => 'bg-blue-50 text-blue-600',
                                                'processing' => 'bg-amber-50 text-amber-600',
                                                'cancelled' => 'bg-red-50 text-red-600',
                                                default => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClasses }}">
                                            {{ $examSet->status }}
                                        </span>
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- View --}}
                                            <button type="button" onclick="openExamSetViewModal({{ $examSet->id }})"
                                                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/5 hover:text-primary"
                                                title="View">

                                                <i class="bi bi-eye"></i>

                                            </button>
                                            {{-- Edit --}}
                                            <button type="button" onclick="openExamSetEditModal({{ $examSet->id }})"
                                                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/5 hover:text-primary"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            {{-- Delete --}}
                                            <form action="{{ route('exams.exam-sets.destroy', [$exam, $examSet]) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-red-200 bg-white text-red-500 transition hover:bg-red-50"
                                                    title="Delete">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- =================================================
                     MOBILE CARDS
                ================================================== --}}
                <div class="divide-y divide-slate-100 md:hidden">
                    @foreach ($exam->examSets as $examSet)
                        <div class="p-5">
                            <div class="mb-4 flex items-start justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-xs font-bold text-primary">
                                            {{ $examSet->set_number }}
                                        </span>
                                        <h3 class="text-sm font-semibold text-slate-700">
                                            {{ $examSet->name }}
                                        </h3>
                                    </div>
                                    @if ($examSet->duration_minutes)
                                        <p class="mt-2 text-xs text-slate-400">
                                            <i class="bi bi-clock mr-1"></i>
                                            {{ $examSet->duration_minutes }} minutes
                                        </p>
                                    @endif
                                </div>
                                @php
                                    $statusClasses = match ($examSet->status) {
                                        'published' => 'bg-green-50 text-green-600',
                                        'completed' => 'bg-blue-50 text-blue-600',
                                        'processing' => 'bg-amber-50 text-amber-600',
                                        'cancelled' => 'bg-red-50 text-red-600',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp
                                <span
                                    class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClasses }}">
                                    {{ $examSet->status }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Type
                                    </p>
                                    <p class="mt-1 text-sm font-medium capitalize text-slate-600">
                                        {{ $examSet->type }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Question
                                    </p>
                                    <p class="mt-1 text-sm font-medium uppercase text-slate-600">
                                        {{ $examSet->question_type }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Mode
                                    </p>
                                    <p class="mt-1 text-sm font-medium capitalize text-slate-600">
                                        {{ $examSet->mode }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Total Marks
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-600">
                                        {{ number_format($examSet->total_marks, 2) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Pass Marks
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-600">
                                        {{ number_format($examSet->pass_marks, 2) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Weight
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-600">
                                        {{ number_format($examSet->weight_percentage, 2) }}%
                                    </p>
                                </div>
                            </div>
                            {{-- Mobile Actions --}}
                            <div class="mt-5 flex gap-2 border-t border-slate-100 pt-4">
                                {{-- View --}}
                                <button type="button" onclick="openExamSetViewModal({{ $examSet->id }})"
                                    class="inline-flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

                                    <i class="bi bi-eye"></i>

                                    View

                                </button>
                                <button type="button" onclick="openExamSetEditModal({{ $examSet->id }})"
                                    class="inline-flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                    <i class="bi bi-pencil-square"></i>
                                    Edit
                                </button>
                                <form action="{{ route('exams.exam-sets.destroy', [$exam, $examSet]) }}" method="POST"
                                    class="delete-form flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-semibold text-red-500 transition hover:bg-red-50">
                                        <i class="bi bi-trash3"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="px-5 py-12 text-center sm:px-6">
                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <i class="bi bi-collection text-2xl"></i>
                    </div>
                    <h3 class="mt-4 text-sm font-semibold text-slate-700">
                        No Exam Sets Found
                    </h3>
                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-400">
                        This exam does not have any exam sets yet. Create an exam set to get started.
                    </p>
                    <button type="button" onclick="openExamSetCreateModal()"
                        class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                        <i class="bi bi-plus-lg"></i>
                        Create Exam Set
                    </button>
                </div>
            @endif
        </div>
    </div>
    {{-- =============================================================
         CREATE EXAM SET MODAL
    ============================================================== --}}
    <div id="examSetCreateModal" data-validation-error="{{ $errors->any() && old('_token') ? 'true' : 'false' }}"
        class="exam-set-modal-backdrop fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 px-4 py-6 opacity-0 transition-opacity duration-200">
        <div class="max-h-[90vh] w-full max-w-3xl overflow-hidden rounded-xl bg-white shadow-xl">
            {{-- Modal Header --}}
            <div class="flex shrink-0 items-center justify-between border-b border-slate-100 bg-white px-5 py-4 sm:px-6">
                <div>
                    <h2 class="text-base font-semibold text-slate-800">
                        Create Exam Set
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-400">
                        Add a new set to this exam.
                    </p>
                </div>
                <button type="button" onclick="closeExamSetCreateModal()"
                    class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            {{-- Scrollable Content --}}
            <div class="max-h-[calc(90vh-130px)] overflow-y-auto">
                <form action="{{ route('exams.exam-sets.store', $exam) }}" method="POST">
                    @csrf
                    @include('exams.exam-sets._form')
                    {{-- Modal Footer --}}
                    <div
                        class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-white px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                        <button type="button" onclick="closeExamSetCreateModal()"
                            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                            <i class="bi bi-check-lg"></i>
                            Create Exam Set
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- =============================================================
         EDIT EXAM SET MODALS
    ============================================================== --}}
    @foreach ($exam->examSets as $examSet)
        <div id="examSetEditModal{{ $examSet->id }}"
            class="exam-set-modal-backdrop fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 px-4 py-6 opacity-0 transition-opacity duration-200">
            <div class="max-h-[90vh] w-full max-w-3xl overflow-hidden rounded-xl bg-white shadow-xl">
                {{-- Header --}}
                <div
                    class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Edit Exam Set
                        </h2>
                        <p class="mt-0.5 text-xs text-slate-400">
                            Update {{ $examSet->name }}.
                        </p>
                    </div>
                    <button type="button" onclick="closeExamSetEditModal({{ $examSet->id }})"
                        class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                {{-- Scrollable Content --}}
                <div class="max-h-[calc(90vh-130px)] overflow-y-auto">
                    <form action="{{ route('exams.exam-sets.update', [$exam, $examSet]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @include('exams.exam-sets._form')
                        {{-- Footer --}}
                        <div
                            class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-white px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                            <button type="button" onclick="closeExamSetEditModal({{ $examSet->id }})"
                                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                                <i class="bi bi-check-lg"></i>
                                Update Exam Set
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- View Exam Set Modal --}}

        <div id="examSetViewModal{{ $examSet->id }}"
            class="exam-set-modal-backdrop fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 px-4 py-6 opacity-0 transition-opacity duration-200">

            <div class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">

                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Exam Set Details</h3>
                        <p class="mt-0.5 text-xs text-slate-400">Overview of this exam set</p>
                    </div>

                    <button type="button" onclick="closeExamSetViewModal({{ $examSet->id }})"
                        class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>
                </div>

                <div class="p-5">

                    <div class="mb-4 rounded-xl bg-slate-50 px-4 py-3">
                        <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                            Exam Set
                        </p>
                        <p class="mt-1 text-sm font-bold text-slate-800">
                            {{ $examSet->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Set Number</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $examSet->set_number ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Type</p>
                            <p class="mt-1 text-sm font-semibold capitalize text-slate-700">
                                {{ str_replace('_', ' ', $examSet->type ?? 'N/A') }}
                            </p>
                        </div>

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Question Type</p>
                            <p class="mt-1 text-sm font-semibold uppercase text-slate-700">
                                {{ $examSet->question_type ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Mode</p>
                            <p class="mt-1 text-sm font-semibold capitalize text-slate-700">
                                {{ $examSet->mode ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Duration</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $examSet->duration_minutes ?? 0 }} Minutes
                            </p>
                        </div>

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Total Marks</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $examSet->total_marks ?? 0 }}
                            </p>
                        </div>

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Pass Marks</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $examSet->pass_marks ?? 0 }}
                            </p>
                        </div>

                        <div class="rounded-lg border border-slate-100 bg-white px-3 py-2.5">
                            <p class="text-[11px] text-slate-400">Status</p>
                            <p class="mt-1 text-sm font-semibold capitalize text-slate-700">
                                {{ $examSet->status ?? 'N/A' }}
                            </p>
                        </div>

                    </div>
                </div>


                <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-5 py-3">
                    <button type="button"
                        onclick="closeExamSetViewModal({{ $examSet->id }}); openExamSetEditModal({{ $examSet->id }})"
                        class="cursor-pointer rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary/90">
                        <i class="bi bi-pencil-square mr-1"></i>
                        Edit
                    </button>

                    <button type="button" onclick="closeExamSetViewModal({{ $examSet->id }})"
                        class="cursor-pointer rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Close
                    </button>
                </div>



            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    {{-- Delete Alert --}}
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
    {{-- Exam Set Modal --}}
    <script src="{{ asset('/assets/js/examSetModal.js') }}"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: @json(session('success')),
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
@endpush
