@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Add New Shift
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Create a new shift schedule for your assessment system.
                </p>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('shifts.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-primary/30 hover:bg-primary/10 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/20">

                <i class="bi bi-arrow-left text-sm"></i>
                Back to Shifts

            </a>

        </div>

        {{-- Form Card --}}
        <div class="mx-auto max-w-3xl md:max-w-full">

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                {{-- Card Header --}}
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                    <h2 class="text-base font-semibold text-slate-800">
                        Shift Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Enter the basic information and schedule for this shift.
                    </p>

                    {{-- Universal Alerts --}}
                    <x-_alerts />

                </div>

                {{-- Form --}}
                <form action="{{ route('shifts.store') }}" method="POST" class="px-5 py-6 sm:px-6">

                    @csrf

                    @include('shifts._form')

                    {{-- Form Actions --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

                        {{-- Cancel --}}
                        <a href="{{ route('shifts.index') }}"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200">

                            Cancel

                        </a>

                        {{-- Create --}}
                        <button type="submit"
                            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2">

                            <i class="bi bi-check-lg text-base"></i>
                            Create Shift

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
