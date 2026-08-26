@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Round Management</h1>
                <p class="text-sm text-slate-500">Configure and monitor assessment cycles for the exam system.</p>
            </div>

            <a href="{{ route('rounds.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-primary/90 focus:ring-4 focus:ring-primary/20">
                <i class="bi bi-plus-lg"></i>
                Create New Round
            </a>
        </div>

        {{-- Professional Alert System (Success/Errors) --}}
        <x-_alerts />

        {{-- Search & Filter Section --}}
        <div class="mb-5">
            <form method="GET" action="{{ route('rounds.index') }}">
                <div class="relative max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <i class="bi bi-search text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search by number or description..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/5 shadow-sm">
                </div>
            </form>
        </div>

        {{-- Data Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            
            {{-- Desktop Table View --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/80 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Round</th>
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Description</th>
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Status</th>
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Created At</th>
                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-widest text-slate-400">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($rounds as $round)
                            <tr class="group transition hover:bg-slate-50/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-sm font-black text-primary">
                                            {{ sprintf('%02d', $round->round_number) }}
                                        </div>
                                        <span class="font-bold text-slate-700">Round {{ $round->round_number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="max-w-xs truncate text-sm text-slate-500" title="{{ $round->description }}">
                                        {{ $round->description ?? '---' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($round->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-600 border border-emerald-100">
                                            <span class="h-1 w-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                            ACTIVE
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-500 border border-slate-200">
                                            INACTIVE
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 font-medium">
                                    {{ $round->created_at?->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('rounds.show', $round) }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-400 transition hover:text-primary hover:border-primary/30">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('rounds.edit', $round) }}" class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-400 transition hover:text-primary hover:border-primary/30">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('rounds.destroy', $round) }}" method="POST" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-md border border-red-100 bg-red-50 text-red-400 transition hover:bg-red-500 hover:text-white">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="rounded-full bg-slate-100 p-4">
                                            <i class="bi bi-inbox text-3xl text-slate-300"></i>
                                        </div>
                                        <p class="text-sm font-medium text-slate-400 italic">No assessment rounds discovered.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Stack View --}}
            <div class="divide-y divide-slate-100 md:hidden">
                @foreach ($rounds as $round)
                    <div class="p-5 flex flex-col gap-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 flex items-center justify-center rounded bg-primary/10 text-primary font-bold">
                                    {{ $round->round_number }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">Round {{ $round->round_number }}</h4>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">{{ $round->created_at?->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('rounds.edit', $round) }}" class="text-slate-400 hover:text-primary"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('rounds.destroy', $round) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-300 hover:text-red-500"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed italic">"{{ $round->description ?? 'No description provided' }}"</p>
                    </div>
                @endforeach
            </div>

            {{-- Footer / Pagination --}}
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
            // Global Delete Confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    if (confirm('Critical Action: Are you absolutely sure you want to delete this round? This cannot be undone.')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush