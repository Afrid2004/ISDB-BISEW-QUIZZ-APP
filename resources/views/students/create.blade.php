@extends('layouts.backend.app')

@section('content') <div class="min-h-screen bg-[#f7f8fc]">


    {{-- Page Header --}}
    <div class="mb-6">

        {{-- Breadcrumb --}}
        <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">
            <a href="{{ route('students.index') }}" class="transition hover:text-primary">
                Students
            </a>
            <i class="bi bi-chevron-right text-[9px]"></i>
            <span>Add Student</span>
        </div>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Add Student
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Add students using CSV import or manually.
                </p>
            </div>

            {{-- Back --}}
            <a href="{{ route('students.index') }}"
                class="inline-flex w-fit items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back to Students
            </a>
        </div>

    </div>

    {{-- Main Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        {{-- Mode Tabs --}}
        <div class="border-b border-slate-100 px-4 py-4 sm:px-6">
            <div class="flex w-full gap-1 rounded-lg bg-slate-100 p-1 sm:w-fit">

                {{-- CSV Tab --}}
                <button type="button" id="csvTab"
                    class="student-tab inline-flex flex-1 items-center justify-center gap-2 rounded-md bg-white px-5 py-2.5 text-sm font-semibold text-primary shadow-sm transition sm:flex-none cursor-pointer">
                    <i class="bi bi-filetype-csv"></i>
                    CSV Import
                </button>

                {{-- Manual Tab --}}
                <button type="button" id="manualTab"
                    class="student-tab inline-flex flex-1 items-center justify-center gap-2 rounded-md px-5 py-2.5 text-sm font-semibold text-slate-500 transition hover:text-slate-700 sm:flex-none cursor-pointer">
                    <i class="bi bi-pencil-square"></i>
                    Manual Add
                </button>

            </div>
        </div>


        {{-- ============================== --}}
        {{-- CSV IMPORT FORM --}}
        {{-- ============================== --}}

        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" id="csvSection"
            class="p-5 sm:p-6 lg:p-8">

            @csrf

            {{-- Validation Error Alerts --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    <div class="mb-1 font-semibold">
                        Upload Validation Error:
                    </div>

                    <ul class="list-inside list-disc space-y-1 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Exception Error Alert --}}
            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    <i class="bi bi-exclamation-octagon-fill mr-1"></i>
                    {{ session('error') }}
                </div>
            @endif


            {{-- Import Failures --}}
            @if (session('failures'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">

                    <div class="flex items-center gap-2 text-sm font-semibold text-red-800">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Some rows contain errors and were skipped:</span>
                    </div>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-xs text-red-700">
                        @foreach (session('failures') as $failure)
                            <li>
                                <strong>Row {{ $failure->row() }}:</strong>
                                {{ implode(', ', $failure->errors()) }}
                            </li>
                        @endforeach
                    </ul>

                </div>
            @endif


            {{-- Success Alert --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4">

                    <div class="flex items-center gap-2 text-sm font-semibold text-emerald-800">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>

                </div>
            @endif


            {{-- Section Header --}}
            <div class="mb-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                        <i class="bi bi-file-earmark-spreadsheet text-lg"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Import Students
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Upload a CSV file to add multiple students at once.
                        </p>
                    </div>

                </div>

            </div>


            {{-- Upload Area --}}
            <div
                class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 px-5 py-10 text-center transition hover:border-primary/30 hover:bg-primary/[0.02] sm:px-8">

                {{-- Icon --}}
                <div
                    class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="bi bi-cloud-arrow-up text-2xl"></i>
                </div>

                <h3 class="text-sm font-semibold text-slate-700">
                    Upload your CSV file
                </h3>

                <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400">
                    Upload a CSV file containing student information such as round, batch,
                    name, email, phone, date of birth and status.
                </p>


                {{-- File Input --}}
                <div class="mt-5 flex items-center justify-center gap-2">

                    <label
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">

                        <i class="bi bi-upload"></i>

                        <span id="studentCsvFileName">
                            Choose CSV File
                        </span>

                        <input type="file"
                            name="file"
                            id="studentCsvFileInput"
                            accept=".csv, .xlsx, .xls"
                            class="hidden"
                            required>

                    </label>

                    <button type="button"
                        id="clearStudentFileBtn"
                        class="hidden rounded-lg border border-slate-200 bg-white p-2.5 text-slate-500 transition hover:bg-slate-50 hover:text-red-500"
                        title="Clear selected file">

                        <i class="bi bi-x-lg"></i>

                    </button>

                </div>


                <p class="mt-3 text-[11px] text-slate-400">
                    Supported format: .csv, .xlsx, .xls
                </p>

            </div>


            {{-- CSV Information Cards --}}
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">

                {{-- Download Template --}}
                <div class="rounded-lg border border-slate-200 bg-white p-4">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                        </div>

                        <div>

                            <h3 class="text-sm font-semibold text-slate-700">
                                Student CSV Template
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-400">
                                Download the sample CSV template before importing your students.
                            </p>

                            <a href="{{ route('students.export-template') }}"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:underline">

                                <i class="bi bi-download"></i>
                                Download Template

                            </a>

                        </div>

                    </div>

                </div>


                {{-- CSV Format Guide --}}
                <div class="rounded-lg border border-slate-200 bg-white p-4">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div>

                            <h3 class="text-sm font-semibold text-slate-700">
                                CSV Format
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-400">
                                Make sure your CSV file follows the required student column structure.
                            </p>

                            <button type="button"
                                id="viewFormatBtn"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:underline">

                                View Format
                                <i class="bi bi-arrow-right"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CSV Action --}}
            <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">

                <button type="submit"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">

                    <i class="bi bi-cloud-upload"></i>
                    Import Students

                </button>

            </div>

        </form>


        {{-- ============================== --}}
        {{-- MANUAL ADD FORM --}}
        {{-- ============================== --}}

       @include('students._form')

    </div>

</div>


@endsection

{{-- Tab Switching --}}
@push('scripts')


<script src="{{ asset('/assets/js/tabSwitiching.js') }}"></script>
<script >
    document.addEventListener("DOMContentLoaded", function () {

    const roundSelect = document.getElementById("round_id");
    const batchSelect = document.getElementById("batch_id");

    if (!roundSelect || !batchSelect) {
        return;
    }

    roundSelect.addEventListener("change", function () {

        const roundId = this.value;

        batchSelect.innerHTML = '<option value="">Loading batches...</option>';
        batchSelect.disabled = true;

        if (!roundId) {
            batchSelect.innerHTML =
                '<option value="">Select Round First</option>';

            return;
        }

        fetch(`/students/batches/${roundId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to load batches");
                }

                return response.json();
            })
            .then(batches => {

                batchSelect.innerHTML =
                    '<option value="">Select Batch</option>';

                if (batches.length === 0) {

                    batchSelect.innerHTML =
                        '<option value="">No Batch Available</option>';

                    batchSelect.disabled = true;

                    return;
                }

                batches.forEach(batch => {

                    const option = document.createElement("option");

                    option.value = batch.id;

                    option.textContent =
                        `${batch.batch_number} - ${batch.name}`;

                    batchSelect.appendChild(option);

                });

                batchSelect.disabled = false;

            })
            .catch(error => {

                console.error(error);

                batchSelect.innerHTML =
                    '<option value="">Failed to load batches</option>';

                batchSelect.disabled = true;

            });

    });

});
</script>


@endpush