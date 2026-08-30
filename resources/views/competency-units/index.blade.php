@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Competency Units
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage competency units for your online exam management system.
                </p>
            </div>

            {{-- Add Competency Unit --}}
            <a href="{{ route('competency-units.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2">

                <i class="bi bi-plus-lg text-sm"></i>

                Add Competency Unit

            </a>

        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Card Header --}}
            <x-backend.card-header title="Competency Units" :count="$competencyUnits->total()" singular="competency unit"
                plural="competency units" action="{{ route('competency-units.index') }}"
                placeholder="Search competency units..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[900px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Competency Unit Code
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Module
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Course
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

                        @forelse ($competencyUnits as $competencyUnit)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- Competency Unit Code --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                            <i class="bi bi-mortarboard"></i>

                                        </div>

                                        <span class="text-sm font-bold tracking-wide text-slate-700">

                                            {{ $competencyUnit->code }}

                                        </span>

                                    </div>

                                </td>


                                {{-- Module --}}
                                <td class="px-5 py-4">

                                    @if ($competencyUnit->module)
                                        <div>

                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $competencyUnit->module->name }}
                                            </p>

                                            @if ($competencyUnit->module->module_number)
                                                <p class="mt-1 text-xs text-slate-400">
                                                    Module {{ $competencyUnit->module->module_number }}
                                                </p>
                                            @endif

                                        </div>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No Module
                                        </span>
                                    @endif

                                </td>


                                {{-- Course --}}
                                <td class="px-5 py-4">

                                    @if ($competencyUnit->module?->course)
                                        <div>

                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $competencyUnit->module->course->code ?? 'No Code' }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $competencyUnit->module->course->name }}
                                            </p>

                                        </div>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No Course
                                        </span>
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($competencyUnit->is_active)
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
                                        <a href="{{ route('competency-units.show', $competencyUnit) }}"
                                            title="View Competency Unit"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                            <i class="bi bi-eye text-sm"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('competency-units.edit', $competencyUnit) }}"
                                            title="Edit Competency Unit"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                            <i class="bi bi-pencil-square text-sm"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form method="POST"
                                            action="{{ route('competency-units.destroy', $competencyUnit) }}"
                                            data-item="competency unit" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Competency Unit"
                                                class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 transition hover:bg-red-100 hover:text-red-600">

                                                <i class="bi bi-trash3 text-sm"></i>

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
                                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                            <i class="bi bi-code-square text-xl text-slate-400"></i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No competency units found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Create your first competency unit to get started.
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

                @forelse ($competencyUnits as $competencyUnit)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">

                                    <i class="bi bi-mortarboard"></i>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="text-sm font-bold tracking-wide text-slate-700">

                                        {{ $competencyUnit->code }}

                                    </h3>

                                    @if ($competencyUnit->module)
                                        <p class="mt-1 truncate text-xs text-slate-400">

                                            {{ $competencyUnit->module->name }}

                                        </p>
                                    @else
                                        <p class="mt-1 text-xs italic text-slate-400">
                                            No module
                                        </p>
                                    @endif

                                </div>

                            </div>


                            {{-- Status --}}
                            @if ($competencyUnit->is_active)
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


                        {{-- Module --}}
                        @if ($competencyUnit->module)
                            <div class="mt-4 rounded-lg bg-slate-50 px-3 py-3">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Module
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-600">
                                    {{ $competencyUnit->module->name }}
                                </p>

                                @if ($competencyUnit->module->course)
                                    <p class="mt-1 text-xs text-slate-400">

                                        {{ $competencyUnit->module->course->code }}
                                        -
                                        {{ $competencyUnit->module->course->name }}

                                    </p>
                                @endif

                            </div>
                        @endif


                        {{-- Created At --}}
                        <p class="mt-3 text-xs text-slate-400">

                            <i class="bi bi-calendar3 mr-1"></i>

                            {{ $competencyUnit->created_at?->format('d M, Y') }}

                        </p>


                        {{-- Mobile Actions --}}
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('competency-units.show', $competencyUnit) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                <i class="bi bi-eye"></i>

                                View

                            </a>


                            {{-- Edit --}}
                            <a href="{{ route('competency-units.edit', $competencyUnit) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary">

                                <i class="bi bi-pencil-square"></i>

                                Edit

                            </a>


                            {{-- Delete --}}
                            <form method="POST" action="{{ route('competency-units.destroy', $competencyUnit) }}"
                                data-item="competency unit" class="delete-form flex-1">

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

                                <i class="bi bi-code-square text-xl text-slate-400"></i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No competency units found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Create your first competency unit to get started.
                        </p>

                    </div>
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($competencyUnits->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $competencyUnits->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $competencyUnits->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $competencyUnits->total() }}
                        </span>

                        results

                    </p>


                    {{-- Pagination --}}
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
