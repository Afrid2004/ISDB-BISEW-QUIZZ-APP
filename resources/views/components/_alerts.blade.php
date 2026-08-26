@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" 
         class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 shadow-sm {{ $attributes ?? '' }}">
        <div class="flex gap-3">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-red-800">Required actions needed:</h3>
                <ul class="mt-1 list-disc pl-5 text-xs text-red-700 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" class="text-red-400 hover:text-red-600 transition">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
@endif

@if (session('success'))
    <div x-data="{ show: true }" 
         x-init="setTimeout(() => show = false, 5000)" 
         x-show="show" 
         x-transition.duration.500ms
         class="mb-6 flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 shadow-sm {{ $attributes ?? '' }}">
        <div class="flex items-center gap-3">
            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500 text-white">
                <i class="bi bi-check text-lg"></i>
            </div>
            <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition">
            <i class="bi bi-x-lg text-sm"></i>
        </button>
    </div>
@endif