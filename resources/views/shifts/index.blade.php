@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Shift Information
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage shifts and their scheduled working times.
                </p>
            </div>

            {{-- Add Shift Button --}}
            <a href="{{ route('shifts.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2">

                <i class="bi bi-plus-lg text-sm"></i>
                Add Shift

            </a>

        </div>

        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- header  --}}
            <x-backend.card-header title="Shifts" :count="$shifts->total()" singular="shift" plural="shifts"
                action="{{ route('shifts.index') }}" placeholder="Search shifts..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[900px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Shift
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Code
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Start Time
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                End Time
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

                        @forelse ($shifts as $shift)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- Shift --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                            <i class="bi bi-clock-history"></i>

                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ $shift->name }}
                                        </span>

                                    </div>

                                </td>

                                {{-- Code --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex items-center rounded bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">
                                        {{ $shift->code ?? 'No Code' }}
                                    </span>

                                </td>

                                {{-- Start Time --}}
                                <td class="px-5 py-4">

                                    @if ($shift->start_time)
                                        <p class="text-sm text-slate-600">
                                            {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}
                                        </p>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No start time
                                        </span>
                                    @endif

                                </td>

                                {{-- End Time --}}
                                <td class="px-5 py-4">

                                    @if ($shift->end_time)
                                        <p class="text-sm text-slate-600">
                                            {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                                        </p>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No end time
                                        </span>
                                    @endif

                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($shift->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Active

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">

                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                            Inactive

                                        </span>
                                    @endif

                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('shifts.show', $shift) }}" title="View Shift"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                            <i class="bi bi-eye text-sm"></i>

                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('shifts.edit', $shift) }}" title="Edit Shift"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                            <i class="bi bi-pencil-square text-sm"></i>

                                        </a>

                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('shifts.destroy', $shift) }}"
                                            data-item="shift" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Shift"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 transition hover:bg-red-100 hover:text-red-600 cursor-pointer">

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
                                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                            <i class="bi bi-clock-history text-xl text-slate-400"></i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No shifts found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Create your first shift to get started.
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

                @forelse ($shifts as $shift)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                    <i class="bi bi-clock-history"></i>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-semibold text-slate-700">
                                        {{ $shift->name }}
                                    </h3>

                                    @if ($shift->code)
                                        <p class="mt-1 truncate text-xs text-slate-400">
                                            Code: {{ $shift->code }}
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs italic text-slate-400">
                                            No code
                                        </p>
                                    @endif

                                </div>

                            </div>

                            {{-- Status --}}
                            @if ($shift->is_active)
                                <span
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">

                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                    Active

                                </span>
                            @else
                                <span
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">

                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                    Inactive

                                </span>
                            @endif

                        </div>

                        {{-- Schedule --}}
                        <div class="mt-4 rounded-lg bg-slate-50 px-3 py-2.5">

                            <div class="flex items-center gap-2">

                                <i class="bi bi-clock text-sm text-slate-400"></i>

                                @if ($shift->start_time && $shift->end_time)
                                    <p class="text-sm font-medium text-slate-600">

                                        {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}

                                        <span class="mx-1 text-slate-300">–</span>

                                        {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}

                                    </p>
                                @else
                                    <p class="text-sm italic text-slate-400">
                                        No schedule set
                                    </p>
                                @endif

                            </div>

                        </div>

                        {{-- Mobile Actions --}}
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('shifts.show', $shift) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                <i class="bi bi-eye"></i>
                                View

                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('shifts.edit', $shift) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                <i class="bi bi-pencil-square"></i>
                                Edit

                            </a>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('shifts.destroy', $shift) }}" data-item="shift"
                                class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-100 hover:text-red-600 cursor-pointer">

                                    <i class="bi bi-trash3"></i>
                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="px-4 py-12 text-center">

                        <div class="mb-3 flex justify-center">

                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                <i class="bi bi-clock-history text-xl text-slate-400"></i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No shifts found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Create your first shift to get started.
                        </p>

                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($shifts->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $shifts->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">–</span>

                        <span class="font-semibold text-slate-700">
                            {{ $shifts->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $shifts->total() }}
                        </span>

                        results

                    </p>

                    {{-- Pagination --}}
                    <div class="overflow-x-auto">

                        {{ $shifts->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
