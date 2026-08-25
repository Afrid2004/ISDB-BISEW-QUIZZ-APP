@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between gap-3">

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Edit Course
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Update the information of this course.
                    </p>
                </div>

                {{-- Show Data --}}
                <div>
                    <a href="{{route('courses.index')}}"
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

                    </a>
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
                        Update the basic information for this course.
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

                </div>


                {{-- Form --}}
                <form data-item="course" action="{{ route('courses.update', $course) }}" class="px-5 py-6 sm:px-6" method="POST">
                    @csrf
                    @method('PUT')
                    @include('courses._form')

                    {{-- Form Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3
                               border-t border-slate-100 pt-5
                               sm:flex-row sm:justify-end">

                        {{-- Cancel --}}
                        <a href="{{route('courses.index')}}"
                            class="inline-flex items-center justify-center
                                   rounded-lg border border-slate-200
                                   bg-white px-5 py-2.5 text-sm font-semibold
                                   text-slate-600 transition
                                   hover:bg-slate-50 cursor-pointer">

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
                                   focus:ring-primary/50
                                   focus:ring-offset-2  cursor-pointer">

                            <i class="bi bi-check-lg text-base"></i>

                            Update Course

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
