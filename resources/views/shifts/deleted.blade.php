@extends('layouts.backend.app')

@section('title', 'Deleted Shifts')

@section('page-title', 'Deleted Shifts')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc] p-6 text-center">

        <div
            class="mx-auto flex max-w-md flex-col items-center justify-center rounded-xl border border-slate-200 bg-white p-8 shadow-sm">

            <div
                class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                <i class="bi bi-info-circle text-3xl text-slate-400"></i>
            </div>

            <h2 class="text-lg font-bold text-slate-800">Soft Deletes Not Enabled</h2>

            <p class="mt-2 text-sm text-slate-500">
                The shifts table does not currently use the
                <code class="rounded bg-slate-100 px-1 py-0.5 text-xs">softDeletes</code> trait.
                Please add it to the migration to restore this feature.
            </p>

            <a href="{{ route('shifts.index') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">

                <i class="bi bi-arrow-left"></i>

                Back to Shifts
            </a>

        </div>

    </div>

@endsection