@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('shifts.index') }}"
                        class="transition hover:text-primary">
                        Shifts
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>View</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    {{ $shift->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View shift information and schedule details.
                </p>

            </div>


            {{-- Actions --}}
            <div class="flex items-center gap-2">

                {{-- Back --}}
                <a href="{{ route('shifts.index') }}"
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

                    <div class="flex h-10 w-10 items-center justify-center
                                rounded-lg bg-primary/10 text-primary">

                        <i class="bi bi-clock-history text-lg"></i>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Shift Information
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Details of this shift schedule.
                        </p>

                    </div>

                </div>


                {{-- Status --}}
                @if ($shift->is_active)

                    <span class="inline-flex items-center gap-1.5
                                 rounded-full bg-emerald-50
                                 px-3 py-1.5 text-xs font-semibold
                                 text-emerald-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Active

                    </span>

                @else

                    <span class="inline-flex items-center gap-1.5
                                 rounded-full bg-amber-50
                                 px-3 py-1.5 text-xs font-semibold
                                 text-amber-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                        Inactive

                    </span>

                @endif

            </div>


            {{-- Information --}}
            <div class="divide-y divide-slate-100">


                {{-- Shift Code --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                              tracking-wide text-slate-400">
                        Shift Code
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $shift->code }}
                    </p>

                </div>


                {{-- Schedule --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase
                              tracking-wide text-slate-400">
                        Schedule
                    </p>

                    @if($shift->start_time && $shift->end_time)
                        <div class="flex items-center gap-2 text-sm font-medium text-slate-700">
                            <i class="bi bi-clock text-primary"></i>
                            <span>{{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}</span>
                            <span class="text-slate-300">–</span>
                            <span>{{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}</span>
                        </div>
                    @else
                        <p class="text-sm italic text-slate-400">
                            No schedule time specified.
                        </p>
                    @endif

                </div>


                {{-- Created At --}}
                <div class="flex flex-col gap-2 px-5 py-5
                            sm:flex-row sm:items-center
                            sm:justify-between sm:px-6">

                    <div>

                        <p class="text-xs font-semibold uppercase
                                  tracking-wide text-slate-400">
                            Created At
                        </p>

                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-calendar3 text-primary"></i>

                        @if ($shift->created_at)

                            {{ $shift->created_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $shift->created_at->format('h:i A') }}

                        @else

                            N/A

                        @endif

                    </div>

                </div>


                {{-- Updated At --}}
                <div class="flex flex-col gap-2 px-5 py-5
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

                        @if ($shift->updated_at)

                            {{ $shift->updated_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $shift->updated_at->format('h:i A') }}

                        @else

                            N/A

                        @endif

                    </div>

                </div>

            </div>


            {{-- Footer Actions --}}
            <div class="flex flex-col-reverse gap-3
                        border-t border-slate-100
                        px-5 py-4 sm:flex-row sm:justify-end sm:px-6">

                {{-- Delete --}}
                <form action="{{ route('shifts.destroy', $shift->id) }}"
                    method="POST"
                    class="delete-form flex-1">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center
                               gap-2 rounded-lg border border-red-200
                               bg-white px-4 py-2.5 text-sm font-semibold
                               text-red-500 transition
                               hover:bg-red-50 sm:w-auto">

                        <i class="bi bi-trash3"></i>

                        Delete

                    </button>

                </form>


                {{-- Edit --}}
                <a href="{{ route('shifts.edit', $shift->id) }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg bg-primary px-4 py-2.5
                           text-sm font-semibold text-white
                           transition hover:bg-primary/90">

                    <i class="bi bi-pencil-square"></i>

                    Edit Shift

                </a>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush