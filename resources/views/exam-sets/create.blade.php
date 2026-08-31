@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">


        {{-- Page Header --}}
        <div class="mb-6">
            <div class="flex items-center flex-wrap sm:flex-nowrap justify-between gap-3">

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Add New Exam Set
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Create a new set for an existing exam.
                    </p>
                </div>

                {{-- Show Exam Sets --}}
                <div>
                    <a href="{{ route('exam-sets.index') }}"
                        class="inline-flex items-center justify-center
                           gap-2 rounded-lg bg-primary
                           px-5 py-2.5 text-sm font-semibold
                           text-white transition
                           hover:bg-primary/90
                           focus:outline-none focus:ring-2
                           focus:ring-primary/50
                           focus:ring-offset-2">

                        <i class="bi bi-eye text-base"></i>
                        Show Exam Sets
                    </a>
                </div>

            </div>
        </div>

        {{-- Form Card --}}
        <div class="mx-auto max-w-3xl md:max-w-full">

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                {{-- Card Header --}}
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                    <h2 class="text-base font-semibold text-slate-800">
                        Exam Set Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Enter the basic information and configuration for this exam set.
                    </p>

                    {{-- Alerts --}}
                    <x-_alerts />

                </div>

                {{-- Form --}}
                <form action="{{ route('exam-sets.store') }}" class="px-5 py-6 sm:px-6" method="POST">

                    @csrf

                    {{-- Reusable Form --}}
                    @include('exam-sets._form')

                    {{-- Form Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3
                           border-t border-slate-100 pt-5
                           sm:flex-row sm:justify-end">

                        {{-- Cancel --}}
                        <a href="{{ route('exam-sets.index') }}"
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
                               focus:ring-offset-2 cursor-pointer">

                            <i class="bi bi-check-lg text-base"></i>
                            Create Exam Set

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
