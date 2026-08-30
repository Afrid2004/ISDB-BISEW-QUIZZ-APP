@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Element Information
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage elements for your online exam management system.
                </p>
            </div>

            {{-- Add Element Button --}}
            <a href="{{ route('elements.create') }}"
                class="inline-flex items-center justify-center gap-2
                       rounded-lg bg-primary px-5 py-2.5
                       text-sm font-semibold text-white
                       shadow-sm transition
                       hover:bg-primary/90
                       focus:outline-none focus:ring-2
                       focus:ring-primary/30
                       focus:ring-offset-2">

                <i class="bi bi-plus-lg text-sm"></i>

                Add Element

            </a>

        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Card Header --}}
            <x-backend.card-header
                title="Elements"
                :count="$elements->total()"
                singular="element"
                plural="elements"
                action="{{ route('elements.index') }}"
                placeholder="Search elements..."
            />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1100px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            {{-- Element --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                       uppercase tracking-wide text-slate-400">

                                Element

                            </th>


                            {{-- Competency Unit --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                       uppercase tracking-wide text-slate-400">

                                Competency Unit

                            </th>


                            {{-- Module --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                       uppercase tracking-wide text-slate-400">

                                Module

                            </th>


                            {{-- Course --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                       uppercase tracking-wide text-slate-400">

                                Course

                            </th>


                            {{-- Status --}}
                            <th
                                class="px-5 py-3 text-[11px] font-bold
                                       uppercase tracking-wide text-slate-400">

                                Status

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

                        @forelse ($elements as $element)

                            <tr class="transition hover:bg-slate-50/70">


                                {{-- Element --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0
                                                   items-center justify-center
                                                   rounded-lg bg-primary/10
                                                   text-sm font-bold
                                                   text-primary">

                                            <i class="bi bi-puzzle"></i>

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-700">

                                                {{ $element->name }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Competency Unit --}}
                                <td class="max-w-md px-5 py-4">

                                    @if ($element->competencyUnit)

                                        <p class="truncate text-sm text-slate-600">

                                            {{ $element->competencyUnit->code }}

                                        </p>

                                    @else

                                        <p class="text-sm italic text-slate-400">

                                            No Competency Unit

                                        </p>

                                    @endif

                                </td>


                                {{-- Module --}}
                                <td class="max-w-md px-5 py-4">

                                    @if ($element->competencyUnit?->module)

                                        <p class="truncate text-sm text-slate-500">

                                            {{ $element->competencyUnit->module->name }}

                                        </p>

                                    @else

                                        <p class="text-sm italic text-slate-400">

                                            No Module

                                        </p>

                                    @endif

                                </td>


                                {{-- Course --}}
                                <td class="max-w-md px-5 py-4">

                                    @if ($element->competencyUnit?->module?->course)

                                        <p class="truncate text-sm text-slate-500">

                                            {{ $element->competencyUnit->module->course->name }}

                                            <span class="text-slate-400">
                                                ({{ $element->competencyUnit->module->course->code ?? 'No Code' }})
                                            </span>

                                        </p>

                                    @else

                                        <p class="text-sm italic text-slate-400">

                                            No Course

                                        </p>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($element->is_active)

                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   rounded-full bg-emerald-50
                                                   px-2.5 py-1 text-xs
                                                   font-semibold text-emerald-600">

                                            <span
                                                class="h-1.5 w-1.5 rounded-full
                                                       bg-emerald-500">
                                            </span>

                                            Active

                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   rounded-full bg-amber-50
                                                   px-2.5 py-1 text-xs
                                                   font-semibold text-amber-600">

                                            <span
                                                class="h-1.5 w-1.5 rounded-full
                                                       bg-amber-500">
                                            </span>

                                            Inactive

                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('elements.show', $element) }}"
                                            title="View Element"
                                            class="inline-flex h-8 w-8
                                                   items-center justify-center
                                                   rounded-lg border
                                                   border-slate-200
                                                   bg-white text-slate-500
                                                   transition
                                                   hover:border-primary/30
                                                   hover:bg-primary/10
                                                   hover:text-primary">

                                            <i class="bi bi-eye text-sm"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('elements.edit', $element) }}"
                                            title="Edit Element"
                                            class="inline-flex h-8 w-8
                                                   items-center justify-center
                                                   rounded-lg border
                                                   border-slate-200
                                                   bg-white text-slate-500
                                                   transition
                                                   hover:border-primary/30
                                                   hover:bg-primary/10
                                                   hover:text-primary">

                                            <i class="bi bi-pencil-square text-sm"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route('elements.destroy', $element) }}"
                                            data-item="element"
                                            class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Delete Element"
                                                class="inline-flex h-8 w-8
                                                       cursor-pointer
                                                       items-center justify-center
                                                       rounded-lg border
                                                       border-red-100
                                                       bg-red-50
                                                       text-red-500
                                                       transition
                                                       hover:bg-red-100
                                                       hover:text-red-600">

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
                                                class="bi bi-puzzle
                                                      text-xl text-slate-400">
                                            </i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">

                                            No elements found

                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">

                                            Create your first element to get started.

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

                @forelse ($elements as $element)

                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 
                                           items-center justify-center
                                           rounded-lg bg-primary/10
                                           text-sm font-bold
                                           text-primary">

                                    <i class="bi bi-puzzle"></i>

                                </div>


                                <div class="min-w-0">

                                    <h3
                                        class="truncate text-sm font-semibold
                                               text-slate-700">

                                        {{ $element->name }}

                                    </h3>


                                    @if ($element->competencyUnit)

                                        <p
                                            class="mt-1 truncate text-xs
                                                   text-slate-400">

                                            {{ $element->competencyUnit->name }}

                                        </p>

                                    @else

                                        <p
                                            class="mt-1 text-xs italic
                                                   text-slate-400">

                                            No competency unit

                                        </p>

                                    @endif

                                </div>

                            </div>


                            {{-- Status --}}
                            @if ($element->is_active)

                                <span
                                    class="inline-flex  items-center
                                           gap-1.5 rounded-full bg-emerald-50
                                           px-2.5 py-1 text-xs
                                           font-semibold text-emerald-600">

                                    <span
                                        class="h-1.5 w-1.5 rounded-full
                                               bg-emerald-500">
                                    </span>

                                    Active

                                </span>

                            @else

                                <span
                                    class="inline-flex  items-center
                                           gap-1.5 rounded-full bg-amber-50
                                           px-2.5 py-1 text-xs
                                           font-semibold text-amber-600">

                                    <span
                                        class="h-1.5 w-1.5 rounded-full
                                               bg-amber-500">
                                    </span>

                                    Inactive

                                </span>

                            @endif

                        </div>


                        {{-- Module --}}
                        @if ($element->competencyUnit?->module)

                            <p class="mt-3 text-xs text-slate-400">

                                <i class="bi bi-collection mr-1"></i>

                                {{ $element->competencyUnit->module->name }}

                            </p>

                        @endif


                        {{-- Course --}}
                        @if ($element->competencyUnit?->module?->course)

                            <p class="mt-2 text-xs text-slate-400">

                                <i class="bi bi-book mr-1"></i>

                                {{ $element->competencyUnit->module->course->name }}

                                @if ($element->competencyUnit->module->course->code)

                                    ({{ $element->competencyUnit->module->course->code }})

                                @endif

                            </p>

                        @endif


                        {{-- Description --}}
                        @if ($element->description)

                            <p class="mt-4 text-sm leading-6 text-slate-500">

                                {{ $element->description }}

                            </p>

                        @else

                            <p class="mt-4 text-sm italic text-slate-400">

                                No description available

                            </p>

                        @endif


                        {{-- Created At --}}
                        <p class="mt-3 text-xs text-slate-400">

                            <i class="bi bi-calendar3 mr-1"></i>

                            {{ $element->created_at?->format('d M, Y') }}

                        </p>


                        {{-- Mobile Actions --}}
                        <div
                            class="mt-4 flex items-center gap-2
                                   border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a
                                href="{{ route('elements.show', $element) }}"
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
                            <a
                                href="{{ route('elements.edit', $element) }}"
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
                            <form
                                method="POST"
                                action="{{ route('elements.destroy', $element) }}"
                                data-item="element"
                                class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex w-full
                                           cursor-pointer
                                           items-center justify-center
                                           gap-2 rounded-lg border
                                           border-red-100 bg-red-50
                                           px-3 py-2 text-xs
                                           font-semibold text-red-500
                                           transition hover:bg-red-100
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
                                class="flex h-12 w-12 items-center
                                       justify-center rounded-full
                                       bg-slate-100">

                                <i
                                    class="bi bi-puzzle
                                          text-xl text-slate-400">
                                </i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">

                            No elements found

                        </p>

                        <p class="mt-1 text-xs text-slate-400">

                            Create your first element to get started.

                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($elements->hasPages())

                <div
                    class="flex flex-col gap-4 border-t
                           border-slate-100 px-4 py-4
                           sm:flex-row sm:items-center
                           sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $elements->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $elements->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $elements->total() }}
                        </span>

                        results

                    </p>


                    {{-- Pagination --}}
                    <div class="overflow-x-auto">

                        {{ $elements->onEachSide(1)->links() }}

                    </div>

                </div>

            @endif

        </div>

    </div>
@endsection


@push('scripts')

    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>

@endpush