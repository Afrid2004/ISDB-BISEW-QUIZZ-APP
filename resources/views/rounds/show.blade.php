@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                    <a href="{{ route('rounds.index') }}" class="transition hover:text-primary">Rounds</a>
                    <i class="bi bi-chevron-right text-[9px]"></i>
                    <span class="text-slate-500">Details</span>
                </div>

                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Round {{ sprintf('%02d', $round->round_number) }}
                </h1>
                <p class="text-sm text-slate-500 font-medium">Viewing full configuration and metadata.</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('rounds.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-white border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-slate-50 shadow-sm">
                    <i class="bi bi-arrow-left"></i> 
                    <span class="hidden sm:inline">Back to List</span>
                    <span class="sm:hidden">Back</span>
                </a>
            </div>
        </div>

        {{-- Professional Alert System (Success/Errors) --}}
         <x-_alerts />

        {{-- Responsive Grid Layout --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            
            {{-- Primary Information Card --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/30 px-5 py-4 sm:px-6 flex items-center justify-between">
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest">General Information</h2>
                        
                        {{-- Status Badge --}}
                        @if ($round->is_active)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black text-emerald-600 border border-emerald-100">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                ACTIVE
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black text-slate-500 border border-slate-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                INACTIVE
                            </span>
                        @endif
                    </div>

                    <div class="px-5 py-6 sm:px-6 space-y-8">
                        {{-- Round ID/Number Display --}}
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <i class="bi bi-hash text-2xl font-bold"></i>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Identity Number</label>
                                <p class="text-lg font-black text-slate-700">Round {{ $round->round_number }}</p>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="mb-2 block text-[10px] font-bold uppercase tracking-wider text-slate-400">Description / Notes</label>
                            <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                                @if($round->description)
                                    <p class="text-sm leading-relaxed text-slate-600 italic">"{{ $round->description }}"</p>
                                @else
                                    <p class="text-sm text-slate-400 italic text-center">No description provided for this round.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end border-t border-slate-100 bg-slate-50/20 px-5 py-4 sm:px-6">
                        <form action="{{ route('rounds.destroy', $round->id) }}" method="POST" class="delete-form sm:w-auto w-full">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-bold text-red-500 transition hover:bg-red-50">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('rounds.edit', $round->id) }}"
                            class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-6 py-2 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-primary/90">
                            <i class="bi bi-pencil-square"></i> Edit Round
                        </a>
                    </div>
                </div>
            </div>

            {{-- Metadata Sidebar --}}
            <div class="space-y-6">
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/30 px-5 py-4 sm:px-6 text-center sm:text-left">
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest">System Log</h2>
                    </div>
                    
                    <div class="p-5 sm:p-6 space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-50 text-slate-400">
                                <i class="bi bi-calendar-plus text-lg"></i>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-none">Created</label>
                                <p class="text-sm font-bold text-slate-700 mt-1">{{ $round->created_at?->format('d M, Y') }}</p>
                                <p class="text-[10px] text-slate-400">{{ $round->created_at?->format('h:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-50 text-slate-400">
                                <i class="bi bi-clock-history text-lg"></i>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-none">Last Updated</label>
                                <p class="text-sm font-bold text-slate-700 mt-1">{{ $round->updated_at?->format('d M, Y') }}</p>
                                <p class="text-[10px] text-slate-400">
                                    {{ $round->updated_at?->format('h:i A') }} 
                                    <span class="opacity-75">({{ $round->updated_at?->diffForHumans() }})</span>
                                </p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-dashed border-slate-200">
                            <div class="bg-primary/5 rounded-lg p-3 text-center">
                                <i class="bi bi-shield-lock text-primary mb-1 block"></i>
                                <span class="text-[10px] font-bold text-primary uppercase">Database ID: {{ $round->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
