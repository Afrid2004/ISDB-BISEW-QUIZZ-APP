@extends('layouts.backend.app')

@section('title', 'Deleted Rounds')

@section('page-title', 'Deleted Rounds')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Recycle Bin: Rounds
                </h1>
                <p class="text-sm text-slate-500">Restore or permanently purge deleted assessment rounds.</p>
            </div>

            <a href="{{ route('rounds.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-slate-50 shadow-sm">
                <i class="bi bi-arrow-left"></i> 
                Back to Active List
            </a>
        </div>

        {{-- Professional Alert System (Success/Errors) --}}
         <x-_alerts />

        {{-- Search Section --}}
        <div class="mb-5">
            <form method="GET" action="{{ route('rounds.deleted') }}">
                <div class="relative max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <i class="bi bi-search text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search deleted rounds..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/5 shadow-sm">
                </div>
            </form>
        </div>

        {{-- Unified Responsive Data Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            
            {{-- Unified Table (Renders beautifully on Mobile, Tablet, and Desktop) --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[640px]">
                    <thead class="bg-slate-50/80 border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                                Round Details
                            </th>
                            <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 hidden sm:table-cell">
                                Description
                            </th>
                            <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 hidden md:table-cell">
                                Deleted At
                            </th>
                            <th class="px-5 py-4 text-right text-[11px] font-bold uppercase tracking-widest text-slate-400">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($rounds as $round)
                            <tr class="group transition hover:bg-slate-50/50">

                                {{-- Round Title & Mobile Context --}}
                                <td class="px-5 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 font-black grayscale opacity-70">
                                            {{ sprintf('%02d', $round->round_number) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">Round {{ $round->round_number }}</p>
                                            {{-- Moved Deleted At to here for Mobile View --}}
                                            <p class="text-[10px] font-bold text-red-500 uppercase tracking-wider md:hidden">
                                                Deleted {{ $round->deleted_at?->format('d M, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Description (Hidden on extra small screens) --}}
                                <td class="px-5 py-4 align-middle hidden sm:table-cell">
                                    <p class="max-w-xs truncate text-sm text-slate-400 italic" title="{{ $round->description }}">
                                        "{{ $round->description ?? 'No description provided' }}"
                                    </p>
                                </td>

                                {{-- Timestamp (Hidden on Mobile) --}}
                                <td class="px-5 py-4 align-middle hidden md:table-cell">
                                    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                                        <i class="bi bi-trash3 text-red-400"></i>
                                        <span>{{ $round->deleted_at?->format('d M, Y') }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-slate-400">{{ $round->deleted_at?->format('h:i A') }}</span>
                                    </div>
                                </td>

                                {{-- Actions (Always visible) --}}
                                <td class="px-5 py-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('rounds.restore', $round->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" 
                                                title="Restore Round"
                                                class="inline-flex items-center justify-center gap-1 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-600 transition hover:bg-emerald-500 hover:text-white">
                                                <i class="bi bi-arrow-counterclockwise"></i> 
                                                <span class="hidden sm:inline">Restore</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('rounds.forceDelete', $round->id) }}" method="POST" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                title="Delete Permanently"
                                                class="inline-flex items-center justify-center gap-1 rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-bold text-red-500 transition hover:bg-red-500 hover:text-white">
                                                <i class="bi bi-trash3"></i> 
                                                <span class="hidden sm:inline">Delete Forever</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="rounded-full bg-slate-100 p-4">
                                            <i class="bi bi-recycle text-3xl text-slate-300"></i>
                                        </div>
                                        <p class="text-sm font-medium text-slate-400 italic">Recycle bin is perfectly clean.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($rounds->hasPages())
                <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
                    {{ $rounds->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    if (confirm('DANGER: This action is irreversible. The round will be permanently erased from the database. Proceed?')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush