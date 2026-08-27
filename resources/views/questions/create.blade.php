@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6">

            {{-- Breadcrumb --}}
            <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                <a href="{{ route('questions.index') }}" class="transition hover:text-primary">
                    Questions
                </a>

                <i class="bi bi-chevron-right text-[9px]"></i>

                <span>Add Question</span>

            </div>


            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <h1 class="text-2xl font-bold text-slate-800">
                        Add Question
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Add questions to your quiz using CSV import or manually.
                    </p>

                </div>


                {{-- Back --}}
                <a href="{{ route('questions.index') }}"
                    class="inline-flex w-fit items-center gap-2 rounded-lg
                           border border-slate-200 bg-white px-4 py-2.5
                           text-sm font-semibold text-slate-600
                           transition hover:bg-slate-50">

                    <i class="bi bi-arrow-left"></i>

                    Back to Questions

                </a>

            </div>

        </div>


        {{-- Main Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200
                    bg-white">


            {{-- Mode Tabs --}}
            <div class="border-b border-slate-100 px-4 py-4 sm:px-6">

                <div class="flex w-full gap-1 rounded-lg bg-slate-100 p-1 sm:w-fit">

                    {{-- CSV Tab --}}
                    <button type="button" id="csvTab"
                        class="question-tab inline-flex flex-1 items-center
                               justify-center gap-2 rounded-md
                               bg-white px-5 py-2.5 text-sm font-semibold
                               text-primary shadow-sm transition
                               sm:flex-none cursor-pointer">

                        <i class="bi bi-filetype-csv"></i>

                        CSV Import

                    </button>


                    {{-- Manual Tab --}}
                    <button type="button" id="manualTab"
                        class="question-tab inline-flex flex-1 items-center
                               justify-center gap-2 rounded-md
                               px-5 py-2.5 text-sm font-semibold
                               text-slate-500 transition
                               hover:text-slate-700
                               sm:flex-none cursor-pointer">

                        <i class="bi bi-pencil-square"></i>

                        Manual Add

                    </button>

                </div>

            </div>


            {{-- ============================== --}}
            {{-- CSV IMPORT --}}
            {{-- ============================== --}}

            <div id="csvSection" class="p-5 sm:p-6 lg:p-8">

                {{-- Section Header --}}
                <div class="mb-6">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                                    rounded-lg bg-primary/10 text-primary">

                            <i class="bi bi-file-earmark-spreadsheet text-lg"></i>

                        </div>

                        <div>

                            <h2 class="text-base font-semibold text-slate-800">
                                Import Questions
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-400">
                                Upload a CSV file to add multiple questions at once.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Upload Area --}}
                <div
                    class="rounded-xl border-2 border-dashed border-slate-200
                           bg-slate-50/50 px-5 py-10 text-center
                           transition hover:border-primary/30
                           hover:bg-primary/[0.02] sm:px-8">


                    {{-- Icon --}}
                    <div
                        class="mx-auto mb-4 flex h-14 w-14 items-center
                                justify-center rounded-xl bg-primary/10
                                text-primary">

                        <i class="bi bi-cloud-arrow-up text-2xl"></i>

                    </div>


                    <h3 class="text-sm font-semibold text-slate-700">
                        Upload your CSV file
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400">
                        Upload a CSV file containing your questions, options,
                        answers and related information.
                    </p>


                    {{-- File Input --}}
                    <div class="mt-5">

                        <label
                            class="inline-flex cursor-pointer items-center gap-2
                                   rounded-lg bg-primary px-5 py-2.5
                                   text-sm font-semibold text-white
                                   shadow-sm transition
                                   hover:bg-primary/90">

                            <i class="bi bi-upload"></i>

                            Choose CSV File

                            <input type="file" name="csv_file" accept=".csv" class="hidden">

                        </label>

                    </div>


                    <p class="mt-3 text-[11px] text-slate-400">
                        Supported format: .csv
                    </p>

                </div>


                {{-- CSV Information --}}
                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">


                    {{-- Template --}}
                    <div class="rounded-lg border border-slate-200
                                bg-white p-4">

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-primary/10 text-primary">

                                <i class="bi bi-file-earmark-arrow-down"></i>

                            </div>

                            <div>

                                <h3 class="text-sm font-semibold text-slate-700">
                                    CSV Template
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-slate-400">
                                    Download the sample CSV template before
                                    importing your questions.
                                </p>

                                <button type="button"
                                    class="mt-3 inline-flex items-center gap-1.5
                                           text-xs font-semibold text-primary
                                           hover:underline">

                                    <i class="bi bi-download"></i>

                                    Download Template

                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- CSV Format --}}
                    <div class="rounded-lg border border-slate-200
                                bg-white p-4">

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-slate-100 text-slate-500">

                                <i class="bi bi-info-circle"></i>

                            </div>

                            <div>

                                <h3 class="text-sm font-semibold text-slate-700">
                                    CSV Format
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-slate-400">
                                    Make sure your CSV file follows the required
                                    column structure.
                                </p>

                                <button type="button"
                                    class="mt-3 inline-flex items-center gap-1.5
                                           text-xs font-semibold text-primary
                                           hover:underline">

                                    View Format

                                    <i class="bi bi-arrow-right"></i>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- CSV Action --}}
                <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">

                    <button type="button"
                        class="inline-flex items-center gap-2 rounded-lg
                               bg-primary px-5 py-2.5 text-sm font-semibold
                               text-white shadow-sm transition
                               hover:bg-primary/90 cursor-pointer">

                        <i class="bi bi-cloud-upload"></i>

                        Import Questions

                    </button>

                </div>

            </div>


            {{-- ============================== --}}
            {{-- MANUAL ADD --}}
            {{-- ============================== --}}

            <div id="manualSection" class="hidden p-5 sm:p-6 lg:p-8">

                {{-- Section Header --}}
                <div class="mb-6">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                                    rounded-lg bg-primary/10 text-primary">

                            <i class="bi bi-pencil-square text-lg"></i>

                        </div>

                        <div>

                            <h2 class="text-base font-semibold text-slate-800">
                                Add Question Manually
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-400">
                                Create a question by entering the information below.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Form --}}
                <form action="#" method="POST">

                    @csrf


                    @include('questions._form')


                    {{-- Form Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3 border-t
                               border-slate-100 pt-5 sm:flex-row
                               sm:justify-end">

                        <a href="{{ route('questions.index') }}"
                            class="inline-flex items-center justify-center
                                   gap-2 rounded-lg border border-slate-200
                                   bg-white px-5 py-2.5 text-sm font-semibold
                                   text-slate-600 transition hover:bg-slate-50">

                            <i class="bi bi-x-lg"></i>

                            Cancel

                        </a>


                        <button type="submit"
                            class="inline-flex items-center justify-center
                                   gap-2 rounded-lg bg-primary px-5 py-2.5
                                   text-sm font-semibold text-white
                                   shadow-sm transition
                                   hover:bg-primary/90
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-primary/20 cursor-pointer">

                            <i class="bi bi-check-lg"></i>

                            Create Question

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection


{{-- Tab Switching --}}
@push('scripts')
    <script src="{{ asset('/assets/js/tabSwitiching.js') }}"></script>
    <script src="{{ asset('/assets/js/questionType.js') }}"></script>
@endpush
