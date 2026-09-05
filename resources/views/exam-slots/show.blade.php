@extends('layouts.backend.app')

@section('content')

<div class="min-h-screen bg-[#f7f8fc]">


{{-- Page Header --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        {{-- Breadcrumb --}}
        <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

            <a href="{{ route('exam-slots.index') }}"
                class="transition hover:text-primary">
                Exam Slots
            </a>

            <i class="bi bi-chevron-right text-[9px]"></i>

            <span>View</span>

        </div>

        <h1 class="text-2xl font-bold text-slate-800">
            Exam Slot #{{ $examSlot->id }}
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            View exam slot information and schedule details.
        </p>

    </div>

    {{-- Back --}}
    <div>

        <a href="{{ route('exam-slots.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">

            <i class="bi bi-arrow-left"></i>
            Back

        </a>

    </div>

</div>

{{-- Main Card --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

    {{-- Card Header --}}
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">

        <div class="flex items-center gap-3">

            {{-- Icon --}}
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">

                <i class="bi bi-calendar-event text-lg"></i>

            </div>

            <div>

                <h2 class="text-base font-semibold text-slate-800">
                    Exam Slot Information
                </h2>

                <p class="mt-0.5 text-xs text-slate-400">
                    Details of this exam slot.
                </p>

            </div>

        </div>

        {{-- Status --}}
        @if ($examSlot->is_active)

            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">

                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                Active

            </span>

        @else

            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-600">

                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                Inactive

            </span>

        @endif

    </div>

    {{-- Information --}}
    <div class="divide-y divide-slate-100">

        {{-- Slot ID --}}
        <div class="px-5 py-5 sm:px-6">

            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Slot ID
            </p>

            <p class="text-sm font-semibold text-slate-700">
                #{{ $examSlot->id }}
            </p>

        </div>

        {{-- Batch --}}
        <div class="px-5 py-5 sm:px-6">

            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Batch
            </p>

            @if ($examSlot->batch)

                <p class="text-sm font-semibold text-slate-700">
                    {{ $examSlot->batch->name }}
                </p>

            @else

                <p class="text-sm italic text-slate-400">
                    No batch available.
                </p>

            @endif

        </div>

        {{-- Exam --}}
        <div class="px-5 py-5 sm:px-6">

            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Exam
            </p>

            @if ($examSlot->examSet?->exam)

                <p class="text-sm font-semibold text-slate-700">
                    {{ $examSlot->examSet->exam->title }}
                </p>

            @else

                <p class="text-sm italic text-slate-400">
                    No exam available.
                </p>

            @endif

        </div>

        {{-- Exam Set --}}
        <div class="px-5 py-5 sm:px-6">

            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Exam Set
            </p>

            @if ($examSlot->examSet)

                <div class="flex flex-wrap items-center gap-2">

                    <span class="text-sm font-semibold text-slate-700">
                        {{ $examSlot->examSet->name }}
                    </span>

                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                        Set #{{ $examSlot->examSet->id }}
                    </span>

                </div>

            @else

                <p class="text-sm italic text-slate-400">
                    No exam set available.
                </p>

            @endif

        </div>

        {{-- Start Date & Time --}}
        <div class="px-5 py-5 sm:px-6">

            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Start Date & Time
            </p>

            @if ($examSlot->start_at)

                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">

                    <i class="bi bi-play-circle text-emerald-500"></i>

                    {{ $examSlot->start_at->format('d M, Y') }}

                    <span class="text-slate-300">•</span>

                    {{ $examSlot->start_at->format('h:i A') }}

                </div>

            @else

                <p class="text-sm italic text-slate-400">
                    No start time available.
                </p>

            @endif

        </div>

        {{-- End Date & Time --}}
        <div class="px-5 py-5 sm:px-6">

            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                End Date & Time
            </p>

            @if ($examSlot->end_at)

                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">

                    <i class="bi bi-stop-circle text-red-500"></i>

                    {{ $examSlot->end_at->format('d M, Y') }}

                    <span class="text-slate-300">•</span>

                    {{ $examSlot->end_at->format('h:i A') }}

                </div>

            @else

                <p class="text-sm italic text-slate-400">
                    No end time available.
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

                @if ($examSlot->created_at)

                    {{ $examSlot->created_at->format('d M, Y') }}

                    <span class="text-slate-300">•</span>

                    {{ $examSlot->created_at->format('h:i A') }}

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

                @if ($examSlot->updated_at)

                    {{ $examSlot->updated_at->format('d M, Y') }}

                    <span class="text-slate-300">•</span>

                    {{ $examSlot->updated_at->format('h:i A') }}

                @else

                    N/A

                @endif

            </div>

        </div>

    </div>

    {{-- Footer Actions --}}
    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">

        {{-- Delete --}}
        <form
            data-item="exam slot"
            action="{{ route('exam-slots.destroy', $examSlot) }}"
            method="POST"
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
        <a href="{{ route('exam-slots.edit', $examSlot) }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">

            <i class="bi bi-pencil-square"></i>

            Edit Exam Slot

        </a>

    </div>

</div>


</div>

@endsection

@push('scripts')


<script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>


@endpush
