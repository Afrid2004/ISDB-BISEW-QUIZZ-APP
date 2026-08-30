@extends('layouts.backend.app')

@section('title', 'Batches')

@section('page-title', 'Batches')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Batch Information
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage assessment batches, class capacity, and schedules.
                </p>
            </div>

            {{-- Add Batch Button --}}
            <a href="{{ route('batches.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2">
                <i class="bi bi-plus-lg text-sm"></i>
                Add Batch
            </a>

        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- card header --}}
            <x-backend.card-header title="Batches" :count="$batches->total()" singular="batch" plural="batches"
                action="{{ route('batches.index') }}" placeholder="Search batches..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1000px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Batch
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Round
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Center
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Shift
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Capacity
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

                        @forelse ($batches as $batch)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- Batch --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                            <i class="bi bi-people-fill"></i>
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $batch->name }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                {{ $batch->batch_number }}
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                {{-- Round --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">
                                        Round {{ $batch->round->round_number ?? 'N/A' }}
                                    </p>

                                </td>

                                {{-- Center --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">
                                        {{ $batch->trainingCenter->name ?? 'N/A' }}
                                    </p>

                                </td>

                                {{-- Shift --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">
                                        {{ $batch->shift->name ?? 'N/A' }}
                                    </p>

                                </td>

                                {{-- Capacity --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">
                                        <i class="bi bi-people text-[11px]"></i>
                                        {{ $batch->max_students }} Students
                                    </span>

                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($batch->is_active)
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
                                        <a href="{{ route('batches.show', $batch) }}" title="View Batch"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">
                                            <i class="bi bi-eye text-sm"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('batches.edit', $batch) }}" title="Edit Batch"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">
                                            <i class="bi bi-pencil-square text-sm"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('batches.destroy', $batch) }}"
                                            data-item="batch" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Batch"
                                                class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 transition hover:bg-red-100 hover:text-red-600">
                                                <i class="bi bi-trash3 text-sm"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                            <i class="bi bi-people text-xl text-slate-400"></i>
                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No batches found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Create your first batch to get started.
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

                @forelse ($batches as $batch)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                    <i class="bi bi-people-fill"></i>
                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-semibold text-slate-700">
                                        {{ $batch->name }}
                                    </h3>

                                    <p class="mt-1 truncate text-xs text-slate-400">
                                        {{ $batch->batch_number }}
                                    </p>

                                </div>

                            </div>

                            {{-- Status --}}
                            @if ($batch->is_active)
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

                        {{-- Batch Information --}}
                        <div class="mt-4 grid grid-cols-2 gap-3">

                            {{-- Round --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Round
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-600">
                                    {{ $batch->round->round_number ?? 'N/A' }}
                                </p>

                            </div>

                            {{-- Capacity --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Capacity
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-600">
                                    {{ $batch->max_students }} Students
                                </p>

                            </div>

                            {{-- Center --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Center
                                </p>

                                <p class="mt-1 truncate text-sm font-medium text-slate-600">
                                    {{ $batch->trainingCenter->name ?? 'N/A' }}
                                </p>

                            </div>

                            {{-- Shift --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Shift
                                </p>

                                <p class="mt-1 truncate text-sm font-medium text-slate-600">
                                    {{ $batch->shift->name ?? 'N/A' }}
                                </p>

                            </div>

                        </div>

                        {{-- Mobile Actions --}}
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('batches.show', $batch) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">
                                <i class="bi bi-eye"></i>
                                View
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('batches.edit', $batch) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('batches.destroy', $batch) }}" data-item="batch"
                                class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-100 hover:text-red-600">
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
                                <i class="bi bi-people text-xl text-slate-400"></i>
                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No batches found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Create your first batch to get started.
                        </p>

                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($batches->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $batches->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $batches->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $batches->total() }}
                        </span>

                        results

                    </p>

                    {{-- Pagination --}}
                    <div class="overflow-x-auto">
                        {{ $batches->onEachSide(1)->links() }}
                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
