
@extends('layouts.backend.app')

@section('content')

<div class="min-h-screen bg-[#f7f8fc]">
    <div class="mb-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Edit Exam Slot
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Update the exam slot information and schedule.
                </p>
            </div>

            <a href="{{ route('exam-slots.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white">
                <i class="bi bi-eye"></i>
                Show Data
            </a>
        </div>
    </div>

    <div class="mx-auto max-w-3xl md:max-w-full">
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                <h2 class="text-base font-semibold text-slate-800">
                    Exam Slot Information
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Update batch, exam, exam set and schedule.
                </p>

                <x-_alerts />
            </div>

            <form action="{{ route('exam-slots.update', $examSlot->id) }}"
                method="POST"
                class="px-5 py-6 sm:px-6">

                @csrf
                @method('PUT')

                @include('exam-slots._form')

                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('exam-slots.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                        <i class="bi bi-check-lg"></i>
                        Update Exam Slot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/examSlot.js') }}"></script>
@endpush

