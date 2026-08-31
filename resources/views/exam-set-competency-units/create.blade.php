@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6">
            <div class="flex items-center flex-wrap sm:flex-nowrap justify-between gap-3">

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Assign Competency Unit
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Assign a competency unit to an existing exam set.
                    </p>
                </div>

                {{-- Show Exam Set Competency Units --}}
                <div>
                    <a href="{{ route('exam-set-competency-units.index') }}"
                        class="inline-flex items-center justify-center
                           gap-2 rounded-lg bg-primary
                           px-5 py-2.5 text-sm font-semibold
                           text-white transition
                           hover:bg-primary/90
                           focus:outline-none focus:ring-2
                           focus:ring-primary/50
                           focus:ring-offset-2">

                        <i class="bi bi-eye text-base"></i>
                        Show Assignments
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
                        Exam Set Competency Unit
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Select an exam set, module competency unit, and question count.
                    </p>

                    {{-- Alerts --}}
                    <x-_alerts />

                </div>


                {{-- Form --}}
                <form action="{{ route('exam-set-competency-units.store') }}" class="px-5 py-6 sm:px-6" method="POST">

                    @csrf

                    {{-- Reusable Form --}}
                    @include('exam-set-competency-units._form')


                    {{-- Form Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3
                           border-t border-slate-100 pt-5
                           sm:flex-row sm:justify-end">

                        {{-- Cancel --}}
                        <a href="{{ route('exam-set-competency-units.index') }}"
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
                            Assign Competency Unit
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
