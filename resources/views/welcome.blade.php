@extends('layouts.backend.app')

@section('title', 'Dashboard - IsDB-BISEW')

@section('page-title', 'Dashboard')

@section('content')

    {{-- Page Heading --}}
    <div class="mb-6">

        <p class="text-xs font-semibold uppercase tracking-wider text-primary">
            Overview
        </p>

        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-800">
            Good morning, Admin
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            Here is what is happening across your academic programs.
        </p>

    </div>


    {{-- Statistics --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        @php

            $stats = [
                [
                    'title' => 'Total Students',
                    'value' => '1,248',
                    'description' => 'Across 8 batches',
                    'icon' => 'bi-people',
                ],

                [
                    'title' => 'Active Students',
                    'value' => '1,106',
                    'description' => '88.6% of students',
                    'icon' => 'bi-person-check',
                ],

                [
                    'title' => 'Total Subjects',
                    'value' => '18',
                    'description' => 'This academic year',
                    'icon' => 'bi-book',
                ],

                [
                    'title' => 'Total Modules',
                    'value' => '64',
                    'description' => 'Across all subjects',
                    'icon' => 'bi-collection',
                ],

                [
                    'title' => 'Total Chapters',
                    'value' => '212',
                    'description' => 'Content structure',
                    'icon' => 'bi-bookmark',
                ],

                [
                    'title' => 'Total Questions',
                    'value' => '3,842',
                    'description' => 'Question bank',
                    'icon' => 'bi-question-circle',
                ],

                [
                    'title' => 'Active Quizzes',
                    'value' => '12',
                    'description' => 'Currently published',
                    'icon' => 'bi-journal-check',
                ],

                [
                    'title' => 'Completed Quizzes',
                    'value' => '486',
                    'description' => 'This semester',
                    'icon' => 'bi-check-circle',
                ],
            ];

        @endphp


        @foreach ($stats as $stat)
            <div
                class="
                    group
                    rounded-xl
                    border border-slate-200
                    bg-white
                    p-5
                    shadow-sm
                    transition-all
                    duration-200

                    hover:-translate-y-0.5
                    hover:border-primary/30
                    hover:shadow-md
                ">

                {{-- Icon --}}
                <div class="flex items-center justify-between">

                    <div
                        class="
                            flex h-10 w-10
                            items-center justify-center
                            rounded-lg
                            bg-primary/10
                            text-primary
                            transition
                            group-hover:bg-primary
                            group-hover:text-white
                        ">
                        <i class="bi {{ $stat['icon'] }} text-lg"></i>
                    </div>

                </div>


                {{-- Content --}}
                <div class="mt-4">

                    <p class="text-xs font-medium text-slate-400">
                        {{ $stat['title'] }}
                    </p>

                    <h3
                        class="
                            mt-1
                            text-2xl
                            font-bold
                            text-slate-800
                        ">
                        {{ $stat['value'] }}
                    </h3>

                    <p class="mt-1 text-[11px] text-slate-400">
                        {{ $stat['description'] }}
                    </p>

                </div>

            </div>
        @endforeach

    </div>


    {{-- Recent Activity --}}
    <div
        class="
            mt-6
            overflow-hidden
            rounded-xl
            border border-slate-200
            bg-white
            shadow-sm
        ">

        {{-- Header --}}
        <div
            class="
                flex flex-col gap-3
                border-b border-slate-100
                px-5 py-4

                sm:flex-row
                sm:items-center
                sm:justify-between
            ">

            <div>

                <h3 class="text-sm font-semibold text-slate-800">
                    Recent Activity
                </h3>

                <p class="mt-0.5 text-xs text-slate-400">
                    Latest activities across the platform
                </p>

            </div>


            <span
                class="
                    w-fit
                    rounded-full
                    bg-primary/10
                    px-3 py-1
                    text-[10px]
                    font-semibold
                    text-primary
                ">
                Last 7 days
            </span>

        </div>


        {{-- Activities --}}
        <div class="divide-y divide-slate-100">

            {{-- Activity 1 --}}
            <div
                class="
                    flex items-start gap-3
                    px-5 py-4
                    transition
                    hover:bg-primary/5
                ">

                <div
                    class="
                        mt-0.5
                        flex h-8 w-8 shrink-0
                        items-center justify-center
                        rounded-full
                        bg-primary/10
                        text-primary
                    ">
                    <i class="bi bi-check2-circle text-sm"></i>
                </div>

                <p class="text-xs leading-5 text-slate-600">

                    Priya Shah completed Data Structures

                    <span class="text-slate-400">
                        — 12 minutes ago
                    </span>

                </p>

            </div>


            {{-- Activity 2 --}}
            <div
                class="
                    flex items-start gap-3
                    px-5 py-4
                    transition
                    hover:bg-primary/5
                ">

                <div
                    class="
                        mt-0.5
                        flex h-8 w-8 shrink-0
                        items-center justify-center
                        rounded-full
                        bg-primary/10
                        text-primary
                    ">
                    <i class="bi bi-journal-plus text-sm"></i>
                </div>

                <p class="text-xs leading-5 text-slate-600">

                    A new quiz, Relational Databases, was published

                    <span class="text-slate-400">
                        — 2 hours ago
                    </span>

                </p>

            </div>


            {{-- Activity 3 --}}
            <div
                class="
                    flex items-start gap-3
                    px-5 py-4
                    transition
                    hover:bg-primary/5
                ">

                <div
                    class="
                        mt-0.5
                        flex h-8 w-8 shrink-0
                        items-center justify-center
                        rounded-full
                        bg-primary/10
                        text-primary
                    ">
                    <i class="bi bi-person-plus text-sm"></i>
                </div>

                <p class="text-xs leading-5 text-slate-600">

                    Nikhil Verma joined Batch BCA-24

                    <span class="text-slate-400">
                        — yesterday
                    </span>

                </p>

            </div>


            {{-- Activity 4 --}}
            <div
                class="
                    flex items-start gap-3
                    px-5 py-4
                    transition
                    hover:bg-primary/5
                ">

                <div
                    class="
                        mt-0.5
                        flex h-8 w-8 shrink-0
                        items-center justify-center
                        rounded-full
                        bg-primary/10
                        text-primary
                    ">
                    <i class="bi bi-file-earmark-arrow-up text-sm"></i>
                </div>

                <p class="text-xs leading-5 text-slate-600">

                    48 questions imported from
                    algorithms_midterm.csv

                    <span class="text-slate-400">
                        — yesterday
                    </span>

                </p>

            </div>

        </div>

    </div>

@endsection
