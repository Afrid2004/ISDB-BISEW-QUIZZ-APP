@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between gap-3">

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Edit Round
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Update the information of this round.
                    </p>
                </div>

                {{-- Show Data --}}
                <div>
                    <a href="{{ route('rounds.index') }}"
                        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2">

                        <i class="bi bi-eye text-base"></i>

                        Show Data

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
                        Round Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Update the basic information for this round.
                    </p>

                    {{-- Alerts --}}
                    <x-_alerts />

                </div>

                {{-- Form --}}
                <form action="{{ route('rounds.update', $round) }}" data-item="round" class="px-5 py-6 sm:px-6"
                    method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Form Fields --}}
                    @include('rounds._form')

                    {{-- Form Actions --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

                        {{-- Cancel --}}
                        <a href="{{ route('rounds.index') }}"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

                            Cancel

                        </a>

                        {{-- Update --}}
                        <button type="submit"
                            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2">

                            <i class="bi bi-check-lg text-base"></i>

                            Update Round

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
