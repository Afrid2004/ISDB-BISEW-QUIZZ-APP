@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        <div class="mb-6">
            <div class="flex items-center flex-wrap sm:flex-nowrap justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Add New Competency Unit
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Create a new competency unit for your module.
                    </p>
                </div>

                <div>
                    <a href="{{ route('competency-units.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2">
                        <i class="bi bi-eye text-base"></i>
                        Show Data
                    </a>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-3xl md:max-w-full">
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-base font-semibold text-slate-800">
                        Competency Unit Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Enter the basic information for this competency unit.
                    </p>

                    {{-- Alerts --}}
                    <x-_alerts />
                </div>

                {{-- Form --}}
                <form action="{{ route('competency-units.store') }}" class="px-5 py-6 sm:px-6" method="POST">
                    @csrf

                    @include('competency-units._form')

                    {{-- Form Actions --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

                        {{-- Cancel --}}
                        <a href="{{ route('competency-units.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            Cancel
                        </a>

                        {{-- Create --}}
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 cursor-pointer">
                            <i class="bi bi-check-lg text-base"></i>
                            Create Competency Unit
                        </button>

                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
