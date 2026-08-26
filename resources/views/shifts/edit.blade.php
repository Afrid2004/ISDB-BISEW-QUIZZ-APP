@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Shift</h1>
                <p class="text-sm text-slate-500">Updating information for {{ $shift->name }}.</p>
            </div>
            <a href="{{ route('shifts.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-white border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-slate-50 shadow-sm">
                <i class="bi bi-eye"></i> View All
            </a>
        </div>

        @include('components._alerts')

        <div class="mx-auto max-w-3xl md:max-w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4 bg-slate-50/30 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded bg-primary/10 text-primary">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h2 class="text-base font-bold text-slate-800 tracking-tight">Modification Panel</h2>
            </div>

            <form action="{{ route('shifts.update', $shift->id) }}" method="POST" class="px-6 py-6">
                @csrf
                @method('PUT')
                @include('shifts._form')

                <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-primary/90">
                        <i class="bi bi-check2-all"></i> Update Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection