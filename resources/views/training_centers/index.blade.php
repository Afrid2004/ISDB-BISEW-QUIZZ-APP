```blade
@extends('layouts.backend.app')

@section('content')

    <div class="min-h-screen bg-[#f7f8fc]">

        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Training Centers
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage training centers.
                </p>
            </div>

            <a href="{{ route('training-centers.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary/90">

                <i class="bi bi-plus-lg"></i>
                Add Training Center

            </a>

        </div>


        {{-- Search --}}
        <div class="mb-4">

            <form method="GET" action="{{ route('training-centers.index') }}">

                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search training centers..."
                    class="w-full max-w-sm rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">

            </form>

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="border-b border-slate-100 bg-slate-50">

                        <tr>

                            <th class="px-5 py-3 text-xs font-semibold text-slate-500">
                                Name
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold text-slate-500">
                                Code
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold text-slate-500">
                                Location
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold text-slate-500">
                                Created
                            </th>

                            <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($trainingCenters as $trainingCenter)

                            <tr class="hover:bg-slate-50">

                                {{-- Name --}}
                                <td class="px-5 py-4">

                                    <span class="font-semibold text-slate-700">
                                        {{ $trainingCenter->name }}
                                    </span>

                                </td>


                                {{-- Code --}}
                                <td class="px-5 py-4">

                                    <span class="rounded bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                        {{ $trainingCenter->code }}
                                    </span>

                                </td>


                                {{-- Location --}}
                                <td class="max-w-md px-5 py-4 text-sm text-slate-500">

                                    {{ $trainingCenter->location ?? 'No location' }}

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($trainingCenter->is_active)

                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                            Active
                                        </span>

                                    @else

                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- Created --}}
                                <td class="px-5 py-4 text-sm text-slate-500">

                                    {{ $trainingCenter->created_at?->format('d M, Y') }}

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex justify-center gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('training-centers.show', $trainingCenter) }}"
                                            title="View"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-primary/10 hover:text-primary">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('training-centers.edit', $trainingCenter) }}"
                                            title="Edit"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-primary/10 hover:text-primary">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form action="{{ route('training-centers.destroy', $trainingCenter) }}"
                                            method="POST"
                                            class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                title="Delete"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 hover:bg-red-100">

                                                <i class="bi bi-trash3"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-5 py-10 text-center">

                                    <p class="text-sm font-medium text-slate-600">
                                        No training centers found
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Create your first training center.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($trainingCenters->hasPages())

                <div class="flex items-center justify-between border-t border-slate-100 px-5 py-4">

                    <p class="text-xs text-slate-500">

                        Showing

                        <span class="font-semibold text-slate-700">
                            {{ $trainingCenters->firstItem() }}
                        </span>

                        -

                        <span class="font-semibold text-slate-700">
                            {{ $trainingCenters->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-slate-700">
                            {{ $trainingCenters->total() }}
                        </span>

                    </p>


                    <div>
                        {{ $trainingCenters->onEachSide(1)->links() }}
                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection


@push('scripts')

    <script src="{{ asset('/assets/js/deleteAlert.js') }}"></script>

    @if (session('success'))

        <script>

            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),
                    timer: 1000,
                    showConfirmButton: false
                });

            });

        </script>

    @endif

@endpush