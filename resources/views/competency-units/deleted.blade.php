@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('competency-units.index') }}" class="transition hover:text-primary">
                        Competency Units
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>Deleted</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    Deleted Competency Units
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Restore deleted competency units or permanently remove them.
                </p>

            </div>


            {{-- Back Button --}}
            <a href="{{ route('competency-units.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg
                       border border-slate-200 bg-white px-5 py-2.5
                       text-sm font-semibold text-slate-600 shadow-sm
                       transition hover:border-primary/30 hover:bg-primary/10
                       hover:text-primary focus:outline-none
                       focus:ring-2 focus:ring-primary/20">

                <i class="bi bi-arrow-left"></i>

                Back to Competency Units

            </a>

        </div>


        {{-- Main Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Card Header --}}
            <x-backend.card-header title="Deleted Items" :count="$competencyUnits->total()" singular="deleted competency unit"
                plural="deleted competency units" action="{{ route('competency-units.deleted') }}"
                placeholder="Search deleted competency units..." />


            {{-- Alerts --}}
            <x-_alerts class="m-4" />


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1000px] text-left">

                    {{-- Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/70">

                        <tr>

                            <th
                                class="px-6 py-3 text-[11px] font-bold uppercase
                                       tracking-wide text-slate-400">
                                Competency Unit
                            </th>

                            <th
                                class="px-6 py-3 text-[11px] font-bold uppercase
                                       tracking-wide text-slate-400">
                                Module
                            </th>

                            <th
                                class="px-6 py-3 text-[11px] font-bold uppercase
                                       tracking-wide text-slate-400">
                                Course
                            </th>

                            <th
                                class="px-6 py-3 text-[11px] font-bold uppercase
                                       tracking-wide text-slate-400">
                                Deleted At
                            </th>

                            <th
                                class="px-6 py-3 text-[11px] font-bold uppercase
                                       tracking-wide text-slate-400">
                                Status
                            </th>

                            <th
                                class="px-6 py-3 text-center text-[11px]
                                       font-bold uppercase tracking-wide text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    {{-- Body --}}
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($competencyUnits as $competencyUnit)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- Competency Unit --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 shrink-0
                                                   items-center justify-center
                                                   rounded-lg bg-red-50
                                                   text-red-500">

                                            <i class="bi bi-code-square text-base"></i>

                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $competencyUnit->code }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                Serial #{{ $competencyUnit->serial }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Module --}}
                                <td class="px-6 py-4">

                                    @if ($competencyUnit->module)
                                        <div>

                                            <div class="flex items-center gap-2">

                                                <span
                                                    class="inline-flex items-center rounded-md
                                                           bg-primary/10 px-2 py-1
                                                           text-[11px] font-bold
                                                           text-primary">

                                                    Module
                                                    {{ $competencyUnit->module->module_number }}

                                                </span>

                                            </div>

                                            <p class="mt-1.5 text-sm font-medium text-slate-600">
                                                {{ $competencyUnit->module->name }}
                                            </p>

                                        </div>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No module
                                        </span>
                                    @endif

                                </td>


                                {{-- Course --}}
                                <td class="px-6 py-4">

                                    @if ($competencyUnit->module?->course)
                                        <div>

                                            <p class="text-sm font-medium text-slate-600">
                                                {{ $competencyUnit->module->course->name }}
                                            </p>

                                            @if ($competencyUnit->module->course->code)
                                                <span
                                                    class="mt-1 inline-flex items-center
                                                           rounded-md bg-slate-100
                                                           px-2 py-1 text-[11px]
                                                           font-semibold text-slate-500">

                                                    {{ $competencyUnit->module->course->code }}

                                                </span>
                                            @endif

                                        </div>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No course
                                        </span>
                                    @endif

                                </td>


                                {{-- Deleted At --}}
                                <td class="px-6 py-4">

                                    @if ($competencyUnit->deleted_at)
                                        <div class="flex items-center gap-2">

                                            <i class="bi bi-calendar3 text-sm text-slate-400"></i>

                                            <div>

                                                <p class="text-sm font-medium text-slate-600">
                                                    {{ $competencyUnit->deleted_at->format('d M, Y') }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $competencyUnit->deleted_at->format('h:i A') }}
                                                </p>

                                            </div>

                                        </div>
                                    @else
                                        <span class="text-sm text-slate-400">
                                            N/A
                                        </span>
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-red-50 px-2.5 py-1
                                               text-xs font-semibold text-red-600">

                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500">
                                        </span>

                                        Deleted

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Restore --}}
                                        <form action="{{ route('competency-units.restore', $competencyUnit->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" title="Restore"
                                                class="inline-flex h-9 w-9 cursor-pointer
                                                       items-center justify-center
                                                       rounded-lg border
                                                       border-emerald-100
                                                       bg-emerald-50
                                                       text-emerald-500
                                                       transition
                                                       hover:bg-emerald-100
                                                       hover:text-emerald-600">

                                                <i class="bi bi-arrow-counterclockwise"></i>

                                            </button>

                                        </form>


                                        {{-- Permanent Delete --}}
                                        <form action="{{ route('competency-units.forceDelete', $competencyUnit->id) }}"
                                            method="POST" data-item="competency unit permanently" class="delete-form">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" title="Delete Permanently"
                                                class="inline-flex h-9 w-9 cursor-pointer
                                                       items-center justify-center
                                                       rounded-lg border
                                                       border-red-100
                                                       bg-red-50
                                                       text-red-500
                                                       transition
                                                       hover:bg-red-100
                                                       hover:text-red-600">

                                                <i class="bi bi-trash3"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-4 flex h-14 w-14 items-center
                                                   justify-center rounded-full
                                                   bg-slate-100">

                                            <i class="bi bi-trash3 text-xl text-slate-400"></i>

                                        </div>

                                        <p class="text-sm font-semibold text-slate-600">
                                            No deleted competency units found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Deleted competency units will appear here.
                                        </p>

                                        @if (request('search'))
                                            <a href="{{ route('competency-units.deleted') }}"
                                                class="mt-4 text-xs font-semibold
                                                       text-primary hover:underline">

                                                Clear search

                                            </a>
                                        @endif

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Mobile Cards --}}
            <div class="divide-y divide-slate-100 md:hidden">

                @forelse ($competencyUnits as $competencyUnit)
                    <div class="p-5">

                        {{-- Header --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0
                                           items-center justify-center
                                           rounded-lg bg-red-50
                                           text-red-500">

                                    <i class="bi bi-code-square"></i>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-bold text-slate-700">
                                        {{ $competencyUnit->code }}
                                    </h3>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Serial #{{ $competencyUnit->serial }}
                                    </p>

                                </div>

                            </div>


                            {{-- Status --}}
                            <span
                                class="inline-flex shrink-0 items-center gap-1.5
                                       rounded-full bg-red-50 px-2.5 py-1
                                       text-xs font-semibold text-red-600">

                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                Deleted

                            </span>

                        </div>


                        {{-- Module --}}
                        @if ($competencyUnit->module)
                            <div class="mt-4 rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                          tracking-wide text-slate-400">
                                    Module
                                </p>

                                <div class="mt-1 flex items-center gap-2">

                                    <span
                                        class="rounded-md bg-primary/10 px-2 py-1
                                               text-[11px] font-bold text-primary">

                                        Module {{ $competencyUnit->module->module_number }}

                                    </span>

                                    <span class="truncate text-sm font-medium text-slate-600">
                                        {{ $competencyUnit->module->name }}
                                    </span>

                                </div>

                            </div>
                        @endif


                        {{-- Course --}}
                        @if ($competencyUnit->module?->course)
                            <div class="mt-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                          tracking-wide text-slate-400">
                                    Course
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-600">
                                    {{ $competencyUnit->module->course->name }}
                                </p>

                                @if ($competencyUnit->module->course->code)
                                    <span
                                        class="mt-1 inline-flex rounded-md
                                               bg-slate-100 px-2 py-1
                                               text-[11px] font-semibold
                                               text-slate-500">

                                        {{ $competencyUnit->module->course->code }}

                                    </span>
                                @endif

                            </div>
                        @endif


                        {{-- Deleted At --}}
                        <div class="mt-4 flex items-center gap-2 text-xs text-slate-400">

                            <i class="bi bi-calendar3"></i>

                            <span>
                                Deleted
                                {{ $competencyUnit->deleted_at?->format('d M, Y') }}
                                at
                                {{ $competencyUnit->deleted_at?->format('h:i A') }}
                            </span>

                        </div>


                        {{-- Actions --}}
                        <div class="mt-4 flex gap-2 border-t border-slate-100 pt-4">

                            {{-- Restore --}}
                            <form action="{{ route('competency-units.restore', $competencyUnit->id) }}" method="POST"
                                class="flex-1">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="inline-flex w-full cursor-pointer
                                           items-center justify-center gap-2
                                           rounded-lg border border-emerald-100
                                           bg-emerald-50 px-3 py-2.5
                                           text-xs font-semibold
                                           text-emerald-600 transition
                                           hover:bg-emerald-100">

                                    <i class="bi bi-arrow-counterclockwise"></i>

                                    Restore

                                </button>

                            </form>


                            {{-- Permanent Delete --}}
                            <form action="{{ route('competency-units.forceDelete', $competencyUnit->id) }}"
                                method="POST" data-item="competency unit permanently" class="delete-form flex-1">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="inline-flex w-full cursor-pointer
                                           items-center justify-center gap-2
                                           rounded-lg border border-red-100
                                           bg-red-50 px-3 py-2.5
                                           text-xs font-semibold
                                           text-red-500 transition
                                           hover:bg-red-100">

                                    <i class="bi bi-trash3"></i>

                                    Delete Permanently

                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="px-5 py-16 text-center">

                        <div
                            class="mx-auto mb-4 flex h-14 w-14
                                   items-center justify-center
                                   rounded-full bg-slate-100">

                            <i class="bi bi-trash3 text-xl text-slate-400"></i>

                        </div>

                        <p class="text-sm font-semibold text-slate-600">
                            No deleted competency units found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Deleted competency units will appear here.
                        </p>

                    </div>
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($competencyUnits->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100
                           px-5 py-4 sm:flex-row sm:items-center
                           sm:justify-between">

                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $competencyUnits->firstItem() }}
                        </span>

                        <span class="px-1 text-slate-400">–</span>

                        <span class="font-semibold text-slate-700">
                            {{ $competencyUnits->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $competencyUnits->total() }}
                        </span>

                        deleted competency units

                    </p>


                    <div class="overflow-x-auto">

                        {{ $competencyUnits->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
