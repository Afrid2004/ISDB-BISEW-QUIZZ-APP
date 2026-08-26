@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                    <a href="{{ route('rounds.index') }}" class="transition hover:text-primary">
                        Rounds
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span class="text-slate-500">
                        Details
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                            Round {{ sprintf('%02d', $round->round_number) }}
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            View round configuration and system information.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('rounds.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-primary/30 hover:bg-primary/5 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20">

                <i class="bi bi-arrow-left text-sm"></i>

                <span class="hidden sm:inline">
                    Back to Rounds
                </span>

                <span class="sm:hidden">
                    Back
                </span>

            </a>

        </div>

        {{-- Main Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div
                class="flex flex-col gap-3 border-b border-slate-100 bg-slate-50/40 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                <div>
                    <h2 class="text-sm font-bold uppercase tracking-widest text-slate-800">
                        Round Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Complete information about this assessment round.
                    </p>
                </div>

                {{-- Status --}}
                @if ($round->is_active)
                    <span
                        class="inline-flex w-fit items-center gap-1.5 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-600">

                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span>

                        ACTIVE

                    </span>
                @else
                    <span
                        class="inline-flex w-fit items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-3 py-1 text-[10px] font-bold text-slate-500">

                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                        INACTIVE

                    </span>
                @endif

            </div>

            {{-- Information --}}
            <div class="px-5 py-6 sm:px-6">

                {{-- Top Information Row --}}
                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                    {{-- Round Number --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">

                        <div class="flex items-center gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <i class="bi bi-hash text-xl"></i>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    Round Number
                                </p>

                                <p class="mt-1 text-lg font-bold text-slate-700">
                                    Round {{ $round->round_number }}
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- Created At --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">

                        <div class="flex items-center gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-400">
                                <i class="bi bi-calendar-plus text-lg"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    Created At
                                </p>

                                @if ($round->created_at)
                                    <p class="mt-1 text-sm font-bold text-slate-700">
                                        {{ $round->created_at->format('d M, Y') }}
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        {{ $round->created_at->format('h:i A') }}
                                    </p>
                                @else
                                    <p class="mt-1 text-sm italic text-slate-400">
                                        Not available
                                    </p>
                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- Last Updated --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">

                        <div class="flex items-center gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-400">
                                <i class="bi bi-clock-history text-lg"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    Last Updated
                                </p>

                                @if ($round->updated_at)
                                    <p class="mt-1 text-sm font-bold text-slate-700">
                                        {{ $round->updated_at->format('d M, Y') }}
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        {{ $round->updated_at->format('h:i A') }}
                                    </p>
                                @else
                                    <p class="mt-1 text-sm italic text-slate-400">
                                        Not available
                                    </p>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Description --}}
                <div class="mt-6">

                    <div class="mb-2 flex items-center gap-2">

                        <i class="bi bi-card-text text-sm text-primary"></i>

                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            Description
                        </label>

                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">

                        @if ($round->description)
                            <p class="text-sm leading-7 text-slate-600">
                                {{ $round->description }}
                            </p>
                        @else
                            <p class="text-sm italic text-slate-400">
                                No description provided for this round.
                            </p>
                        @endif

                    </div>

                </div>

                {{-- Bottom Information Row --}}
                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Current Status --}}
                    <div
                        class="flex items-center justify-between rounded-lg border border-slate-100 bg-slate-50/50 px-4 py-3">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    Current Status
                                </p>

                                @if ($round->is_active)
                                    <p class="mt-0.5 text-sm font-bold text-emerald-600">
                                        Active Round
                                    </p>
                                @else
                                    <p class="mt-0.5 text-sm font-bold text-slate-500">
                                        Inactive Round
                                    </p>
                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- Database ID --}}
                    <div
                        class="flex items-center justify-between rounded-lg border border-slate-100 bg-slate-50/50 px-4 py-3">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-50 text-slate-400">
                                <i class="bi bi-database"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    Database ID
                                </p>

                                <p class="mt-0.5 text-sm font-bold text-slate-700">
                                    #{{ $round->id }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Footer Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/20 px-5 py-4 sm:flex-row sm:items-center sm:justify-end sm:px-6">

                {{-- Delete --}}
                <form action="{{ route('rounds.destroy', $round->id) }}" method="POST"
                    class="delete-form w-full sm:w-auto">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-100 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-500 transition hover:bg-red-100 hover:text-red-600 cursor-pointer sm:w-auto">

                        <i class="bi bi-trash3"></i>

                        Delete Round

                    </button>

                </form>

                {{-- Edit --}}
                <a href="{{ route('rounds.edit', $round->id) }}"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/30 sm:w-auto">

                    <i class="bi bi-pencil-square"></i>

                    Edit Round

                </a>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
