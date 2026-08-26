@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('rounds.index') }}"
                        class="transition hover:text-primary">
                        Rounds
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>Edit Round</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    Edit Round
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Update the information of Round {{ $round->round_number }}.
                </p>

            </div>


            {{-- View Button --}}
            <a href="{{ route('rounds.show', $round->id) }}"
                class="inline-flex items-center justify-center gap-2
                       rounded-lg border border-slate-200
                       bg-white px-4 py-2.5 text-sm font-semibold
                       text-slate-600 transition
                       hover:bg-slate-50">

                <i class="bi bi-eye"></i>

                View Round

            </a>

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
                            Round Information
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Update the basic information for this round.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Form --}}
            <form action="{{ route('rounds.update', $round->id) }}"
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


                    {{-- Round Number --}}
                    <div>

                        <label for="round_number"
                            class="mb-2 block text-sm font-semibold
                                   text-slate-700">

                            Round Number

                            <span class="text-red-500">*</span>

                        </label>


                        <input
                            type="number"
                            name="round_number"
                            id="round_number"
                            min="1"
                            value="{{ old('round_number', $round->round_number) }}"
                            placeholder="e.g. 1"
                            class="w-full rounded-lg border
                                   border-slate-200 bg-white px-4 py-2.5
                                   text-sm text-slate-700
                                   placeholder:text-slate-400
                                   outline-none transition
                                   focus:border-primary
                                   focus:ring-2 focus:ring-primary/10
                                   @error('round_number')
                                       border-red-400
                                       focus:border-red-500
                                       focus:ring-red-100
                                   @enderror">


                        @error('round_number')

                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-1.5 text-xs text-slate-400">
                            Enter a unique number for this round.
                        </p>

                    </div>


                    {{-- Description --}}
                    <div>

                        <label for="description"
                            class="mb-2 block text-sm font-semibold
                                   text-slate-700">

                            Description

                            <span class="font-normal text-slate-400">
                                (Optional)
                            </span>

                        </label>


                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            placeholder="Enter a short description about this round..."
                            class="w-full resize-none rounded-lg border
                                   border-slate-200 bg-white px-4 py-3
                                   text-sm text-slate-700
                                   placeholder:text-slate-400
                                   outline-none transition
                                   focus:border-primary
                                   focus:ring-2 focus:ring-primary/10
                                   @error('description')
                                       border-red-400
                                       focus:border-red-500
                                       focus:ring-red-100
                                   @enderror">{{ old('description', $round->description) }}</textarea>


                        @error('description')

                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

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
                                    Active Round
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    Allow this round to be used in the quiz.
                                </p>

                            </div>


                            {{-- Toggle --}}
                            <div class="relative">

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    class="peer sr-only"
                                    {{ old('is_active', $round->is_active) ? 'checked' : '' }}>


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
                               sm:flex-row sm:justify-end">

                    <div class="flex flex-col-reverse gap-3 sm:flex-row">


                        {{-- Cancel --}}
                        <a href="{{ route('rounds.index') }}"
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
                                   focus:ring-primary/20 cursor-pointer">

                            <i class="bi bi-check-lg"></i>

                            Update Round

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection