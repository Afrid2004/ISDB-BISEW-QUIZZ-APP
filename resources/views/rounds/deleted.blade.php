@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Deleted Rounds
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Manage your deleted rounds and restore or permanently remove them.
                </p>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('rounds.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">
                <i class="bi bi-arrow-left text-sm"></i>
                Back to Rounds
            </a>
        </div>

        {{-- Search --}}
        <div class="mb-4">
            <form method="GET" action="{{ route('rounds.deleted') }}">
                <div class="relative max-w-sm">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search deleted rounds"
                        class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                </div>
            </form>
        </div>

        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Alerts --}}
            <x-_alerts class="m-3" />

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full min-w-[850px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">
                        <tr>
                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Round
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Description
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Deleted At
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

                        @forelse ($rounds as $round)
                            <tr class="transition hover:bg-red-50/30">

                                {{-- Round --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-sm font-bold text-red-500">
                                            {{ sprintf('%02d', $round->round_number) }}
                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            Round {{ $round->round_number }}
                                        </span>

                                    </div>
                                </td>

                                {{-- Description --}}
                                <td class="px-5 py-4">
                                    @if ($round->description)
                                        <p class="max-w-sm truncate text-sm text-slate-500"
                                            title="{{ $round->description }}">
                                            {{ $round->description }}
                                        </p>
                                    @else
                                        <span class="text-sm italic text-slate-400">
                                            No description provided
                                        </span>
                                    @endif
                                </td>

                                {{-- Deleted At --}}
                                <td class="px-5 py-4">
                                    @if ($round->deleted_at)
                                        <div class="flex items-center gap-2 text-sm text-slate-500">
                                            <i class="bi bi-calendar3 text-slate-400"></i>
                                            {{ $round->deleted_at->format('d M, Y') }}
                                        </div>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $round->deleted_at->format('h:i A') }}
                                        </p>
                                    @else
                                        <span class="text-sm text-slate-400">
                                            N/A
                                        </span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Deleted
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Restore --}}
                                        <form action="{{ route('rounds.restore', $round->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" title="Restore Round"
                                                class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-500 transition hover:bg-emerald-100 hover:text-emerald-600">
                                                <i class="bi bi-arrow-counterclockwise text-sm"></i>
                                            </button>
                                        </form>

                                        {{-- Permanent Delete --}}
                                        <form method="POST" action="{{ route('rounds.forceDelete', $round->id) }}"
                                            data-item="round permanently" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Permanently"
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
                                            <i class="bi bi-trash3 text-xl text-slate-400"></i>
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

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-sm font-bold text-red-500">
                                    {{ sprintf('%02d', $round->round_number) }}
                                </div>

                                <div class="min-w-0">
                                    <h3 class="truncate text-sm font-semibold text-slate-700">
                                        Round {{ $round->round_number }}
                                    </h3>

                                    <p class="mt-1 truncate text-xs text-slate-400">
                                        Round #{{ $round->round_number }}
                                    </p>
                                </div>

                            </div>

                            {{-- Status --}}
                            <span
                                class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                Deleted
                            </span>

                        </div>

                        {{-- Description --}}
                        <div class="mt-4 rounded-lg bg-slate-50 px-3 py-3">

                            <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                Description
                            </p>

                            @if ($round->description)
                                <p class="mt-1 text-sm font-medium leading-relaxed text-slate-600">
                                    {{ $round->description }}
                                </p>
                            @else
                                <p class="mt-1 text-sm italic text-slate-400">
                                    No description provided
                                </p>
                            @endif

                        </div>

                        {{-- Deleted At --}}
                        <p class="mt-3 text-xs text-slate-400">
                            <i class="bi bi-calendar3 mr-1"></i>

                            Deleted
                            {{ $round->deleted_at?->format('d M, Y h:i A') }}
                        </p>

                        {{-- Mobile Actions --}}
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                            {{-- Restore --}}
                            <form action="{{ route('rounds.restore', $round->id) }}" method="POST" class="flex-1">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-600 transition hover:bg-emerald-100 hover:text-emerald-700">

                                    <i class="bi bi-arrow-counterclockwise"></i>
                                    Restore

                                </button>

                            </form>

                            {{-- Permanent Delete --}}
                            <form action="{{ route('rounds.forceDelete', $round->id) }}" method="POST"
                                data-item="round permanently" class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-100 hover:text-red-600">

                                    <i class="bi bi-trash3"></i>
                                    Delete Permanently

                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="px-4 py-12 text-center">

                        <div class="mb-3 flex justify-center">

                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                <i class="bi bi-trash3 text-xl text-slate-400"></i>
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
                    class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    {{-- Result Information --}}
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

                        deleted rounds

                    </p>

                    {{-- Pagination --}}
                    <div class="overflow-x-auto">
                        {{ $rounds->onEachSide(1)->links() }}
                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
