@extends('layouts.backend.app')

@section('content')

    <div class="flex min-h-[70vh] items-center justify-center px-4">

        <div class="w-full max-w-lg text-center">

            {{-- Icon --}}
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center
                        rounded-full bg-primary/10 text-primary">

                <i class="bi bi-exclamation-triangle text-4xl"></i>

            </div>

            {{-- 404 --}}
            <h1 class="text-7xl font-bold tracking-tight text-slate-800">
                404
            </h1>

            <h2 class="mt-4 text-2xl font-bold text-slate-800">
                Page Not Found
            </h2>

            <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-slate-500">
                Sorry, the page you're looking for doesn't exist
                or may have been moved.
            </p>

            {{-- Actions --}}
            <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">

                {{-- Go Back --}}
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg border border-slate-200
                           bg-white px-5 py-2.5
                           text-sm font-semibold text-slate-600
                           transition hover:bg-slate-50">

                    <i class="bi bi-arrow-left"></i>

                    Go Back

                </a>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-lg bg-primary px-5 py-2.5
                           text-sm font-semibold text-white
                           transition hover:bg-primary/90">

                    <i class="bi bi-house"></i>

                    Back to Dashboard

                </a>

            </div>

        </div>

    </div>

@endsection