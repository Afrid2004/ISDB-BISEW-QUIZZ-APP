@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('batches.index') }}"
                        class="transition hover:text-primary">
                        Batches
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>View</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    {{ $batch->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View batch information and class details.
                </p>

            </div>


            {{-- Actions --}}
            <div class="flex items-center gap-2">

                {{-- Back --}}
                <a href="{{ route('batches.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">

                    <i class="bi bi-arrow-left"></i>

                    Back

                </a>

            </div>

        </div>


        {{-- Main Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">

                        <i class="bi bi-people-fill text-lg"></i>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Batch Information
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Details of this assessment batch.
                        </p>

                    </div>

                </div>


                {{-- Status --}}
                @if ($batch->is_active)

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Active

                    </span>

                @else

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                        Inactive

                    </span>

                @endif

            </div>


            {{-- Information --}}
            <div class="divide-y divide-slate-100">


                {{-- Batch Number --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Batch Number
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $batch->batch_number }}
                    </p>

                </div>


                {{-- Relationships --}}
                <div class="grid grid-cols-1 gap-0 md:grid-cols-3 md:divide-x md:divide-slate-100">

                    <div class="px-5 py-5 sm:px-6">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Round</p>
                        <p class="text-sm font-medium text-slate-700">
                            <i class="bi bi-layers text-primary"></i>
                            Round {{ $batch->round->round_number ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="px-5 py-5 sm:px-6">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Training Center</p>
                        <p class="text-sm font-medium text-slate-700">
                            <i class="bi bi-building text-primary"></i>
                            {{ $batch->trainingCenter->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="px-5 py-5 sm:px-6">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Shift</p>
                        <p class="text-sm font-medium text-slate-700">
                            <i class="bi bi-clock-history text-primary"></i>
                            {{ $batch->shift->name ?? 'N/A' }}
                        </p>
                    </div>

                </div>


                {{-- Max Students --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Maximum Capacity
                    </p>

                    <p class="text-sm font-medium text-slate-700">
                        <i class="bi bi-person-plus text-primary"></i>
                        {{ $batch->max_students }} Students
                    </p>

                </div>


                {{-- Description --}}
                <div class="px-5 py-5 sm:px-6">

                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Description
                    </p>

                    @if ($batch->description)

                        <p class="text-sm leading-6 text-slate-600">{{ $batch->description }}</p>

                    @else

                        <p class="text-sm italic text-slate-400">No description available.</p>

                    @endif

                </div>


                {{-- Created At --}}
                <div class="flex flex-col gap-2 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Created At</p>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-calendar3 text-primary"></i>

                        @if ($batch->created_at)

                            {{ $batch->created_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $batch->created_at->format('h:i A') }}

                        @else

                            N/A

                        @endif

                    </div>

                </div>


                {{-- Updated At --}}
                <div class="flex flex-col gap-2 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Last Updated</p>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-clock-history text-primary"></i>

                        @if ($batch->updated_at)

                            {{ $batch->updated_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $batch->updated_at->format('h:i A') }}

                        @else

                            N/A

                        @endif

                    </div>

                </div>

            </div>


            {{-- Footer Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">

                {{-- Delete --}}
                <form action="{{ route('batches.destroy', $batch->id) }}" method="POST" class="delete-form flex-1">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-500 transition hover:bg-red-50 sm:w-auto">

                        <i class="bi bi-trash3"></i>

                        Delete

                    </button>

                </form>


                {{-- Edit --}}
                <a href="{{ route('batches.edit', $batch->id) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">

                    <i class="bi bi-pencil-square"></i>

                    Edit Batch

                </a>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush