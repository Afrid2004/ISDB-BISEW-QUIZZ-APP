@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                {{-- Breadcrumb --}}
                <div class="mb-2 flex items-center gap-2 text-xs text-slate-400">

                    <a href="{{ route('courses.index') }}" class="transition hover:text-primary">
                        Courses
                    </a>

                    <i class="bi bi-chevron-right text-[9px]"></i>

                    <span>View</span>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    {{ $course->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View course information and details.
                </p>

            </div>


            {{-- Back --}}
            <div>

                <a href="{{ route('courses.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg
                           border border-slate-200 bg-white
                           px-4 py-2.5 text-sm font-medium
                           text-slate-600 transition
                           hover:bg-slate-50">

                    <i class="bi bi-arrow-left"></i>

                    Back

                </a>

            </div>

        </div>


        {{-- Main Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200
                    bg-white shadow-sm">


            {{-- Card Header --}}
            <div
                class="flex items-center justify-between
                        border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    {{-- Icon --}}
                    <div
                        class="flex h-10 w-10 items-center justify-center
                                rounded-lg bg-primary/10 text-primary">

                        <i class="bi bi-book text-lg"></i>

                    </div>


                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Course Information
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Details of this course.
                        </p>

                    </div>

                </div>


                {{-- Status --}}
                @if ($course->is_active)
                    <span
                        class="inline-flex items-center gap-1.5
                                 rounded-full bg-emerald-50
                                 px-3 py-1.5 text-xs font-semibold
                                 text-emerald-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Active

                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5
                                 rounded-full bg-amber-50
                                 px-3 py-1.5 text-xs font-semibold
                                 text-amber-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                        Inactive

                    </span>
                @endif

            </div>


            {{-- Information --}}
            <div class="divide-y divide-slate-100">

                {{-- Round Information --}}
                <div class="px-5 py-5 sm:px-6">

                    @if ($course->round)
                        <div class="flex items-center gap-3">

                            {{-- Round Number --}}
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center
                        rounded-lg bg-primary/10 text-sm font-bold text-primary">

                                {{ sprintf('%02d', $course->round->round_number) }}

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-slate-700">
                                    Round {{ $course->round->round_number }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    Round ID: {{ $course->round->id }}
                                </p>

                            </div>

                        </div>
                    @endif

                </div>


                {{-- Course Name --}}
                <div class="px-5 py-5 sm:px-6">

                    <p
                        class="mb-2 text-xs font-semibold uppercase
                              tracking-wide text-slate-400">

                        Course Name

                    </p>

                    <p class="text-sm font-semibold text-slate-700">

                        {{ $course->name }}

                    </p>

                </div>


                {{-- Course Code --}}
                <div class="px-5 py-5 sm:px-6">

                    <p
                        class="mb-2 text-xs font-semibold uppercase
                              tracking-wide text-slate-400">

                        Course Code

                    </p>

                    @if ($course->code)
                        <span
                            class="inline-flex items-center
                                     rounded-md bg-slate-100
                                     px-2.5 py-1 text-sm font-medium
                                     text-slate-600">

                            {{ $course->code }}

                        </span>
                    @else
                        <p class="text-sm italic text-slate-400">

                            No course code available.

                        </p>
                    @endif

                </div>


                {{-- Description --}}
                <div class="px-5 py-5 sm:px-6">

                    <p
                        class="mb-2 text-xs font-semibold uppercase
                              tracking-wide text-slate-400">

                        Description

                    </p>

                    @if ($course->description)
                        <p class="text-sm leading-6 text-slate-600">

                            {{ $course->description }}

                        </p>
                    @else
                        <p class="text-sm italic text-slate-400">

                            No description available.

                        </p>
                    @endif

                </div>


                {{-- Created At --}}
                <div
                    class="flex flex-col gap-2 px-5 py-5
                            sm:flex-row sm:items-center
                            sm:justify-between sm:px-6">

                    <div>

                        <p
                            class="text-xs font-semibold uppercase
                                  tracking-wide text-slate-400">

                            Created At

                        </p>

                    </div>


                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-calendar3 text-primary"></i>

                        @if ($course->created_at)
                            {{ $course->created_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $course->created_at->format('h:i A') }}
                        @else
                            N/A
                        @endif

                    </div>

                </div>


                {{-- Updated At --}}
                <div
                    class="flex flex-col gap-2 px-5 py-5
                            sm:flex-row sm:items-center
                            sm:justify-between sm:px-6">

                    <div>

                        <p
                            class="text-xs font-semibold uppercase
                                  tracking-wide text-slate-400">

                            Last Updated

                        </p>

                    </div>


                    <div class="flex items-center gap-2 text-sm text-slate-600">

                        <i class="bi bi-clock-history text-primary"></i>

                        @if ($course->updated_at)
                            {{ $course->updated_at->format('d M, Y') }}

                            <span class="text-slate-300">•</span>

                            {{ $course->updated_at->format('h:i A') }}
                        @else
                            N/A
                        @endif

                    </div>

                </div>

            </div>


            {{-- Footer Actions --}}
            <div
                class="flex flex-col-reverse gap-3
                        border-t border-slate-100
                        px-5 py-4 sm:flex-row sm:justify-end sm:px-6">


                {{-- Delete --}}
                <form data-item="course" action="{{ route('courses.destroy', $course) }}" method="POST"
                    class="delete-form flex-1">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center
                               gap-2 rounded-lg border border-red-200
                               bg-white px-4 py-2.5 text-sm font-semibold
                               text-red-500 transition
                               hover:bg-red-50 sm:w-auto">

                        <i class="bi bi-trash3"></i>

                        Delete

                    </button>

                </form>


                {{-- Edit --}}
                <a href="{{ route('courses.edit', $course) }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg bg-primary px-4 py-2.5
                           text-sm font-semibold text-white
                           transition hover:bg-primary/90">

                    <i class="bi bi-pencil-square"></i>

                    Edit Course

                </a>

            </div>

        </div>

    </div>
@endsection


@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush
