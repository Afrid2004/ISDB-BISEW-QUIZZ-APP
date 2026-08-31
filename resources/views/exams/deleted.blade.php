@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Deleted Exams
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage your deleted exams and restore or permanently remove them.
                </p>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('exams.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">

                <i class="bi bi-arrow-left text-sm"></i>
                Back to Exams

            </a>

        </div>


        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Card Header --}}
            <x-backend.card-header title="Deleted Items" :count="$exams->total()" singular="deleted exam" plural="deleted exams"
                action="{{ route('exams.deleted') }}" placeholder="Search deleted exams..." />

            {{-- Alerts --}}
            <x-_alerts class="m-3" />


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1100px] text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-100 bg-slate-50/60">

                        <tr>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Exam
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Course
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Batch
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Description
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Deleted At
                            </th>

                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Status
                            </th>

                            <th class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($exams as $exam)
                            <tr class="transition hover:bg-red-50/30">

                                {{-- Exam --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-sm font-bold text-red-500">

                                            <i class="bi bi-file-earmark-text"></i>

                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ $exam->title }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Course --}}
                                <td class="max-w-md px-5 py-4">

                                    @if ($exam->course)
                                        <div>

                                            <p class="truncate text-sm font-medium text-slate-600">
                                                {{ $exam->course->name }}
                                            </p>

                                            @if ($exam->course->code)
                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $exam->course->code }}
                                                </p>
                                            @endif

                                        </div>
                                    @else
                                        <p class="text-sm italic text-slate-400">
                                            No Course
                                        </p>
                                    @endif

                                </td>


                                {{-- Batch --}}
                                <td class="px-5 py-4">

                                    @if ($exam->batch)
                                        <div>

                                            <p class="text-sm font-medium text-slate-600">
                                                {{ $exam->batch->name ?? 'Batch #' . $exam->batch->id }}
                                            </p>

                                            @if (isset($exam->batch->code) && $exam->batch->code)
                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $exam->batch->code }}
                                                </p>
                                            @endif

                                        </div>
                                    @else
                                        <p class="text-sm italic text-slate-400">
                                            No Batch
                                        </p>
                                    @endif

                                </td>


                                {{-- Description --}}
                                <td class="max-w-md px-5 py-4">

                                    <p class="truncate text-sm text-slate-500">
                                        {{ $exam->description ?? 'No description available' }}
                                    </p>

                                </td>


                                {{-- Deleted At --}}
                                <td class="px-5 py-4">

                                    @if ($exam->deleted_at)
                                        <div class="flex items-center gap-2 text-sm text-slate-500">
                                            {{ $exam->deleted_at->format('d M, Y') }}
                                        </div>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $exam->deleted_at->format('h:i A') }}
                                        </p>
                                    @else
                                        <span class="text-sm text-slate-400">
                                            N/A
                                        </span>
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">

                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                        Deleted

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Restore --}}
                                        <form action="{{ route('exams.restore', $exam->id) }}" method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" title="Restore Exam"
                                                class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-500 transition hover:bg-emerald-100 hover:text-emerald-600">

                                                <i class="bi bi-arrow-counterclockwise text-sm"></i>

                                            </button>

                                        </form>


                                        {{-- Permanent Delete --}}
                                        <form method="POST" action="{{ route('exams.forceDelete', $exam->id) }}"
                                            data-item="exam permanently" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Permanently"
                                                class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 transition hover:bg-red-100 hover:text-red-600">

                                                <i class="bi bi-trash3 text-sm"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                            <i class="bi bi-trash3 text-xl text-slate-400"></i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No deleted exams found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Deleted exams will appear here.
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Mobile Cards --}}
            <div class="divide-y divide-slate-100 md:hidden">

                @forelse ($exams as $exam)
                    <div class="p-4">

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-sm font-bold text-red-500">

                                    <i class="bi bi-file-earmark-text"></i>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-semibold text-slate-700">
                                        {{ $exam->title }}
                                    </h3>

                                    @if ($exam->course)
                                        <p class="mt-1 truncate text-xs text-slate-400">
                                            {{ $exam->course->name }}
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs italic text-slate-400">
                                            No Course
                                        </p>
                                    @endif

                                </div>

                            </div>


                            {{-- Status --}}
                            <span
                                class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">

                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                Deleted

                            </span>

                        </div>


                        {{-- Batch --}}
                        <div class="mt-4">

                            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                Batch
                            </p>

                            @if ($exam->batch)
                                <p class="mt-1 text-sm font-medium text-slate-600">
                                    {{ $exam->batch->name ?? 'Batch #' . $exam->batch->id }}
                                </p>
                            @else
                                <p class="mt-1 text-sm italic text-slate-400">
                                    No Batch
                                </p>
                            @endif

                        </div>


                        {{-- Description --}}
                        @if ($exam->description)
                            <p class="mt-4 text-sm leading-6 text-slate-500">
                                {{ $exam->description }}
                            </p>
                        @else
                            <p class="mt-4 text-sm italic text-slate-400">
                                No description available
                            </p>
                        @endif


                        {{-- Deleted At --}}
                        <p class="mt-3 text-xs text-slate-400">

                            Deleted
                            {{ $exam->deleted_at?->format('d M, Y h:i A') }}

                        </p>


                        {{-- Mobile Actions --}}
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                            {{-- Restore --}}
                            <form action="{{ route('exams.restore', $exam->id) }}" method="POST" class="flex-1">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-600 transition hover:bg-emerald-100 hover:text-emerald-700">

                                    <i class="bi bi-arrow-counterclockwise"></i>

                                    Restore

                                </button>

                            </form>


                            {{-- Permanent Delete --}}
                            <form action="{{ route('exams.forceDelete', $exam->id) }}" method="POST"
                                data-item="exam permanently" class="delete-form flex-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-100 hover:text-red-600">

                                    <i class="bi bi-trash3"></i>

                                    Delete Permanently

                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="px-4 py-12 text-center">

                        <div class="mb-3 flex justify-center">

                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                <i class="bi bi-trash3 text-xl text-slate-400"></i>

                            </div>

                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No deleted exams found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Deleted exams will appear here.
                        </p>

                    </div>
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($exams->hasPages())
                <div
                    class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    {{-- Result Information --}}
                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $exams->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">–</span>

                        <span class="font-semibold text-slate-700">
                            {{ $exams->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $exams->total() }}
                        </span>

                        deleted exams

                    </p>


                    {{-- Pagination --}}
                    <div class="overflow-x-auto">
                        {{ $exams->onEachSide(1)->links() }}
                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
