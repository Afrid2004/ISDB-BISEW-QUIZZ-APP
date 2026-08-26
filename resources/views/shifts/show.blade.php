@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                    <a href="{{ route('shifts.index') }}" class="transition hover:text-primary">
                        Shifts
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span class="text-slate-500">Details</span>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                    {{ $shift->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View shift details and schedule information.
                </p>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('shifts.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20">

                <i class="bi bi-arrow-left text-sm"></i>

                Back to Shifts
            </a>

        </div>


        {{-- Universal Alerts --}}
        <x-_alerts />


        {{-- Main Content --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Shift Information --}}
            <div class="lg:col-span-2">

                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                    {{-- Card Header --}}
                    <div
                        class="flex items-center justify-between border-b border-slate-100 bg-slate-50/60 px-5 py-4 sm:px-6">

                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-wide text-slate-800">
                                Shift Information
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Basic information about this shift.
                            </p>
                        </div>

                        {{-- Status --}}
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

                    </div>


                    {{-- Information --}}
                    <div class="divide-y divide-slate-100">

                        {{-- Shift Name --}}
                        <div class="flex items-center gap-4 px-5 py-5 sm:px-6">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                <i class="bi bi-clock-history text-lg"></i>

                            </div>

                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                    Shift Name
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">
                                    {{ $shift->name }}
                                </p>
                            </div>

                        </div>


                        {{-- Shift Code --}}
                        <div class="flex items-center gap-4 px-5 py-5 sm:px-6">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                <i class="bi bi-upc-scan text-lg"></i>

                            </div>

                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                    Shift Code
                                </p>

                                <span
                                    class="mt-1 inline-flex items-center rounded bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600">

                                    {{ $shift->code }}

                                </span>
                            </div>

                        </div>


                        {{-- Schedule --}}
                        <div class="px-5 py-5 sm:px-6">

                            <p class="mb-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Schedule
                            </p>

                            @if ($shift->start_time && $shift->end_time)
                                <div
                                    class="flex flex-col gap-4 rounded-lg border border-slate-100 bg-slate-50/60 p-4 sm:flex-row sm:items-center">

                                    {{-- Start Time --}}
                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                            <i class="bi bi-box-arrow-in-right"></i>

                                        </div>

                                        <div>

                                            <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                Start Time
                                            </p>

                                            <p class="mt-0.5 text-sm font-bold text-slate-700">
                                                {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Arrow --}}
                                    <div class="hidden text-slate-300 sm:block">
                                        <i class="bi bi-arrow-right"></i>
                                    </div>


                                    {{-- End Time --}}
                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                            <i class="bi bi-box-arrow-right"></i>

                                        </div>

                                        <div>

                                            <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                End Time
                                            </p>

                                            <p class="mt-0.5 text-sm font-bold text-slate-700">
                                                {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                                            </p>

                                        </div>

                                    </div>

                                </div>
                            @else
                                <div class="rounded-lg border border-dashed border-slate-200 bg-slate-50/50 px-4 py-5">

                                    <div class="flex items-center gap-3">

                                        <i class="bi bi-clock text-slate-400"></i>

                                        <p class="text-sm italic text-slate-400">
                                            No schedule time specified for this shift.
                                        </p>

                                    </div>

                                </div>
                            @endif

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div
                        class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/30 px-5 py-4 sm:flex-row sm:items-center sm:justify-end sm:px-6">

                        {{-- Delete --}}
                        <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST"
                            class="delete-form w-full sm:w-auto">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-100 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-500 transition hover:bg-red-100 hover:text-red-600 sm:w-auto">

                                <i class="bi bi-trash3 text-sm"></i>

                                Delete

                            </button>

                        </form>


                        {{-- Edit --}}
                        <a href="{{ route('shifts.edit', $shift->id) }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2 sm:w-auto">

                            <i class="bi bi-pencil-square text-sm"></i>

                            Edit Shift

                        </a>

                    </div>

                </div>

            </div>


            {{-- System Information --}}
            <div>

                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                    {{-- Header --}}
                    <div class="border-b border-slate-100 bg-slate-50/60 px-5 py-4 sm:px-6">

                        <h2 class="text-sm font-bold uppercase tracking-wide text-slate-800">
                            System Information
                        </h2>

                        <p class="mt-1 text-xs text-slate-400">
                            Record and update information.
                        </p>

                    </div>


                    {{-- Metadata --}}
                    <div class="divide-y divide-slate-100">

                        {{-- Created --}}
                        <div class="flex items-center gap-4 px-5 py-5">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-400">

                                <i class="bi bi-calendar-plus text-lg"></i>

                            </div>

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Created At
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">

                                    {{ $shift->created_at?->format('d M, Y') }}

                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">

                                    {{ $shift->created_at?->format('h:i A') }}

                                </p>

                            </div>

                        </div>


                        {{-- Updated --}}
                        <div class="flex items-center gap-4 px-5 py-5">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-400">

                                <i class="bi bi-arrow-repeat text-lg"></i>

                            </div>

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Last Updated
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">

                                    {{ $shift->updated_at?->format('d M, Y') }}

                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">

                                    {{ $shift->updated_at?->diffForHumans() }}

                                </p>

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="flex items-center gap-4 px-5 py-5">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-400">

                                <i class="bi bi-toggle-on text-lg"></i>

                            </div>

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Current Status
                                </p>

                                @if ($shift->is_active)
                                    <p class="mt-1 text-sm font-semibold text-emerald-600">
                                        Active
                                    </p>
                                @else
                                    <p class="mt-1 text-sm font-semibold text-amber-600">
                                        Inactive
                                    </p>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
