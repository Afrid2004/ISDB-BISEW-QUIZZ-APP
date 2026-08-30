@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Training Centers
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Manage your training centers.
                </p>
            </div>

            {{-- Header Actions --}}
            <div class="flex flex-col gap-2 sm:flex-row">

                {{-- Add Training Center --}}
                <a href="{{ route('training-centers.create') }}"
                    class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2">
                    <i class="bi bi-plus-lg text-base"></i>
                    Add Training Center
                </a>

            </div>
        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- card header --}}
            <x-backend.card-header title="Training Centers" :count="$trainingCenters->total()" singular="training center"
                plural="training centers" action="{{ route('training-centers.index') }}"
                placeholder="Search training centers..." />

            {{-- Universal Alerts --}}
            <x-_alerts class="m-3" />

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[750px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">
                        <tr>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Training Center
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Code
                            </th>

                            <th class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Status
                            </th>

                            <th class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Actions
                            </th>

                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($trainingCenters as $trainingCenter)
                            <tr class="transition hover:bg-slate-50/60">

                                {{-- Training Center --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-sm font-bold text-primary">
                                            <i class="bi bi-building"></i>
                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ $trainingCenter->name }}
                                        </span>

                                    </div>
                                </td>

                                {{-- Code --}}
                                <td class="px-5 py-4">
                                    @if ($trainingCenter->code)
                                        <span
                                            class="inline-flex rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                            {{ $trainingCenter->code }}
                                        </span>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No Code
                                        </span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4 text-center">

                                    @if ($trainingCenter->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Show --}}
                                        <a href="{{ route('training-centers.show', $trainingCenter) }}"
                                            title="View Training Center"
                                            class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/20 hover:bg-primary/5 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                                            <i class="bi bi-eye text-sm"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('training-centers.edit', $trainingCenter) }}"
                                            title="Edit Training Center"
                                            class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/20 hover:bg-primary/5 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                                            <i class="bi bi-pencil-square text-sm"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('training-centers.destroy', $trainingCenter) }}"
                                            method="POST" data-item="training center" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Training Center"
                                                class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 transition hover:bg-red-100 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                                                <i class="bi bi-trash3 text-sm"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                            <i class="bi bi-building text-xl text-slate-400"></i>
                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No training centers found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Training centers will appear here.
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

                @forelse ($trainingCenters as $trainingCenter)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-sm font-bold text-primary">
                                    <i class="bi bi-building"></i>
                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-semibold text-slate-700">
                                        {{ $trainingCenter->name }}
                                    </h3>

                                    @if ($trainingCenter->code)
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $trainingCenter->code }}
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs italic text-slate-400">
                                            No training center code
                                        </p>
                                    @endif

                                </div>

                            </div>

                            {{-- Status --}}
                            @if ($trainingCenter->is_active)
                                <span
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Inactive
                                </span>
                            @endif

                        </div>

                        {{-- Mobile Actions --}}
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                            {{-- Show --}}
                            <a href="{{ route('training-centers.show', $trainingCenter) }}"
                                class="inline-flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/20 hover:bg-primary/5 hover:text-primary">
                                <i class="bi bi-eye"></i>
                                View
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('training-centers.edit', $trainingCenter) }}"
                                class="inline-flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/20 hover:bg-primary/5 hover:text-primary">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('training-centers.destroy', $trainingCenter) }}" method="POST"
                                data-item="training center" class="delete-form flex-1">

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
                                <i class="bi bi-building text-xl text-slate-400"></i>
                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No training centers found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Training centers will appear here.
                        </p>

                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($trainingCenters->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $trainingCenters->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">–</span>

                        <span class="font-semibold text-slate-700">
                            {{ $trainingCenters->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $trainingCenters->total() }}
                        </span>

                        training centers

                    </p>

                    {{-- Pagination --}}
                    <div class="overflow-x-auto">
                        {{ $trainingCenters->onEachSide(1)->withQueryString()->links() }}
                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
