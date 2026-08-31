@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Exam Sets
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage sets for your exams.
                </p>
            </div>

            {{-- Add Exam Set Button --}}
            <a href="{{ route('exam-sets.create') }}"
                class="inline-flex items-center justify-center gap-2
                   rounded-lg bg-primary px-5 py-2.5
                   text-sm font-semibold text-white
                   shadow-sm transition
                   hover:bg-primary/90
                   focus:outline-none focus:ring-2
                   focus:ring-primary/30
                   focus:ring-offset-2">

                <i class="bi bi-plus-lg text-sm"></i>

                Add Exam Set
            </a>

        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Card Header --}}
            <x-backend.card-header title="Exam Sets" :count="$examSets->total()" singular="set" plural="sets"
                action="{{ route('exam-sets.index') }}" placeholder="Search exam sets..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1300px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            {{-- ID --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                ID
                            </th>

                            {{-- Exam --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Exam
                            </th>

                            {{-- Set --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Set
                            </th>

                            {{-- Type --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Type
                            </th>

                            {{-- Question Type --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Question Type
                            </th>

                            {{-- Mode --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Mode
                            </th>

                            {{-- Marks --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Marks
                            </th>

                            {{-- Duration --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Duration
                            </th>

                            {{-- Status --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                   uppercase tracking-wide text-slate-400">
                                Status
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

                        @forelse ($examSets as $examSet)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- ID --}}
                                <td class="px-5 py-4">

                                    <div
                                        class="flex h-9 w-9 items-center
                                            justify-center rounded-lg
                                            bg-primary/10 text-sm
                                            font-bold text-primary">

                                        {{ $examSet->id }}

                                    </div>

                                </td>


                                {{-- Exam --}}
                                <td class="max-w-xs px-5 py-4">

                                    @if ($examSet->exam)
                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-700">
                                                {{ $examSet->exam->title }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                Exam #{{ $examSet->exam->id }}
                                            </p>

                                        </div>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Exam
                                        </p>
                                    @endif

                                </td>


                                {{-- Set --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-2">

                                        <span
                                            class="flex h-8 w-8 items-center
                                                 justify-center rounded-lg
                                                 bg-primary/10 text-xs
                                                 font-bold text-primary">

                                            {{ $examSet->set_number }}

                                        </span>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-700">
                                                {{ $examSet->name }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Type --}}
                                <td class="px-5 py-4">

                                    @php
                                        $typeClasses = match ($examSet->type) {
                                            'mid' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'monthly' => 'bg-purple-50 text-purple-600 border-purple-100',
                                            default => 'bg-slate-50 text-slate-600 border-slate-100',
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex items-center rounded-full
                                             border px-2.5 py-1 text-[11px]
                                             font-semibold {{ $typeClasses }}">

                                        {{ ucfirst($examSet->type) }}

                                    </span>

                                </td>


                                {{-- Question Type --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex items-center rounded-full
                                             bg-slate-50 px-2.5 py-1
                                             text-[11px] font-semibold
                                             text-slate-600">

                                        {{ strtoupper($examSet->question_type) }}

                                    </span>

                                </td>


                                {{-- Mode --}}
                                <td class="px-5 py-4">

                                    @if ($examSet->mode === 'online')
                                        <span
                                            class="inline-flex items-center gap-1.5
                                                 rounded-full bg-emerald-50
                                                 px-2.5 py-1 text-[11px]
                                                 font-semibold text-emerald-600">

                                            <i class="bi bi-globe2"></i>
                                            Online

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5
                                                 rounded-full bg-orange-50
                                                 px-2.5 py-1 text-[11px]
                                                 font-semibold text-orange-600">

                                            <i class="bi bi-building"></i>
                                            Offline

                                        </span>
                                    @endif

                                </td>


                                {{-- Marks --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm font-semibold text-slate-700">
                                        {{ number_format($examSet->total_marks, 2) }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Pass: {{ number_format($examSet->pass_marks, 2) }}
                                    </p>

                                </td>


                                {{-- Duration --}}
                                <td class="px-5 py-4">

                                    @if ($examSet->duration_minutes)
                                        <span
                                            class="inline-flex items-center gap-1.5
                                                 text-sm text-slate-600">

                                            <i class="bi bi-clock text-slate-400"></i>

                                            {{ $examSet->duration_minutes }} min

                                        </span>
                                    @else
                                        <span class="text-sm text-slate-400">
                                            No limit
                                        </span>
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @php
                                        $statusClasses = match ($examSet->status) {
                                            'draft' => 'bg-slate-50 text-slate-600 border-slate-200',
                                            'published' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'proccessing' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                            default => 'bg-slate-50 text-slate-600 border-slate-100',
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex items-center rounded-full
                                             border px-2.5 py-1 text-[11px]
                                             font-semibold {{ $statusClasses }}">

                                        {{ ucfirst($examSet->status) }}

                                    </span>

                                </td>


                                {{-- Created --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-500">
                                        {{ $examSet->created_at?->format('d M, Y') }}
                                    </p>

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('exam-sets.show', $examSet) }}" title="View Exam Set"
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
                                        <a href="{{ route('exam-sets.edit', $examSet) }}" title="Edit Exam Set"
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
                                        <form method="POST" action="{{ route('exam-sets.destroy', $examSet) }}"
                                            data-item="exam set" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Exam Set"
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

                                <td colspan="11" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12
                                                items-center justify-center
                                                rounded-full bg-slate-100">

                                            <i
                                                class="bi bi-collection
                                                  text-xl text-slate-400">
                                            </i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No exam sets found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Create your first exam set to get started.
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

                @forelse ($examSets as $examSet)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0
                                        items-center justify-center
                                        rounded-lg bg-primary/10
                                        text-sm font-bold text-primary">

                                    {{ $examSet->set_number }}

                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-semibold text-slate-700">

                                        {{ $examSet->name }}

                                    </h3>

                                    @if ($examSet->exam)
                                        <p class="mt-1 truncate text-xs text-slate-400">

                                            {{ $examSet->exam->title }}

                                        </p>
                                    @else
                                        <p class="mt-1 text-xs italic text-slate-400">
                                            No exam
                                        </p>
                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Exam Information --}}
                        <div class="mt-4 grid grid-cols-2 gap-3">

                            {{-- Type --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Type
                                </p>

                                <p class="mt-1 text-xs font-medium text-slate-600">
                                    {{ ucfirst($examSet->type) }}
                                </p>

                            </div>


                            {{-- Question Type --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Question Type
                                </p>

                                <p class="mt-1 text-xs font-medium text-slate-600">
                                    {{ strtoupper($examSet->question_type) }}
                                </p>

                            </div>


                            {{-- Mode --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Mode
                                </p>

                                <p class="mt-1 text-xs font-medium text-slate-600">
                                    {{ ucfirst($examSet->mode) }}
                                </p>

                            </div>


                            {{-- Marks --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Marks
                                </p>

                                <p class="mt-1 text-xs font-medium text-slate-600">

                                    {{ number_format($examSet->total_marks, 2) }}

                                </p>

                                <p class="mt-0.5 text-[11px] text-slate-400">

                                    Pass:
                                    {{ number_format($examSet->pass_marks, 2) }}

                                </p>

                            </div>


                            {{-- Duration --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Duration
                                </p>

                                <p class="mt-1 text-xs font-medium text-slate-600">

                                    {{ $examSet->duration_minutes ? $examSet->duration_minutes . ' min' : 'No limit' }}

                                </p>

                            </div>


                            {{-- Status --}}
                            <div class="rounded-lg bg-slate-50 p-3">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">
                                    Status
                                </p>

                                <p class="mt-1 text-xs font-medium text-slate-600">
                                    {{ ucfirst($examSet->status) }}
                                </p>

                            </div>

                        </div>


                        {{-- Weight --}}
                        <div class="mt-3 rounded-lg bg-slate-50 p-3">

                            <div class="flex items-center justify-between">

                                <p
                                    class="text-[10px] font-bold uppercase
                                      tracking-wide text-slate-400">

                                    Weight

                                </p>

                                <p class="text-xs font-semibold text-slate-600">

                                    {{ number_format($examSet->weight_percentage, 2) }}%

                                </p>

                            </div>

                        </div>


                        {{-- Created At --}}
                        <p class="mt-3 text-xs text-slate-400">

                            <i class="bi bi-calendar3 mr-1"></i>

                            {{ $examSet->created_at?->format('d M, Y') }}

                        </p>


                        {{-- Mobile Actions --}}
                        <div
                            class="mt-4 flex items-center gap-2
                                border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('exam-sets.show', $examSet) }}"
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
                            <a href="{{ route('exam-sets.edit', $examSet) }}"
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
                            <form method="POST" action="{{ route('exam-sets.destroy', $examSet) }}"
                                data-item="exam set" class="delete-form flex-1">

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

                                <i class="bi bi-collection
                                      text-xl text-slate-400">
                                </i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No exam sets found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Create your first exam set to get started.
                        </p>

                    </div>
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($examSets->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100
                        px-4 py-4 sm:flex-row sm:items-center
                        sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $examSets->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $examSets->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $examSets->total() }}
                        </span>

                        results

                    </p>


                    {{-- Pagination --}}
                    <div class="overflow-x-auto">

                        {{ $examSets->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
