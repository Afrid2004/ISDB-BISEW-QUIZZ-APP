@extends('layouts.backend.app')

@section('title', 'Deleted Batches')

@section('page-title', 'Deleted Batches')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Deleted Batches
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage deleted batches and restore or permanently remove them.
                </p>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('batches.index') }}"
                class="inline-flex items-center justify-center gap-2
                       rounded-lg border border-slate-200
                       bg-white px-5 py-2.5
                       text-sm font-semibold text-slate-600
                       shadow-sm transition
                       hover:border-primary/30
                       hover:bg-primary/10
                       hover:text-primary
                       focus:outline-none
                       focus:ring-2 focus:ring-primary/20">

                <i class="bi bi-arrow-left text-sm"></i>

                Back to Batches
            </a>

        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- card header --}}
            <x-backend.card-header title="Deleted Items" :count="$batches->total()" singular="deleted batch" plural="deleted batches"
                action="{{ route('batches.deleted') }}" placeholder="Search deleted batches..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1000px] text-left">

                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Batch
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Center
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Shift
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Status
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Deleted At
                            </th>

                            <th class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($batches as $batch)
                            <tr class="transition hover:bg-slate-50/70">


                                {{-- Batch Name --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center
                                                   justify-center rounded-lg
                                                   bg-primary/10 text-primary">

                                            <i class="bi bi-people-fill text-base"></i>

                                        </div>

                                        <div>

                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $batch->name }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                {{ $batch->batch_number }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Center --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">
                                        {{ $batch->trainingCenter->name ?? 'N/A' }}
                                    </p>

                                </td>


                                {{-- Shift --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-slate-600">
                                        {{ $batch->shift->name ?? 'N/A' }}
                                    </p>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">

                                        Deleted

                                    </span>

                                </td>


                                {{-- Deleted At --}}
                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ $batch->deleted_at?->format('d M, Y h:i A') }}
                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">


                                        {{-- Restore --}}
                                        <form action="{{ route('batches.restore', $batch->id) }}" method="POST"
                                            class="shrink-0">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" title="Restore Batch"
                                                class="flex gap-1 p-2 items-center justify-center rounded-lg text-sm border border-primary/20 bg-primary/7 text-emerald-500 transition hover:bg-primary/10 leading-none hover:text-emerald-600 cursor-pointer">

                                                <i
                                                    class="bi bi-arrow-counterclockwise text-sm flex items-center justify-center"></i>
                                                Restore

                                            </button>

                                        </form>


                                        {{-- Force Delete --}}
                                        <form action="{{ route('batches.forceDelete', $batch->id) }}" method="POST"
                                            class="delete-form shrink-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Permanently"
                                                class="flex gap-1 p-2 items-center justify-center rounded-lg text-sm border border-red-100 bg-red-50 text-red-500 transition hover:bg-red-100 hover:text-red-600 cursor-pointer leading-none">

                                                <i class="bi bi-trash3 text-sm flex items-center justify-center"></i>
                                                Delete Permanently
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                            <i class="bi bi-trash3 text-xl text-slate-400"></i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No deleted batches found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Deleted batches will appear here.
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($batches->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $batches->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">–</span>

                        <span class="font-semibold text-slate-700">
                            {{ $batches->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $batches->total() }}
                        </span>

                        results

                    </p>


                    <div class="overflow-x-auto">

                        {{ $batches->onEachSide(1)->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
