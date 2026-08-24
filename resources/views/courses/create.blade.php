@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between gap-3">

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Add New Course
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Create a new course for your quiz assessment system.
                    </p>
                </div>

                {{-- Show Data --}}
                <div>
                    <button type="button"
                        class="inline-flex items-center justify-center
                               gap-2 rounded-lg bg-primary
                               px-5 py-2.5 text-sm font-semibold
                               text-white transition
                               hover:bg-primary/90
                               focus:outline-none focus:ring-2
                               focus:ring-primary/50
                               focus:ring-offset-2">

                        <i class="bi bi-eye text-base"></i>
                        Show Data

                    </button>
                </div>

            </div>
        </div>


        {{-- Form Card --}}
        <div class="mx-auto max-w-3xl md:max-w-full">

            <div class="overflow-hidden rounded-xl border border-slate-200
                        bg-white">

                {{-- Card Header --}}
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                    <h2 class="text-base font-semibold text-slate-800">
                        Course Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Enter the basic information for this course.
                    </p>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mt-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
                            <div class="flex gap-3">
                                <i class="bi bi-exclamation-triangle-fill mt-0.5 shrink-0 text-base text-red-500"></i>

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
                        <div class="mt-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-check-circle-fill text-base text-emerald-500"></i>

                                <p class="text-sm font-medium text-emerald-700">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    @endif

                </div>


                {{-- Form --}}
                <form action="{{ route('courses.store') }}" class="px-5 py-6 sm:px-6" method="POST">
                    @csrf

                    @include('courses._form')

                    {{-- Form Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3
                               border-t border-slate-100 pt-5
                               sm:flex-row sm:justify-end">

                        {{-- Cancel --}}
                        <button type="button"
                            class="inline-flex items-center justify-center
                                   rounded-lg border border-slate-200
                                   bg-white px-5 py-2.5 text-sm font-semibold
                                   text-slate-600 transition
                                   hover:bg-slate-50">

                            Cancel

                        </button>


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

                            Create Course

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
