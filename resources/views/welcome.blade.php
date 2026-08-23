@extends('layouts.backend.app')

@section('title', 'Dashboard - Quizly')

@section('page-title', 'Dashboard')

@section('content')

    {{-- Page Heading --}}
    <div class="mb-6">

        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-500">
            Overview
        </p>

        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-800">
            Good morning, Amina
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
                ],
                [
                    'title' => 'Active Students',
                    'value' => '1,106',
                    'description' => '88.6% of students',
                ],
                [
                    'title' => 'Total Subjects',
                    'value' => '18',
                    'description' => 'This academic year',
                ],
                [
                    'title' => 'Total Modules',
                    'value' => '64',
                    'description' => 'Across all subjects',
                ],
                [
                    'title' => 'Total Chapters',
                    'value' => '212',
                    'description' => 'Content structure',
                ],
                [
                    'title' => 'Total Questions',
                    'value' => '3,842',
                    'description' => 'Question bank',
                ],
                [
                    'title' => 'Active Quizzes',
                    'value' => '12',
                    'description' => 'Currently published',
                ],
                [
                    'title' => 'Completed Quizzes',
                    'value' => '486',
                    'description' => 'This semester',
                ],
            ];
        @endphp


        @foreach ($stats as $stat)

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                <p class="text-xs font-medium text-slate-400">
                    {{ $stat['title'] }}
                </p>

                <div class="mt-3">

                    <h3 class="text-2xl font-bold text-slate-800">
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
    <div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">

            <div>

                <h3 class="text-sm font-semibold text-slate-800">
                    Recent activity
                </h3>

                <p class="mt-0.5 text-xs text-slate-400">
                    Latest activities across the platform
                </p>

            </div>

            <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-500">
                Last 7 days
            </span>

        </div>


        <div class="divide-y divide-slate-100">

            <div class="px-5 py-4">

                <p class="text-xs text-slate-600">
                    Priya Shah completed Data Structures
                    <span class="text-slate-400">— 12 minutes ago</span>
                </p>

            </div>

            <div class="px-5 py-4">

                <p class="text-xs text-slate-600">
                    A new quiz, Relational Databases, was published
                    <span class="text-slate-400">— 2 hours ago</span>
                </p>

            </div>

            <div class="px-5 py-4">

                <p class="text-xs text-slate-600">
                    Nikhil Verma joined Batch BCA-24
                    <span class="text-slate-400">— yesterday</span>
                </p>

            </div>

            <div class="px-5 py-4">

                <p class="text-xs text-slate-600">
                    48 questions imported from algorithms_midterm.csv
                    <span class="text-slate-400">— yesterday</span>
                </p>

            </div>

        </div>

    </div>

@endsection