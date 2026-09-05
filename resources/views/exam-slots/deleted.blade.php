@extends('layouts.backend.app')

@section('content')

<div class="min-h-screen bg-[#f7f8fc]">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                Deleted Exam Slots
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage your deleted exam slots and restore or permanently remove them.
            </p>

        </div>

        {{-- Back Button --}}
        <a href="{{ route('exam-slots.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">

            <i class="bi bi-arrow-left text-sm"></i>

            Back to Exam Slots

        </a>

    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        {{-- Card Header --}}
        <x-backend.card-header
            title="Deleted Items"
            :count="$examSlots->total()"
            singular="deleted exam slot"
            plural="deleted exam slots"
            action="{{ route('exam-slots.deleted') }}"
            placeholder="Search deleted exam slots..." />

        {{-- Alerts --}}
        <x-_alerts class="m-3" />

        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="w-full min-w-[1200px] text-left">

                {{-- Table Header --}}
                <thead class="border-b border-slate-100 bg-slate-50/60">

                    <tr>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Slot
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Batch
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Exam
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Exam Set
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Start At
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            End At
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Deleted At
                        </th>

                        <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Status
                        </th>

                        <th class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                            Actions
                        </th>

                    </tr>

                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse ($examSlots as $examSlot)

                        <tr class="transition hover:bg-red-50/30">

                            {{-- Slot --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-sm font-bold text-red-500">

                                        <i class="bi bi-calendar-event"></i>

                                    </div>

                                    <span class="text-sm font-semibold text-slate-700">
                                        #{{ $examSlot->id }}
                                    </span>

                                </div>

                            </td>

                            {{-- Batch --}}
                            <td class="px-5 py-4">

                                @if ($examSlot->batch)

                                    <p class="text-sm font-medium text-slate-600">
                                        {{ $examSlot->batch->name }}
                                    </p>

                                @else

                                    <p class="text-sm italic text-slate-400">
                                        No Batch
                                    </p>

                                @endif

                            </td>

                            {{-- Exam --}}
                            <td class="max-w-md px-5 py-4">

                                @if ($examSlot->examSet?->exam)

                                    <p class="truncate text-sm font-medium text-slate-600">
                                        {{ $examSlot->examSet->exam->title }}
                                    </p>

                                @else

                                    <p class="text-sm italic text-slate-400">
                                        No Exam
                                    </p>

                                @endif

                            </td>

                            {{-- Exam Set --}}
                            <td class="px-5 py-4">

                                @if ($examSlot->examSet)

                                    <div>

                                        <p class="text-sm font-medium text-slate-600">
                                            {{ $examSlot->examSet->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Set #{{ $examSlot->examSet->id }}
                                        </p>

                                    </div>

                                @else

                                    <p class="text-sm italic text-slate-400">
                                        No Exam Set
                                    </p>

                                @endif

                            </td>

                            {{-- Start At --}}
                            <td class="px-5 py-4">

                                @if ($examSlot->start_at)

                                    <p class="text-sm font-medium text-slate-600">
                                        {{ $examSlot->start_at->format('d M, Y') }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $examSlot->start_at->format('h:i A') }}
                                    </p>

                                @else

                                    <span class="text-sm text-slate-400">
                                        N/A
                                    </span>

                                @endif

                            </td>

                            {{-- End At --}}
                            <td class="px-5 py-4">

                                @if ($examSlot->end_at)

                                    <p class="text-sm font-medium text-slate-600">
                                        {{ $examSlot->end_at->format('d M, Y') }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $examSlot->end_at->format('h:i A') }}
                                    </p>

                                @else

                                    <span class="text-sm text-slate-400">
                                        N/A
                                    </span>

                                @endif

                            </td>

                            {{-- Deleted At --}}
                            <td class="px-5 py-4">

                                @if ($examSlot->deleted_at)

                                    <p class="text-sm text-slate-500">
                                        {{ $examSlot->deleted_at->format('d M, Y') }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $examSlot->deleted_at->format('h:i A') }}
                                    </p>

                                @else

                                    <span class="text-sm text-slate-400">
                                        N/A
                                    </span>

                                @endif

                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">

                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                    Deleted

                                </span>

                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Restore --}}
                                    <form action="{{ route('exam-slots.restore', $examSlot->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('POST')

                                        <button type="submit"
                                            title="Restore Exam Slot"
                                            class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-500 transition hover:bg-emerald-100 hover:text-emerald-600">

                                            <i class="bi bi-arrow-counterclockwise text-sm"></i>

                                        </button>

                                    </form>

                                    {{-- Permanent Delete --}}
                                    <form method="POST"
                                        action="{{ route('exam-slots.force-delete', $examSlot->id) }}"
                                        data-item="exam slot permanently"
                                        class="delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            title="Delete Permanently"
                                            class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 transition hover:bg-red-100 hover:text-red-600">

                                            <i class="bi bi-trash3 text-sm"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="px-5 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                        <i class="bi bi-trash3 text-xl text-slate-400"></i>

                                    </div>

                                    <p class="text-sm font-medium text-slate-600">
                                        No deleted exam slots found
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Deleted exam slots will appear here.
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

            @forelse ($examSlots as $examSlot)

                <div class="p-4">

                    {{-- Top --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="flex min-w-0 items-center gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-sm font-bold text-red-500">

                                <i class="bi bi-calendar-event"></i>

                            </div>

                            <div class="min-w-0">

                                <h3 class="truncate text-sm font-semibold text-slate-700">
                                    Exam Slot #{{ $examSlot->id }}
                                </h3>

                                @if ($examSlot->batch)

                                    <p class="mt-1 truncate text-xs text-slate-400">
                                        {{ $examSlot->batch->name }}
                                    </p>

                                @else

                                    <p class="mt-1 text-xs italic text-slate-400">
                                        No Batch
                                    </p>

                                @endif

                            </div>

                        </div>

                        {{-- Status --}}
                        <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">

                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                            Deleted

                        </span>

                    </div>

                    {{-- Exam --}}
                    <div class="mt-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Exam
                        </p>

                        @if ($examSlot->examSet?->exam)

                            <p class="mt-1 text-sm font-medium text-slate-600">
                                {{ $examSlot->examSet->exam->title }}
                            </p>

                        @else

                            <p class="mt-1 text-sm italic text-slate-400">
                                No Exam
                            </p>

                        @endif

                    </div>

                    {{-- Exam Set --}}
                    <div class="mt-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Exam Set
                        </p>

                        @if ($examSlot->examSet)

                            <div class="mt-1 flex flex-wrap items-center gap-2">

                                <p class="text-sm font-medium text-slate-600">
                                    {{ $examSlot->examSet->name }}
                                </p>

                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-500">
                                    Set #{{ $examSlot->examSet->id }}
                                </span>

                            </div>

                        @else

                            <p class="mt-1 text-sm italic text-slate-400">
                                No Exam Set
                            </p>

                        @endif

                    </div>

                    {{-- Schedule --}}
                    <div class="mt-4 grid grid-cols-2 gap-3">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Start At
                            </p>

                            @if ($examSlot->start_at)

                                <p class="mt-1 text-sm font-medium text-slate-600">
                                    {{ $examSlot->start_at->format('d M, Y') }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $examSlot->start_at->format('h:i A') }}
                                </p>

                            @else

                                <p class="mt-1 text-sm text-slate-400">
                                    N/A
                                </p>

                            @endif

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                End At
                            </p>

                            @if ($examSlot->end_at)

                                <p class="mt-1 text-sm font-medium text-slate-600">
                                    {{ $examSlot->end_at->format('d M, Y') }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $examSlot->end_at->format('h:i A') }}
                                </p>

                            @else

                                <p class="mt-1 text-sm text-slate-400">
                                    N/A
                                </p>

                            @endif

                        </div>

                    </div>

                    {{-- Deleted At --}}
                    <p class="mt-4 text-xs text-slate-400">

                        Deleted

                        {{ $examSlot->deleted_at?->format('d M, Y h:i A') }}

                    </p>

                    {{-- Mobile Actions --}}
                    <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                        {{-- Restore --}}
                        <form action="{{ route('exam-slots.restore', $examSlot->id) }}"
                            method="POST"
                            class="flex-1">

                            @csrf
                            @method('POST')

                            <button type="submit"
                                class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-600 transition hover:bg-emerald-100 hover:text-emerald-700">

                                <i class="bi bi-arrow-counterclockwise"></i>

                                Restore

                            </button>

                        </form>

                        {{-- Permanent Delete --}}
                        <form action="{{ route('exam-slots.force-delete', $examSlot->id) }}"
                            method="POST"
                            data-item="exam slot permanently"
                            class="delete-form flex-1">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-100 hover:text-red-600">

                                <i class="bi bi-trash3"></i>

                                Delete Permanently

                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="px-4 py-12 text-center">

                    <div class="mb-3 flex justify-center">

                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                            <i class="bi bi-trash3 text-xl text-slate-400"></i>

                        </div>

                    </div>

                    <p class="text-sm font-medium text-slate-600">
                        No deleted exam slots found
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Deleted exam slots will appear here.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($examSlots->hasPages())

            <div class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                {{-- Result Information --}}
                <p class="text-xs text-slate-500">

                    Showing

                    <span class="font-semibold text-slate-700">
                        {{ $examSlots->firstItem() }}
                    </span>

                    <span class="px-0.5 text-slate-400">–</span>

                    <span class="font-semibold text-slate-700">
                        {{ $examSlots->lastItem() }}
                    </span>

                    of

                    <span class="font-semibold text-slate-700">
                        {{ $examSlots->total() }}
                    </span>

                    deleted exam slots

                </p>

                {{-- Pagination --}}
                <div class="overflow-x-auto">

                    {{ $examSlots->onEachSide(1)->links() }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')

<script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>

@endpush