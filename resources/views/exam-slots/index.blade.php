@extends('layouts.backend.app')

@section('content') <div class="min-h-screen bg-[#f7f8fc]"> <div class="mx-auto w-full max-w-[1600px]"> <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"> <div> <h1 class="text-2xl font-bold text-slate-800">
Exam Slot Information </h1> <p class="mt-1 text-sm text-slate-500">
Manage exam schedules for your online exam management system. </p> </div>


            <a href="{{ route('exam-slots.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2">
                <i class="bi bi-plus-lg text-sm"></i>
                Add Exam Slot
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <x-backend.card-header
                title="Exam Slots"
                :count="$examSlots->total()"
                singular="exam slot"
                plural="exam slots"
                action="{{ route('exam-slots.index') }}"
                placeholder="Search exam slots..." />

            <x-_alerts class="m-3" />

            {{-- Desktop --}}
            <div class="hidden overflow-x-auto 2xl:block">
                <table class="w-full min-w-[1300px] text-left">
                    <thead class="border-b border-slate-100 bg-slate-50/60">
                        <tr>
                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                ID
                            </th>
                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Batch
                            </th>
                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Exam
                            </th>
                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Exam Set
                            </th>
                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Schedule
                            </th>
                            <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Status
                            </th>
                            <th class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-wide text-slate-400">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($examSlots as $examSlot)
                            <tr class="exam-slot-row transition hover:bg-slate-50/70"
                                data-status="{{ $examSlot->status }}"
                                data-start-at="{{ $examSlot->start_at?->toIso8601String() }}"
                                data-end-at="{{ $examSlot->end_at?->toIso8601String() }}">

                                {{-- ID --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-sm font-bold text-primary">
                                            {{ sprintf('%02d', $examSlot->id) }}
                                        </div>

                                        <p class="text-sm font-semibold text-slate-700">
                                            Slot #{{ $examSlot->id }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Batch --}}
                                <td class="max-w-md px-5 py-4">
                                    @if ($examSlot->batch)
                                        <p class="text-[13px] font-medium text-slate-700">
                                            {{ $examSlot->batch->name }}
                                        </p>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Batch
                                        </p>
                                    @endif
                                </td>

                                {{-- Exam --}}
                                <td class="max-w-md px-5 py-4">
                                    @if ($examSlot->examSet?->exam)
                                        <p class="truncate text-sm text-slate-700">
                                            {{ $examSlot->examSet->exam->title }}
                                        </p>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Exam
                                        </p>
                                    @endif
                                </td>

                                {{-- Exam Set --}}
                                <td class="max-w-md px-5 py-4">
                                    @if ($examSlot->examSet)
                                        <p class="truncate text-sm text-slate-500">
                                            {{ $examSlot->examSet->name }}
                                        </p>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No Exam Set
                                        </p>
                                    @endif
                                </td>

                                {{-- Schedule --}}
                                <td class="px-5 py-4">
                                    <div class="space-y-1">
                                        @if ($examSlot->status === 'scheduled')
                                            <p class="schedule-live text-xs font-medium text-slate-600">
                                                Starts:
                                                {{ $examSlot->start_at?->format('d M, Y h:i A') }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                End:
                                                {{ $examSlot->end_at?->format('d M, Y h:i A') }}
                                            </p>
                                        @elseif ($examSlot->status === 'start')
                                            <p class="text-xs font-medium text-slate-600">
                                                Started:
                                                {{ $examSlot->started_at?->format('d M, Y h:i A') }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                End:
                                                {{ $examSlot->end_at?->format('d M, Y h:i A') }}
                                            </p>

                                            <div class="overtime-container hidden">
                                                <p class="text-xs font-semibold text-red-500">
                                                    Overtime:
                                                    <span class="overtime-timer">
                                                        +00:00:00
                                                    </span>
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-xs font-medium text-slate-600">
                                                Started:
                                                {{ $examSlot->started_at?->format('d M, Y h:i A') ?? 'Not Started' }}
                                            </p>

                                            <p class="text-xs font-medium text-slate-500">
                                                Ended:
                                                {{ $examSlot->ended_at?->format('d M, Y h:i A') }}
                                            </p>

                                            @if ($examSlot->ended_at && $examSlot->end_at && $examSlot->ended_at->gt($examSlot->end_at))
                                                <p class="text-xs font-semibold text-red-500">
                                                    Extra Time:
                                                    {{ $examSlot->end_at->diffForHumans($examSlot->ended_at, true) }}
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4">
                                    @if ($examSlot->status === 'scheduled')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Scheduled
                                        </span>
                                    @elseif ($examSlot->status === 'start')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Started
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                                            Ended
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('exam-slots.show', $examSlot) }}"
                                            title="View Exam Slot"
                                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-primary/30 bg-primary/10 px-4 py-2.5 text-sm font-bold text-primary transition hover:border-primary/50 hover:bg-primary/15 hover:shadow">
                                            <i class="bi bi-eye-fill text-base"></i>
                                            <span>View</span>
                                        </a>

                                        {{-- Edit --}}
                                        @if ($examSlot->status === 'scheduled')
                                            <a href="{{ route('exam-slots.edit', $examSlot) }}"
                                                title="Edit Exam Slot"
                                                class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-primary/30 bg-primary/10 px-4 py-2.5 text-sm font-bold text-primary transition hover:border-primary/50 hover:bg-primary/15 hover:shadow">
                                                <i class="bi bi-pencil-square text-base"></i>
                                                <span>Edit</span>
                                            </a>
                                        @endif

                                        {{-- Start --}}
                                        @if ($examSlot->status === 'scheduled' && $examSlot->is_active)
                                            <form method="POST"
                                                action="{{ route('exam-slots.start', $examSlot) }}"
                                                data-exam-action="start">
                                                @csrf

                                                <button type="submit"
                                                    title="Start Exam"
                                                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-primary/30 bg-primary px-4 py-2.5 text-sm font-bold text-white transition hover:bg-primary/90 hover:shadow">
                                                    <i class="bi bi-play-fill text-base"></i>
                                                    <span>Start</span>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- End --}}
                                        @if ($examSlot->status === 'start' && $examSlot->is_active)
                                            <form method="POST"
                                                action="{{ route('exam-slots.end', $examSlot) }}"
                                                data-exam-action="end">
                                                @csrf

                                                <button type="submit"
                                                    title="End Exam"
                                                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-primary/30 bg-primary px-4 py-2.5 text-sm font-bold text-white transition hover:bg-primary/90 hover:shadow">
                                                    <i class="bi bi-stop-fill text-base"></i>
                                                    <span>End</span>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Delete --}}
                                        @if ($examSlot->status === 'scheduled')
                                            <form method="POST"
                                                action="{{ route('exam-slots.destroy', $examSlot) }}"
                                                data-delete-form>
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    title="Delete Exam Slot"
                                                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-primary/30 bg-primary/10 px-4 py-2.5 text-sm font-bold text-primary transition hover:border-primary/50 hover:bg-primary/15 hover:shadow">
                                                    <i class="bi bi-trash3-fill text-base"></i>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                            <i class="bi bi-calendar-x text-xl text-slate-400"></i>
                                        </div>

                                        <p class="text-sm font-medium text-slate-600">
                                            No exam slots found
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Create your first exam slot to get started.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile --}}
            <div class="divide-y divide-slate-100 2xl:hidden">
                @forelse ($examSlots as $examSlot)
                    <div class="exam-slot-row p-4"
                        data-status="{{ $examSlot->status }}"
                        data-start-at="{{ $examSlot->start_at?->toIso8601String() }}"
                        data-end-at="{{ $examSlot->end_at?->toIso8601String() }}">

                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-sm font-bold text-primary">
                                <i class="bi bi-calendar-event"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h3 class="truncate text-sm font-semibold text-slate-700">
                                    {{ $examSlot->examSet?->name ?? 'No Exam Set' }}
                                </h3>

                                <p class="mt-1 truncate text-xs text-slate-400">
                                    {{ $examSlot->batch?->name ?? 'No Batch' }}
                                </p>
                            </div>
                        </div>

                        <p class="mt-4 text-sm font-medium text-slate-600">
                            {{ $examSlot->examSet?->exam?->title ?? 'No Exam' }}
                        </p>

                        {{-- Schedule --}}
                        <div class="mt-3 space-y-1">
                            @if ($examSlot->status === 'scheduled')
                                <p class="schedule-live text-xs text-slate-500">
                                    Starts:
                                    {{ $examSlot->start_at?->format('d M, Y h:i A') }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    End:
                                    {{ $examSlot->end_at?->format('d M, Y h:i A') }}
                                </p>
                            @elseif ($examSlot->status === 'start')
                                <p class="text-xs text-slate-600">
                                    Started:
                                    {{ $examSlot->started_at?->format('d M, Y h:i A') }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    End:
                                    {{ $examSlot->end_at?->format('d M, Y h:i A') }}
                                </p>

                                <div class="overtime-container hidden">
                                    <p class="text-xs font-semibold text-red-500">
                                        Overtime:
                                        <span class="overtime-timer">
                                            +00:00:00
                                        </span>
                                    </p>
                                </div>
                            @else
                                <p class="text-xs text-slate-500">
                                    Started:
                                    {{ $examSlot->started_at?->format('d M, Y h:i A') ?? 'Not Started' }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    Ended:
                                    {{ $examSlot->ended_at?->format('d M, Y h:i A') }}
                                </p>

                                @if ($examSlot->ended_at && $examSlot->end_at && $examSlot->ended_at->gt($examSlot->end_at))
                                    <p class="text-xs font-semibold text-red-500">
                                        Extra Time:
                                        {{ $examSlot->end_at->diffForHumans($examSlot->ended_at, true) }}
                                    </p>
                                @endif
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="mt-3">
                            @if ($examSlot->status === 'scheduled')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    Scheduled
                                </span>
                            @elseif ($examSlot->status === 'start')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Started
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                                    Ended
                                </span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">

                            {{-- View --}}
                            <a href="{{ route('exam-slots.show', $examSlot) }}"
                                title="View Exam Slot"
                                class="inline-flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-primary/30 bg-primary/10 px-4 py-2.5 text-sm font-bold text-primary transition hover:border-primary/50 hover:bg-primary/15 hover:shadow">
                                <i class="bi bi-eye-fill text-base"></i>
                                <span>View</span>
                            </a>

                            {{-- Edit --}}
                            @if ($examSlot->status === 'scheduled')
                                <a href="{{ route('exam-slots.edit', $examSlot) }}"
                                    title="Edit Exam Slot"
                                    class="inline-flex flex-1 cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-primary/30 bg-primary/10 px-4 py-2.5 text-sm font-bold text-primary transition hover:border-primary/50 hover:bg-primary/15 hover:shadow">
                                    <i class="bi bi-pencil-square text-base"></i>
                                    <span>Edit</span>
                                </a>
                            @endif

                            {{-- Start --}}
                            @if ($examSlot->status === 'scheduled' && $examSlot->is_active)
                                <form method="POST"
                                    action="{{ route('exam-slots.start', $examSlot) }}"
                                    data-exam-action="start"
                                    class="flex-1">
                                    @csrf

                                    <button type="submit"
                                        title="Start Exam"
                                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-primary/30 bg-primary px-4 py-2.5 text-sm font-bold text-white transition hover:bg-primary/90 hover:shadow">
                                        <i class="bi bi-play-fill text-base"></i>
                                        <span>Start</span>
                                    </button>
                                </form>
                            @endif

                            {{-- End --}}
                            @if ($examSlot->status === 'start' && $examSlot->is_active)
                                <form method="POST"
                                    action="{{ route('exam-slots.end', $examSlot) }}"
                                    data-exam-action="end"
                                    class="flex-1">
                                    @csrf

                                    <button type="submit"
                                        title="End Exam"
                                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-primary/30 bg-primary px-4 py-2.5 text-sm font-bold text-white transition hover:bg-primary/90 hover:shadow">
                                        <i class="bi bi-stop-fill text-base"></i>
                                        <span>End</span>
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            @if ($examSlot->status === 'scheduled')
                                <form method="POST"
                                    action="{{ route('exam-slots.destroy', $examSlot) }}"
                                    data-delete-form
                                    class="flex-1">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        title="Delete Exam Slot"
                                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-primary/30 bg-primary/10 px-4 py-2.5 text-sm font-bold text-primary transition hover:border-primary/50 hover:bg-primary/15 hover:shadow">
                                        <i class="bi bi-trash3-fill text-base"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                @empty
                    <div class="px-4 py-12 text-center">
                        <div class="mb-3 flex justify-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                <i class="bi bi-calendar-x text-xl text-slate-400"></i>
                            </div>
                        </div>

                        <p class="text-sm font-medium text-slate-600">
                            No exam slots found
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Create your first exam slot to get started.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($examSlots->hasPages())
                <div class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                    <p class="text-xs text-slate-500">
                        Showing
                        <span class="font-semibold text-slate-700">
                            {{ $examSlots->firstItem() }}
                        </span>
                        <span class="px-0.5 text-slate-400">
                            –
                        </span>
                        <span class="font-semibold text-slate-700">
                            {{ $examSlots->lastItem() }}
                        </span>
                        of
                        <span class="font-semibold text-slate-700">
                            {{ $examSlots->total() }}
                        </span>
                        results
                    </p>

                    <div class="overflow-x-auto">
                        {{ $examSlots->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


@endsection

@push('scripts') <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script> <script src="{{ asset('/assets/js/examSlot.js') }}"></script>
@endpush
