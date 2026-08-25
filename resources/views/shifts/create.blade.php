@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap gap-3">

                <div>

                    <h1 class="text-2xl font-bold text-slate-800">
                        Add New Shift
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Create a new shift schedule for your assessment system.
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

        </div>


        {{-- Form Card --}}
        <div class="mx-auto max-w-3xl md:max-w-full">

            <div class="overflow-hidden rounded-xl border border-slate-200
                        bg-white shadow-sm">


                {{-- Card Header --}}
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                    <h2 class="text-base font-semibold text-slate-800">
                        Shift Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Enter the basic information for this shift.
                    </p>

                </div>


                {{-- Form --}}
                <form action="{{ route('shifts.store') }}" method="POST" class="px-5 py-6 sm:px-6">

                    @csrf


                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div
                            class="mb-6 rounded-lg border border-red-200
                                    bg-red-50 px-4 py-3">

                            <div class="flex gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86
                                                     1.82 18a2 2 0 0 0 1.71 3h16.94
                                                     a2 2 0 0 0 1.71-3L13.71 3.86
                                                     a2 2 0 0 0-3.42 0Z" />

                                </svg>


                                <div>

                                    <p class="text-sm font-semibold text-red-700">
                                        Please fix the following errors:
                                    </p>

                                    <ul
                                        class="mt-1 list-disc pl-5 text-xs
                                               text-red-600">

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
                        <div
                            class="mb-6 rounded-lg border border-emerald-200
                                    bg-emerald-50 px-4 py-3 text-sm
                                    text-emerald-700">

                            {{ session('success') }}

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


                            <input type="text" name="name" id="name" maxlength="50"
                                value="{{ old('name') }}" placeholder="e.g. Morning Shift"
                                class="w-full rounded-lg border
                                       border-slate-200 bg-white px-4 py-2.5
                                       text-sm text-slate-700
                                       placeholder:text-slate-400
                                       outline-none transition
                                       focus:border-primary
                                       focus:ring-2
                                       focus:ring-primary/20

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


                            <input type="text" name="code" id="code" maxlength="20"
                                value="{{ old('code') }}" placeholder="e.g. SH-M-01"
                                class="w-full rounded-lg border
                                       border-slate-200 bg-white px-4 py-2.5
                                       text-sm text-slate-700
                                       placeholder:text-slate-400
                                       outline-none transition
                                       focus:border-primary
                                       focus:ring-2
                                       focus:ring-primary/20

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


                                <input type="time" name="start_time" id="start_time"
                                    value="{{ old('start_time') }}"
                                    class="w-full rounded-lg border
                                           border-slate-200 bg-white px-4 py-2.5
                                           text-sm text-slate-700
                                           outline-none transition
                                           focus:border-primary
                                           focus:ring-2
                                           focus:ring-primary/20

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


                                <input type="time" name="end_time" id="end_time"
                                    value="{{ old('end_time') }}"
                                    class="w-full rounded-lg border
                                           border-slate-200 bg-white px-4 py-2.5
                                           text-sm text-slate-700
                                           outline-none transition
                                           focus:border-primary
                                           focus:ring-2
                                           focus:ring-primary/20

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


                        {{-- Active Status --}}
                        <div>

                            <label
                                class="mb-2 block text-sm font-semibold
                                          text-slate-700">

                                Status

                            </label>


                            <label
                                class="flex cursor-pointer items-center
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

                                    <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                                        {{ old('is_active', true) ? 'checked' : '' }}>


                                    {{-- Toggle Background --}}
                                    <div
                                        class="h-6 w-11 rounded-full
                                                bg-slate-300
                                                transition
                                                peer-checked:bg-primary
                                                peer-focus:ring-2
                                                peer-focus:ring-primary/30">
                                    </div>


                                    {{-- Toggle Circle --}}
                                    <div
                                        class="absolute left-1 top-1
                                                h-4 w-4 rounded-full bg-white
                                                shadow-sm transition
                                                peer-checked:translate-x-5">
                                    </div>

                                </div>

                            </label>

                        </div>

                    </div>


                    {{-- Form Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3
                                border-t border-slate-100 pt-5
                                sm:flex-row sm:justify-end">


                        {{-- Cancel --}}
                        <a href="{{ route('shifts.index') }}"
                            class="inline-flex items-center justify-center
                                  rounded-lg border border-slate-200
                                  bg-white px-5 py-2.5 text-sm font-semibold
                                  text-slate-600 transition
                                  hover:bg-slate-50">

                            Cancel

                        </a>


                        {{-- Create --}}
                        <button type="submit"
                            class="inline-flex items-center justify-center
                                   gap-2 rounded-lg bg-primary
                                   px-5 py-2.5 text-sm font-semibold
                                   text-white shadow-sm transition
                                   hover:bg-primary/90
                                   focus:outline-none focus:ring-2
                                   focus:ring-primary/50
                                   focus:ring-offset-2">

                            <i class="bi bi-check-lg text-base"></i>

                            Create Shift

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection