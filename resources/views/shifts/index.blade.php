@extends('layouts.backend.app')

@section('title', 'Shifts')

@section('page-title', 'Shifts')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Shifts
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage shift schedules, timing, and active status.
                </p>
            </div>

            <div class="flex items-center gap-2">

                {{-- Create New Shift --}}
                <a href="{{ route('shifts.create') }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg bg-primary px-5 py-2.5
                           text-sm font-semibold text-white
                           shadow-sm transition
                           hover:bg-primary/90
                           focus:outline-none focus:ring-2
                           focus:ring-primary/50 focus:ring-offset-2">

                    <i class="bi bi-plus-lg text-base"></i>

                    Add New Shift
                </a>

            </div>

        </div>


        {{-- Search --}}
        <div class="mb-4">

            <form method="GET" action="{{ route('shifts.index') }}">

                <div class="relative max-w-sm">

                    <i
                        class="bi bi-search absolute left-3 top-1/2
                              -translate-y-1/2 text-slate-400"></i>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search shifts..."
                        class="w-full rounded-lg
                               border border-slate-200
                               bg-white py-2.5 pl-10 pr-4
                               text-sm text-slate-700
                               placeholder:text-slate-400
                               outline-none transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/20">
                </div>

            </form>

        </div>


        {{-- Table Card --}}
        <div
            class="overflow-hidden rounded-xl
                    border border-slate-200
                    bg-white shadow-sm">


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[900px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Shift
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Code
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Schedule
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Status
                            </th>

                            <th
                                class="px-5 py-3 text-center
                                       text-[11px] font-bold
                                       uppercase tracking-wide
                                       text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($shifts as $shift)
                            <tr class="transition hover:bg-slate-50/70">


                                {{-- Shift Name --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center
                                                   justify-center rounded-lg
                                                   bg-primary/10 text-primary">

                                            <i class="bi bi-clock-history text-base"></i>

                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">

                                            {{ $shift->name }}

                                        </span>

                                    </div>

                                </td>


                                {{-- Code --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">

                                        {{ $shift->code }}

                                    </p>

                                </td>


                                {{-- Schedule --}}
                                <td class="px-5 py-4 text-sm text-slate-600">

                                    @if($shift->start_time && $shift->end_time)
                                        {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}
                                        <span class="text-slate-300">–</span>
                                        {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                                    @else
                                        <span class="italic text-slate-400">No time set</span>
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($shift->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   rounded-full bg-emerald-50
                                                   px-2.5 py-1 text-xs
                                                   font-medium text-emerald-600">

                                            <span
                                                class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Active

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   rounded-full bg-amber-50
                                                   px-2.5 py-1 text-xs
                                                   font-medium text-amber-600">

                                            <span
                                                class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                            Inactive

                                        </span>
                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">


                                        {{-- View --}}
                                        <a href="{{ route('shifts.show', $shift->id) }}" title="View Shift"
                                            class="flex items-center justify-center
                                                   rounded-lg border border-slate-200
                                                   bg-white p-2 text-sm
                                                   text-slate-500 transition
                                                   hover:bg-slate-50 hover:text-primary">

                                            <i class="bi bi-eye text-base"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('shifts.edit', $shift->id) }}" title="Edit Shift"
                                            class="flex items-center justify-center
                                                   rounded-lg border border-slate-200
                                                   bg-white p-2 text-sm
                                                   text-slate-500 transition
                                                   hover:bg-slate-50 hover:text-primary">

                                            <i class="bi bi-pencil-square text-base"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST"
                                            class="delete-form shrink-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Shift"
                                                class="flex items-center justify-center
                                                       rounded-lg border border-red-100
                                                       bg-red-50 p-2 text-sm
                                                       text-red-500 transition
                                                       hover:bg-red-100 hover:text-red-600 cursor-pointer">

                                                <i class="bi bi-trash3 text-base"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="5" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12
                                                   items-center justify-center
                                                   rounded-full bg-slate-100">

                                            <i
                                                class="bi bi-clock-history
                                                      text-xl text-slate-400">
                                            </i>

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

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0
                                           items-center justify-center
                                           rounded-lg bg-primary/10 text-primary">

                                    <i class="bi bi-clock-history text-lg"></i>

                                </div>

                                <div>

                                    <h3 class="text-sm font-semibold text-slate-700">

                                        {{ $shift->name }}

                                    </h3>

                                    <p class="mt-1 text-xs text-slate-400">

                                        Code: {{ $shift->code }}

                                    </p>

                                </div>

                            </div>


                            {{-- Status --}}
                            @if ($shift->is_active)
                                <span
                                    class="inline-flex shrink-0
                                           items-center gap-1.5
                                           rounded-full bg-emerald-50
                                           px-2.5 py-1 text-xs
                                           font-medium text-emerald-600">

                                    <span
                                        class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                    Active

                                </span>
                            @else
                                <span
                                    class="inline-flex shrink-0
                                           items-center gap-1.5
                                           rounded-full bg-amber-50
                                           px-2.5 py-1 text-xs
                                           font-medium text-amber-600">

                                    <span
                                        class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                    Inactive

                                </span>
                            @endif

                        </div>


                        {{-- Schedule --}}
                        @if($shift->start_time && $shift->end_time)
                            <p class="mt-4 text-sm leading-6 text-slate-500">
                                <i class="bi bi-clock"></i>
                                {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}
                                <span class="text-slate-300">–</span>
                                {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                            </p>
                        @else
                            <p class="mt-4 text-sm italic text-slate-400">
                                No time set
                            </p>
                        @endif


                        {{-- Mobile Actions --}}
                        <div
                            class="mt-4 flex items-center gap-2
                                   border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('shifts.show', $shift->id) }}"
                                class="flex items-center justify-center
                                       rounded-lg border border-slate-200
                                       bg-white p-2 text-sm
                                       text-slate-500 transition
                                       hover:bg-slate-50 hover:text-primary">

                                <i class="bi bi-eye text-base"></i>

                            </a>


                            {{-- Edit --}}
                            <a href="{{ route('shifts.edit', $shift->id) }}"
                                class="flex items-center justify-center
                                       rounded-lg border border-slate-200
                                       bg-white p-2 text-sm
                                       text-slate-500 transition
                                       hover:bg-slate-50 hover:text-primary">

                                <i class="bi bi-pencil-square text-base"></i>

                            </a>


                            {{-- Delete --}}
                            <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST"
                                class="delete-form ml-auto">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="flex items-center justify-center
                                           rounded-lg border border-red-100
                                           bg-red-50 p-2 text-sm
                                           text-red-500 transition
                                           hover:bg-red-100 hover:text-red-600 cursor-pointer">

                                    <i class="bi bi-trash3 text-base"></i>

                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="px-4 py-12 text-center">

                        <div class="mb-3 flex justify-center">

                            <div
                                class="flex h-12 w-12
                                       items-center justify-center
                                       rounded-full bg-slate-100">

                                <i class="bi bi-clock-history
                                          text-xl text-slate-400">
                                </i>

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
                    class="flex flex-col gap-4
                           border-t border-slate-100
                           px-4 py-4
                           sm:flex-row sm:items-center
                           sm:justify-between sm:px-5">

                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $shifts->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $shifts->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $shifts->total() }}
                        </span>

                        results

                    </p>


                    <div class="overflow-x-auto">

                        {{ $shifts->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


@push('scripts')

    {{-- Delete Confirmation --}}
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>

@endpush