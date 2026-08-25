@extends('layouts.backend.app')

@section('title', 'Batches')

@section('page-title', 'Batches')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Batches
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage assessment batches, class capacity, and schedules.
                </p>
            </div>

            <div class="flex items-center gap-2">

                {{-- Deleted Batches --}}
                <a href="{{ route('batches.deleted') }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg border border-slate-200
                           bg-white px-5 py-2.5
                           text-sm font-semibold text-slate-600
                           shadow-sm transition
                           hover:border-primary/30
                           hover:bg-primary/10
                           hover:text-primary
                           focus:outline-none
                           focus:ring-2 focus:ring-primary/20">

                    <i class="bi bi-trash3 text-sm"></i>

                    Deleted Batches
                </a>

                {{-- Create New Batch --}}
                <a href="{{ route('batches.create') }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg bg-primary px-5 py-2.5
                           text-sm font-semibold text-white
                           shadow-sm transition
                           hover:bg-primary/90
                           focus:outline-none focus:ring-2
                           focus:ring-primary/50 focus:ring-offset-2">

                    <i class="bi bi-plus-lg text-base"></i>

                    Add New Batch
                </a>

            </div>

        </div>


        {{-- Search --}}
        <div class="mb-4">

            <form method="GET" action="{{ route('batches.index') }}">

                <div class="relative max-w-sm">

                    <i
                        class="bi bi-search absolute left-3 top-1/2
                              -translate-y-1/2 text-slate-400"></i>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search batches..."
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

                <table class="w-full min-w-[1000px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Batch
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Round
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Center
                            </th>

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
                                Capacity
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

                        @forelse ($batches as $batch)
                            <tr class="transition hover:bg-slate-50/70">


                                {{-- Batch Name --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center
                                                   justify-center rounded-lg
                                                   bg-primary/10 text-primary">

                                            <i class="bi bi-people-fill text-base"></i>

                                        </div>

                                        <div>

                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $batch->name }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                {{ $batch->batch_number }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Round --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">

                                        Round {{ $batch->round->round_number ?? 'N/A' }}

                                    </p>

                                </td>


                                {{-- Center --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">

                                        {{ $batch->trainingCenter->name ?? 'N/A' }}

                                    </p>

                                </td>


                                {{-- Shift --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">

                                        {{ $batch->shift->name ?? 'N/A' }}

                                    </p>

                                </td>


                                {{-- Max Students --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-md bg-slate-100
                                               px-2 py-0.5 text-xs
                                               font-semibold text-slate-600">

                                        {{ $batch->max_students }} Students

                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($batch->is_active)
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
                                        <a href="{{ route('batches.show', $batch->id) }}" title="View Batch"
                                            class="flex items-center justify-center
                                                   rounded-lg border border-slate-200
                                                   bg-white p-2 text-sm
                                                   text-slate-500 transition
                                                   hover:bg-slate-50 hover:text-primary">

                                            <i class="bi bi-eye text-base"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('batches.edit', $batch->id) }}" title="Edit Batch"
                                            class="flex items-center justify-center
                                                   rounded-lg border border-slate-200
                                                   bg-white p-2 text-sm
                                                   text-slate-500 transition
                                                   hover:bg-slate-50 hover:text-primary">

                                            <i class="bi bi-pencil-square text-base"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form action="{{ route('batches.destroy', $batch->id) }}" method="POST"
                                            class="delete-form shrink-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Batch"
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

                                <td colspan="7" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12
                                                   items-center justify-center
                                                   rounded-full bg-slate-100">

                                            <i
                                                class="bi bi-people
                                                      text-xl text-slate-400">
                                            </i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No batches found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Create your first batch to get started.
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($batches->hasPages())
                <div
                    class="flex flex-col gap-4
                           border-t border-slate-100
                           px-4 py-4
                           sm:flex-row sm:items-center
                           sm:justify-between sm:px-5">

                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $batches->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $batches->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $batches->total() }}
                        </span>

                        results

                    </p>


                    <div class="overflow-x-auto">

                        {{ $batches->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),

                    timer: 1000,

                    showConfirmButton: false
                });

            });
        </script>
    @endif
@endpush
