@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between gap-3">

                <div>

                    <h1 class="text-2xl font-bold text-slate-800">
                        Add New Training Center
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Create a new training center record.
                    </p>

                </div>


                {{-- Show Data / Back Button --}}
                <div>

                    <a href="{{ route('training-centers.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">

                        <i class="bi bi-eye text-base"></i>

                        Show Data

                    </a>

                </div>

            </div>

        </div>


        {{-- Form Card --}}
        <div class="mx-auto max-w-3xl md:max-w-full">

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">


                {{-- Card Header --}}
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                    <h2 class="text-base font-semibold text-slate-800">
                        Training Center Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Enter the basic information for this training center.
                    </p>

                </div>


                {{-- Form --}}
                <form action="{{ route('training-centers.store') }}"
                    method="POST"
                    class="px-5 py-6 sm:px-6">

                    @csrf


                    {{-- Validation Errors --}}
                    @if ($errors->any())

                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">

                            <div class="flex gap-3">

                                <div>

                                    <p class="text-sm font-semibold text-red-700">
                                        Please fix the following errors:
                                    </p>

                                    <ul class="mt-1 list-disc pl-5 text-xs text-red-600">

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

                        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">

                            {{ session('success') }}

                        </div>

                    @endif


                    <div class="space-y-6">


                        {{-- Name --}}
                        <div>

                            <label for="name"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Center Name

                                <span class="text-red-500">*</span>

                            </label>


                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                maxlength="150"
                                placeholder="e.g. Dhaka IT Training Center"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('name') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                            >


                            @error('name')

                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Code --}}
                        <div>

                            <label for="code"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Center Code

                                <span class="text-red-500">*</span>

                            </label>


                            <input
                                type="text"
                                name="code"
                                id="code"
                                value="{{ old('code') }}"
                                maxlength="50"
                                placeholder="e.g. TC-DHK-001"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('code') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                            >


                            @error('code')

                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror


                            <p class="mt-1.5 text-xs text-slate-400">
                                Enter a unique code for this training center.
                            </p>

                        </div>


                        {{-- Location --}}
                        <div>

                            <label for="location"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Location

                                <span class="font-normal text-slate-400">
                                    (Optional)
                                </span>

                            </label>


                            <textarea
                                name="location"
                                id="location"
                                rows="4"
                                placeholder="Enter training center address or location..."
                                class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('location') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                            >{{ old('location') }}</textarea>


                            @error('location')

                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Active Status --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Status
                            </label>


                            <label class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3 transition hover:bg-slate-50">

                                <div>

                                    <p class="text-sm font-medium text-slate-700">
                                        Active Training Center
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        Enable this training center for active operations.
                                    </p>

                                </div>


                                {{-- Toggle --}}
                                <div class="relative">

                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        class="peer sr-only"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                    >


                                    <div class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/30">
                                    </div>


                                    <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                                    </div>

                                </div>

                            </label>

                        </div>

                    </div>


                    {{-- Form Actions --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">


                        {{-- Cancel --}}
                        <a href="{{ route('training-centers.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

                            Cancel

                        </a>


                        {{-- Create --}}
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2"
                        >

                            <i class="bi bi-check-lg text-base"></i>

                            Create Training Center

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

@endsection