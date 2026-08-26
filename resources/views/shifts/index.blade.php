@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Shift Management</h1>
                <p class="text-sm text-slate-500">Manage shift schedules and timing structures.</p>
            </div>

            <a href="{{ route('shifts.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-primary/90 focus:ring-4 focus:ring-primary/20">
                <i class="bi bi-plus-lg"></i>
                <span class="hidden sm:inline">Create New Shift</span>
                <span class="sm:hidden">Create Shift</span>
            </a>
        </div>

        @include('components._alerts')

        {{-- Search --}}
        <div class="mb-5">
            <form method="GET" action="{{ route('shifts.index') }}">
                <div class="relative max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <i class="bi bi-search text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search shifts..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/5 shadow-sm">
                </div>
            </form>
        </div>

        {{-- Unified Responsive Table --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[640px]">
                    <thead class="bg-slate-50/80 border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Shift</th>
                            <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 hidden sm:table-cell">Code</th>
                            <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 hidden md:table-cell">Schedule</th>
                            <th class="px-5 py-4 text-right text-[11px] font-bold uppercase tracking-widest text-slate-400">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($shifts as $shift)
                            <tr class="group transition hover:bg-slate-50/50">
                                {{-- Shift Info (Mobile shows Status inline) --}}
                                <td class="px-5 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">{{ $shift->name }}</p>
                                            <p class="text-[10px] text-slate-500 font-medium md:hidden">
                                                @if($shift->start_time && $shift->end_time)
                                                    {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                                                @else
                                                    No time set
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Code --}}
                                <td class="px-5 py-4 align-middle hidden sm:table-cell">
                                    <span class="inline-flex items-center rounded bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $shift->code }}</span>
                                </td>

                                {{-- Schedule --}}
                                <td class="px-5 py-4 align-middle hidden md:table-cell">
                                    @if($shift->start_time && $shift->end_time)
                                        <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }} <span class="text-slate-300">–</span> {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}</p>
                                    @else
                                        <span class="italic text-slate-400 text-sm">No time set</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('shifts.show', $shift) }}" title="View" class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-400 transition hover:text-primary hover:border-primary/30">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('shifts.edit', $shift) }}" title="Edit" class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-400 transition hover:text-primary hover:border-primary/30">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('shifts.destroy', $shift) }}" method="POST" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Delete" class="flex h-8 w-8 items-center justify-center rounded-md border border-red-100 bg-red-50 text-red-400 transition hover:bg-red-500 hover:text-white">
                                                <i class="bi bi-trash3"></i>
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
                                            <i class="bi bi-clock-history text-3xl text-slate-300"></i>
                                        </div>
                                        <p class="text-sm font-medium text-slate-400 italic">No shifts configured.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($shifts->hasPages())
                <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
                    {{ $shifts->onEachSide(1)->links() }}
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
                    if (confirm('Are you absolutely sure you want to delete this shift?')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush