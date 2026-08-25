@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('shifts.index') }}"
                        class="transition hover:text-primary">
                        Shifts
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>Edit Shift</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    Edit Shift
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Update the information of {{ $shift->name }}.
                </p>

            </div>


             {{-- Show Data / Back Button --}}
                <div>

                    <a href="{{ route('shifts.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">

                        <i class="bi bi-eye text-base"></i>

                        Show Data

                    </a>

                </div>

        </div>


        {{-- Form Card --}}
        <div class="overflow-hidden rounded-xl border
                    border-slate-200 bg-white shadow-sm">


            {{-- Card Header --}}
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center
                                rounded-lg bg-primary/10 text-primary">

                        <i class="bi bi-pencil-square text-lg"></i>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Shift Information
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Update the basic information for this shift.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Form --}}
            <form action="{{ route('shifts.update', $shift->id) }}"
                method="POST"
                class="px-5 py-6 sm:px-6">

                @csrf
                @method('PUT')


                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="mb-6 rounded-lg border border-red-200
                                bg-red-50 px-4 py-3">

                        <div class="flex gap-3">

                            <i class="bi bi-exclamation-triangle-fill
                                      mt-0.5 shrink-0 text-red-500"></i>

                            <div>

                                <p class="text-sm font-semibold text-red-700">
                                    Please fix the following errors:
                                </p>

                                <ul class="mt-1 list-disc pl-5
                                           text-xs text-red-600">

                                    @foreach ($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- Success Message --}}
                @if (session('success'))

                    <div class="mb-6 rounded-lg border border-emerald-200
                                bg-emerald-50 px-4 py-3 text-sm
                                text-emerald-700">

                        <div class="flex items-center gap-2">

                            <i class="bi bi-check-circle-fill"></i>

                            {{ session('success') }}

                        </div>

                    </div>

                @endif


                <div class="space-y-6">


                    {{-- Name --}}
                    <div>

                        <label for="name"
                            class="mb-2 block text-sm font-semibold
                                   text-slate-700">

                            Shift Name

                            <span class="text-red-500">*</span>

                        </label>


                        <input
                            type="text"
                            name="name"
                            id="name"
                            maxlength="50"
                            value="{{ old('name', $shift->name) }}"
                            placeholder="e.g. Morning Shift"
                            class="w-full rounded-lg border
                                   border-slate-200 bg-white px-4 py-2.5
                                   text-sm text-slate-700
                                   placeholder:text-slate-400
                                   outline-none transition
                                   focus:border-primary
                                   focus:ring-2 focus:ring-primary/10
                                   @error('name')
                                       border-red-400
                                       focus:border-red-500
                                       focus:ring-red-100
                                   @enderror">


                        @error('name')

                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-1.5 text-xs text-slate-400">
                            Enter a descriptive name for this shift.
                        </p>

                    </div>


                    {{-- Code --}}
                    <div>

                        <label for="code"
                            class="mb-2 block text-sm font-semibold
                                   text-slate-700">

                            Shift Code

                            <span class="text-red-500">*</span>

                        </label>


                        <input
                            type="text"
                            name="code"
                            id="code"
                            maxlength="20"
                            value="{{ old('code', $shift->code) }}"
                            placeholder="e.g. SH-M-01"
                            class="w-full rounded-lg border
                                   border-slate-200 bg-white px-4 py-2.5
                                   text-sm text-slate-700
                                   placeholder:text-slate-400
                                   outline-none transition
                                   focus:border-primary
                                   focus:ring-2 focus:ring-primary/10
                                   @error('code')
                                       border-red-400
                                       focus:border-red-500
                                       focus:ring-red-100
                                   @enderror">


                        @error('code')

                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-1.5 text-xs text-slate-400">
                            Enter a unique code for this shift (max 20 characters).
                        </p>

                    </div>


                    {{-- Time Range --}}
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- Start Time --}}
                        <div>

                            <label for="start_time"
                                class="mb-2 block text-sm font-semibold
                                          text-slate-700">

                                Start Time

                                <span class="font-normal text-slate-400">
                                    (Optional)
                                </span>

                            </label>


                            <input
                                type="time"
                                name="start_time"
                                id="start_time"
                                value="{{ old('start_time', $shift->start_time) }}"
                                class="w-full rounded-lg border
                                       border-slate-200 bg-white px-4 py-2.5
                                       text-sm text-slate-700
                                       outline-none transition
                                       focus:border-primary
                                       focus:ring-2 focus:ring-primary/10
                                       @error('start_time')
                                           border-red-400
                                           focus:border-red-500
                                           focus:ring-red-100
                                       @enderror">


                            @error('start_time')

                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- End Time --}}
                        <div>

                            <label for="end_time"
                                class="mb-2 block text-sm font-semibold
                                          text-slate-700">

                                End Time

                                <span class="font-normal text-slate-400">
                                    (Optional)
                                </span>

                            </label>


                            <input
                                type="time"
                                name="end_time"
                                id="end_time"
                                value="{{ old('end_time', $shift->end_time) }}"
                                class="w-full rounded-lg border
                                       border-slate-200 bg-white px-4 py-2.5
                                       text-sm text-slate-700
                                       outline-none transition
                                       focus:border-primary
                                       focus:ring-2 focus:ring-primary/10
                                       @error('end_time')
                                           border-red-400
                                           focus:border-red-500
                                           focus:ring-red-100
                                       @enderror">


                            @error('end_time')

                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    {{-- Status --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold
                                      text-slate-700">

                            Status

                        </label>


                        <label class="flex cursor-pointer items-center
                                      justify-between rounded-lg border
                                      border-slate-200 bg-slate-50/50
                                      px-4 py-3 transition
                                      hover:bg-slate-50">

                            <div>

                                <p class="text-sm font-medium text-slate-700">
                                    Active Shift
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    Allow this shift to be used in the system.
                                </p>

                            </div>


                            {{-- Toggle --}}
                            <div class="relative">

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    class="peer sr-only"
                                    {{ old('is_active', $shift->is_active) ? 'checked' : '' }}>


                                <div class="h-6 w-11 rounded-full
                                            bg-slate-300 transition
                                            peer-checked:bg-primary
                                            peer-focus:ring-2
                                            peer-focus:ring-primary/20">
                                </div>


                                <div class="absolute left-1 top-1
                                            h-4 w-4 rounded-full bg-white
                                            shadow-sm transition
                                            peer-checked:translate-x-5">
                                </div>

                            </div>

                        </label>

                    </div>

                </div>


                {{-- Form Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3
                            border-t border-slate-100 pt-5
                            sm:flex-row sm:justify-between">

                    <div class="flex flex-col-reverse gap-3 sm:flex-row">


                        {{-- Cancel --}}
                        <a href="{{ route('shifts.index') }}"
                            class="inline-flex items-center justify-center
                                  gap-2 rounded-lg border border-slate-200
                                  bg-white px-5 py-2.5 text-sm font-semibold
                                  text-slate-600 transition
                                  hover:bg-slate-50">

                            <i class="bi bi-x-lg"></i>

                            Cancel

                        </a>


                        {{-- Update --}}
                        <button type="submit"
                            class="inline-flex items-center justify-center
                                   gap-2 rounded-lg bg-primary
                                   px-5 py-2.5 text-sm font-semibold
                                   text-white shadow-sm transition
                                   hover:bg-primary/90
                                   focus:outline-none focus:ring-2
                                   focus:ring-primary/20">

                            <i class="bi bi-check-lg"></i>

                            Update Shift

                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- Delete Form --}}
        <form id="delete-shift-form"
            action="{{ route('shifts.destroy', $shift->id) }}"
            method="POST"
            class="hidden">

            @csrf
            @method('DELETE')

        </form>

    </div>

@endsection