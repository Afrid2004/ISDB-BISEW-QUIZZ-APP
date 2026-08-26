@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                    <a href="{{ route('shifts.index') }}" class="transition hover:text-primary">Shifts</a>
                    <i class="bi bi-chevron-right text-[9px]"></i>
                    <span class="text-slate-500">Details</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $shift->name }}</h1>
                <p class="text-sm text-slate-500 font-medium">Viewing shift schedule and metadata.</p>
            </div>

            <a href="{{ route('shifts.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-white border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-slate-50 shadow-sm">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        @include('components._alerts')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            
            {{-- Main Information --}}
            <div class="lg:col-span-2">
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/30 px-5 py-4 sm:px-6 flex items-center justify-between">
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest">General Information</h2>
                        @if ($shift->is_active)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black text-emerald-600 border border-emerald-100">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                ACTIVE
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black text-slate-500 border border-slate-200">
                                INACTIVE
                            </span>
                        @endif
                    </div>

                    <div class="px-5 py-6 sm:px-6 space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <i class="bi bi-upc-scan text-lg"></i>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Shift Code</label>
                                <p class="text-base font-black text-slate-700">{{ $shift->code }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-[10px] font-bold uppercase tracking-wider text-slate-400">Schedule</label>
                            @if($shift->start_time && $shift->end_time)
                                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm text-primary">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700">
                                        {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}
                                        <span class="text-slate-300 mx-1">→</span>
                                        {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                                    </p>
                                </div>
                            @else
                                <p class="text-sm text-slate-400 italic">No schedule time specified for this shift.</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end border-t border-slate-100 bg-slate-50/20 px-5 py-4 sm:px-6">
                        <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST" class="delete-form sm:w-auto w-full">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-bold text-red-500 transition hover:bg-red-50">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('shifts.edit', $shift->id) }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-6 py-2 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-primary/90">
                            <i class="bi bi-pencil-square"></i> Edit Shift
                        </a>
                    </div>
                </div>
            </div>

            {{-- Metadata --}}
            <div>
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/30 px-5 py-4 sm:px-6">
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest text-center">System Log</h2>
                    </div>
                    <div class="p-5 sm:p-6 space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-50 text-slate-400">
                                <i class="bi bi-calendar-plus text-lg"></i>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-none">Created</label>
                                <p class="text-sm font-bold text-slate-700 mt-1">{{ $shift->created_at?->format('d M, Y') }}</p>
                                <p class="text-[10px] text-slate-400">{{ $shift->created_at?->format('h:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-50 text-slate-400">
                                <i class="bi bi-clock-history text-lg"></i>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-none">Last Updated</label>
                                <p class="text-sm font-bold text-slate-700 mt-1">{{ $shift->updated_at?->format('d M, Y') }}</p>
                                <p class="text-[10px] text-slate-400">{{ $shift->updated_at?->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection