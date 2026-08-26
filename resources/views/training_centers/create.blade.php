@extends('layouts.backend.app')
@section('content')
<div class="min-h-screen bg-[#f7f8fc] px-4 py-6 sm:px-6 lg:px-0">
    {{-- Header remains same --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Add New Training Center</h1>
        <a href="{{ route('training-centers.index') }}" class="bg-primary px-5 py-2.5 text-sm font-semibold text-white rounded-lg">Show Data</a>
    </div>

    <div class="mx-auto max-w-3xl md:max-w-full">
        <x-_alerts /> {{-- Universal Alert Component --}}
        
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <form action="{{ route('training-centers.store') }}" method="POST" class="px-5 py-6 sm:px-6">
                @csrf
                @include('training_centers._form')

                <div class="mt-8 flex justify-end gap-3 pt-5">
                    <a href="{{ route('training-centers.index') }}" class="px-5 py-2.5 text-slate-600 border rounded-lg">Cancel</a>
                    <button type="submit" class="bg-primary px-5 py-2.5 text-white font-semibold rounded-lg">Create Training Center</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection