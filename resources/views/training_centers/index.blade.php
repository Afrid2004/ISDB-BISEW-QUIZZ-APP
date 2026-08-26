@extends('layouts.backend.app')

@section('content')
    <div class="min-h-screen bg-[#f7f8fc]">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Training Centers</h1>
                <p class="mt-1 text-sm text-slate-500">Manage training centers.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('training-centers.deleted') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    <i class="bi bi-trash3"></i> Trash Bin
                </a>
                <a href="{{ route('training-centers.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary/90">
                    <i class="bi bi-plus-lg"></i> Add Training Center
                </a>
            </div>
        </div>

        {{-- Universal Alerts --}}
        <x-_alerts />

        {{-- Search --}}
        <div class="mb-4">
            <form method="GET" action="{{ route('training-centers.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search training centers..."
                    class="w-full max-w-sm rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </form>
        </div>

        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-slate-100 bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">Name</th>
                            <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">Code</th>
                            <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase text-center">Status</th>
                            <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($trainingCenters as $trainingCenter)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-5 py-4 font-semibold text-slate-700">{{ $trainingCenter->name }}</td>
                                <td class="px-5 py-4"><span class="bg-slate-100 px-2 py-1 rounded text-xs text-slate-600">{{ $trainingCenter->code }}</span></td>
                                <td class="px-5 py-4 text-center">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $trainingCenter->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $trainingCenter->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('training-centers.show', $trainingCenter) }}" class="p-2 border rounded-lg text-slate-500 hover:text-primary hover:bg-primary/5"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('training-centers.edit', $trainingCenter) }}" class="p-2 border rounded-lg text-slate-500 hover:text-primary hover:bg-primary/5"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('training-centers.destroy', $trainingCenter) }}" method="POST" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 border border-red-100 bg-red-50 text-red-500 rounded-lg hover:bg-red-100"><i class="bi bi-trash3"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-10 text-center text-slate-400">No training centers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($trainingCenters->hasPages())
                <div class="p-4 border-t">{{ $trainingCenters->links() }}</div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>
@endpush