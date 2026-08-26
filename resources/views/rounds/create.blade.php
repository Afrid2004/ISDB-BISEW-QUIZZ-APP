@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Add New Round</h1>
                <p class="text-sm text-slate-500">Create a new assessment cycle.</p>
            </div>
            <a href="{{ route('rounds.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-white border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-slate-50 shadow-sm">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="mx-auto max-w-3xl md:max-w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4 bg-slate-50/30">
                <h2 class="text-base font-bold text-slate-800 uppercase tracking-wider">Round Configuration</h2>
            </div>

            <form action="{{ route('rounds.store') }}" method="POST" class="px-6 py-6">
                @csrf
                 <x-_alerts />
                @include('rounds._form')

                <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-primary/90">
                        <i class="bi bi-plus-circle"></i> Save Round
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection