@extends('layouts.backend.app')

@section('content')


    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Exam Set Competency Units
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage competency units assigned to exam sets.
                </p>
            </div>

            {{-- Add Button --}}
            <a href="{{ route('exam-set-competency-units.create') }}"
                class="inline-flex items-center justify-center gap-2
                   rounded-lg bg-primary px-5 py-2.5
                   text-sm font-semibold text-white
                   shadow-sm transition
                   hover:bg-primary/90
                   focus:outline-none focus:ring-2
                   focus:ring-primary/30
                   focus:ring-offset-2">

                <i class="bi bi-plus-lg text-sm"></i>
                Assign Competency Unit
            </a>

        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Card Header --}}
            <x-backend.card-header title="Exam Set Competency Units" :count="$examSetCompetencyUnits->total()" singular="assignment"
                plural="assignments" action="{{ route('exam-set-competency-units.index') }}"
                placeholder="Search exam set or competency unit..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[900px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            {{-- ID --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                ID
                            </th>

                            {{-- Exam Set --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Exam Set
                            </th>

                            {{-- Competency Unit --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Competency Unit
                            </th>

                            {{-- Question Count --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Questions
                            </th>

                            {{-- Created --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Created
                            </th>

                            {{-- Actions --}}
                            <th
                                class="px-5 py-3 text-center text-[11px]
                                   font-bold uppercase tracking-wide
                                   text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($examSetCompetencyUnits as $item)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- ID --}}
                                <td class="px-5 py-4">

                                    <div
                                        class="flex h-9 w-9 items-center
                                           justify-center rounded-lg
                                           bg-primary/10 text-sm
                                           font-bold text-primary">

                                        {{ $item->id }}

                                    </div>

                                </td>


                                {{-- Exam Set --}}
                                <td class="max-w-sm px-5 py-4">

                                    @if ($item->examSet)
                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-700">
                                                {{ $item->examSet->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                @if ($item->examSet->exam)
                                                    {{ $item->examSet->exam->title }}
                                                @else
                                                    No exam
                                                @endif
                                            </p>

                                        </div>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Exam Set
                                        </p>
                                    @endif

                                </td>


                                {{-- Competency Unit --}}
                                <td class="max-w-sm px-5 py-4">

                                    @if ($item->competencyUnit)
                                        <div class="min-w-0">

                                            <div class="flex items-center gap-2">

                                                <span
                                                    class="inline-flex shrink-0 items-center
                                                       rounded-md bg-blue-50
                                                       px-2 py-1 text-[10px]
                                                       font-bold text-blue-600">

                                                    {{ $item->competencyUnit->code }}

                                                </span>

                                                <p class="truncate text-sm font-semibold text-slate-700">
                                                    {{ $item->competencyUnit->name }}
                                                </p>

                                            </div>

                                            @if ($item->competencyUnit->module)
                                                <p class="mt-1 truncate text-xs text-slate-400">
                                                    Module:
                                                    {{ $item->competencyUnit->module->name }}
                                                </p>
                                            @endif

                                        </div>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Competency Unit
                                        </p>
                                    @endif

                                </td>


                                {{-- Question Count --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-2">

                                        <div
                                            class="flex h-9 w-9 items-center
                                               justify-center rounded-lg
                                               bg-emerald-50 text-emerald-600">

                                            <i class="bi bi-question-circle"></i>

                                        </div>

                                        <div>

                                            <p class="text-sm font-bold text-slate-700">
                                                {{ $item->question_count }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                Questions
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Created --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-500">
                                        {{ $item->created_at?->format('d M, Y') }}
                                    </p>

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('exam-set-competency-units.show', $item) }}"
                                            title="View Assignment"
                                            class="inline-flex h-8 w-8 items-center
                                               justify-center rounded-lg
                                               border border-slate-200
                                               bg-white text-slate-500
                                               transition
                                               hover:border-primary/30
                                               hover:bg-primary/10
                                               hover:text-primary">

                                            <i class="bi bi-eye text-sm"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('exam-set-competency-units.edit', $item) }}"
                                            title="Edit Assignment"
                                            class="inline-flex h-8 w-8 items-center
                                               justify-center rounded-lg
                                               border border-slate-200
                                               bg-white text-slate-500
                                               transition
                                               hover:border-primary/30
                                               hover:bg-primary/10
                                               hover:text-primary">

                                            <i class="bi bi-pencil-square text-sm"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form method="POST"
                                            action="{{ route('exam-set-competency-units.destroy', $item) }}"
                                            data-item="exam set competency unit" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Assignment"
                                                class="inline-flex h-8 w-8 items-center
                                                   justify-center rounded-lg
                                                   border border-red-100
                                                   bg-red-50 text-red-500
                                                   transition
                                                   hover:bg-red-100
                                                   hover:text-red-600
                                                   cursor-pointer">

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
                                            class="mb-3 flex h-12 w-12
                                               items-center justify-center
                                               rounded-full bg-slate-100">

                                            <i
                                                class="bi bi-diagram-3
                                                  text-xl text-slate-400">
                                            </i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No competency unit assignments found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Assign a competency unit to an exam set to get started.
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

                @forelse ($examSetCompetencyUnits as $item)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0
                                       items-center justify-center
                                       rounded-lg bg-primary/10
                                       text-sm font-bold text-primary">

                                    {{ $item->id }}

                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-semibold text-slate-700">

                                        {{ $item->competencyUnit?->name ?? 'No Competency Unit' }}

                                    </h3>

                                    @if ($item->examSet)
                                        <p class="mt-1 truncate text-xs text-slate-400">
                                            {{ $item->examSet->name }}
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs italic text-slate-400">
                                            No exam set
                                        </p>
                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Information --}}
                        <div class="mt-4 grid grid-cols-2 gap-3">

                            {{-- Exam --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Exam
                                </p>

                                <p class="mt-1 truncate text-xs font-medium text-slate-600">

                                    {{ $item->examSet?->exam?->title ?? 'No exam' }}

                                </p>

                            </div>


                            {{-- Competency Code --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Code
                                </p>

                                <p class="mt-1 text-xs font-semibold text-slate-600">

                                    {{ $item->competencyUnit?->code ?? 'N/A' }}

                                </p>

                            </div>


                            {{-- Question Count --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Questions
                                </p>

                                <p class="mt-1 text-xs font-semibold text-slate-600">

                                    {{ $item->question_count }}

                                </p>

                            </div>


                            {{-- Created --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Created
                                </p>

                                <p class="mt-1 text-xs font-medium text-slate-600">

                                    {{ $item->created_at?->format('d M, Y') }}

                                </p>

                            </div>

                        </div>


                        {{-- Mobile Actions --}}
                        <div
                            class="mt-4 flex items-center gap-2
                               border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('exam-set-competency-units.show', $item) }}"
                                class="inline-flex flex-1 items-center
                                   justify-center gap-2 rounded-lg
                                   border border-slate-200 bg-white
                                   px-3 py-2 text-xs font-semibold
                                   text-slate-600 transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary">

                                <i class="bi bi-eye"></i>
                                View

                            </a>


                            {{-- Edit --}}
                            <a href="{{ route('exam-set-competency-units.edit', $item) }}"
                                class="inline-flex flex-1 items-center
                                   justify-center gap-2 rounded-lg
                                   border border-slate-200 bg-white
                                   px-3 py-2 text-xs font-semibold
                                   text-slate-600 transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary">

                                <i class="bi bi-pencil-square"></i>
                                Edit

                            </a>


                            {{-- Delete --}}
                            <form method="POST" action="{{ route('exam-set-competency-units.destroy', $item) }}"
                                data-item="exam set competency unit" class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex w-full items-center
                                       justify-center gap-2 rounded-lg
                                       border border-red-100
                                       bg-red-50 px-3 py-2
                                       text-xs font-semibold
                                       text-red-500 transition
                                       hover:bg-red-100
                                       hover:text-red-600">

                                    <i class="bi bi-trash3"></i>
                                    Delete

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

                                <i class="bi bi-diagram-3
                                      text-xl text-slate-400">
                                </i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No competency unit assignments found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Assign a competency unit to an exam set to get started.
                        </p>

                    </div>
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($examSetCompetencyUnits->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100
                       px-4 py-4 sm:flex-row sm:items-center
                       sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $examSetCompetencyUnits->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $examSetCompetencyUnits->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $examSetCompetencyUnits->total() }}
                        </span>

                        results

                    </p>


                    {{-- Pagination --}}
                    <div class="overflow-x-auto">

                        {{ $examSetCompetencyUnits->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>


@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
