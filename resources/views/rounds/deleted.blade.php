@extends('layouts.backend.app')

@section('title', 'Deleted Rounds')

@section('page-title', 'Deleted Rounds')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Deleted Rounds
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage deleted rounds and restore or permanently remove them.
                </p>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('rounds.index') }}"
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

                <i class="bi bi-arrow-left text-sm"></i>

                Back to Rounds
            </a>

        </div>


        {{-- Search --}}
        <div class="mb-4">

            <form method="GET" action="{{ route('rounds.deleted') }}">

                <div class="relative max-w-sm">

                    <i
                        class="bi bi-search absolute left-3 top-1/2
                              -translate-y-1/2 text-slate-400"></i>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search deleted rounds"
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
                                Round
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Description
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Status
                            </th>

                            <th
                                class="px-5 py-3 text-[11px]
                                       font-bold uppercase
                                       tracking-wide text-slate-400">
                                Deleted At
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

                        @forelse ($rounds as $round)
                            <tr class="transition hover:bg-slate-50/70">


                                {{-- Round --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center
                                                   justify-center rounded-lg
                                                   bg-primary/10 text-sm
                                                   font-bold text-primary">

                                            {{ $round->round_number }}

                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">

                                            Round {{ $round->round_number }}

                                        </span>

                                    </div>

                                </td>


                                {{-- Description --}}
                                <td class="max-w-md px-5 py-4">

                                    <p class="truncate text-sm text-slate-500">

                                        {{ $round->description ?? 'No description available' }}

                                    </p>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-red-50
                                               px-2.5 py-1 text-xs
                                               font-medium text-red-600">

                                        Deleted

                                    </span>

                                </td>


                                {{-- Deleted At --}}
                                <td class="px-5 py-4 text-sm text-slate-500">

                                    {{ $round->deleted_at?->format('d M, Y h:i A') }}

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">


                                        {{-- Restore --}}
                                        <form action="{{ route('rounds.restore', $round) }}" method="POST"
                                            class="shrink-0">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" title="Restore Round"
                                                class="flex gap-1 p-2
                                                       items-center
                                                       justify-center
                                                       rounded-lg
                                                       text-sm
                                                       border border-primary/20
                                                       bg-primary/7
                                                       text-emerald-500
                                                       transition
                                                       hover:bg-primary/10 leading-none
                                                       hover:text-emerald-600 cursor-pointer">

                                                <i
                                                    class="bi bi-arrow-counterclockwise text-sm flex items-center justify-center"></i>
                                                Restore

                                            </button>

                                        </form>


                                        {{-- Force Delete --}}
                                        <form method="POST" class="delete-form shrink-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Permanently"
                                                class="flex
                                                       gap-1 p-2
                                                       items-center
                                                       justify-center
                                                       rounded-lg
                                                       text-sm
                                                       border border-red-100
                                                       bg-red-50
                                                       text-red-500
                                                       transition
                                                       hover:bg-red-100
                                                       hover:text-red-600 cursor-pointer leading-none">

                                                <i class="bi bi-trash3  text-sm flex items-center justify-center"></i>
                                                Delete Permanently
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
                                                class="bi bi-trash3
                                                      text-xl text-slate-400">
                                            </i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No deleted rounds found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Deleted rounds will appear here.
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

                @forelse ($rounds as $round)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0
                                           items-center justify-center
                                           rounded-lg bg-primary/10 text-sm
                                                   font-bold text-primary">

                                    {{ $round->round_number }}

                                </div>

                                <div>

                                    <h3 class="text-sm font-semibold text-slate-700">

                                        Round {{ $round->round_number }}

                                    </h3>

                                    <p class="mt-1 text-xs text-slate-400">

                                        Deleted
                                        {{ $round->deleted_at?->format('d M, Y') }}

                                    </p>

                                </div>

                            </div>


                            {{-- Status --}}
                            <span
                                class="inline-flex shrink-0
                                       items-center gap-1.5
                                       rounded-full bg-red-50
                                       px-2.5 py-1 text-xs
                                       font-medium text-red-600">

                                Deleted

                            </span>

                        </div>


                        {{-- Description --}}
                        @if ($round->description)
                            <p class="mt-4 text-sm leading-6 text-slate-500">

                                {{ $round->description }}

                            </p>
                        @else
                            <p class="mt-4 text-sm italic text-slate-400">

                                No description available

                            </p>
                        @endif


                        {{-- Mobile Actions --}}
                        <div
                            class="mt-4 flex items-center gap-2
                                   border-t border-slate-100 pt-4">


                            {{-- Restore --}}
                            <form method="POST" class="flex-1">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="flex gap-1 p-2 w-full
                                                       items-center
                                                       justify-center
                                                       rounded-lg
                                                       text-sm
                                                       border border-primary/20
                                                       bg-primary/7
                                                       text-emerald-500
                                                       transition
                                                       hover:bg-primary/10 leading-none
                                                       hover:text-emerald-600 cursor-pointer">

                                    <i class="bi bi-arrow-counterclockwise text-sm flex items-center justify-center"></i>

                                    Restore

                                </button>

                            </form>


                            {{-- Force Delete --}}
                            <form method="POST" class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="flex w-full
                                                       gap-1 p-2
                                                       items-center
                                                       justify-center
                                                       rounded-lg
                                                       text-sm
                                                       border border-red-100
                                                       bg-red-50
                                                       text-red-500
                                                       transition
                                                       hover:bg-red-100
                                                       hover:text-red-600 cursor-pointer leading-none">

                                    <i class="bi bi-trash3 text-sm flex items-center justify-center"></i>

                                    Delete Permanently

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

                                <i class="bi bi-trash3
                                          text-xl text-slate-400">
                                </i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No deleted rounds found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Deleted rounds will appear here.
                        </p>

                    </div>
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($rounds->hasPages())
                <div
                    class="flex flex-col gap-4
                           border-t border-slate-100
                           px-4 py-4
                           sm:flex-row sm:items-center
                           sm:justify-between sm:px-5">

                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $rounds->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $rounds->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $rounds->total() }}
                        </span>

                        results

                    </p>


                    <div class="overflow-x-auto">

                        {{ $rounds->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


@push('scripts')

    {{-- Delete Confirmation --}}
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>


    {{-- Success Alert --}}
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
