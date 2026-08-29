<div class="space-y-6">
    {{-- Round Number --}}
    <div>
        <label for="round_number" class="mb-2 block text-sm font-bold text-slate-700">
            Round Number <span class="text-red-500">*</span>
        </label>
        
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <i class="bi bi-hash text-slate-400"></i>
            </div>
            <input type="text" name="round_number" id="round_number" min="1"
                value="{{ old('round_number', $round->round_number ?? '') }}" 
                placeholder="e.g. 1"
                class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10 @error('round_number') border-red-400 focus:ring-red-100 @enderror">
        </div>

        @error('round_number')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
        <p class="mt-1.5 text-[11px] text-slate-400 italic">Enter a unique identifier for this assessment round.</p>
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="mb-2 block text-sm font-bold text-slate-700">
            Description <span class="text-xs font-normal text-slate-400">(Optional)</span>
        </label>
        
        <textarea name="description" id="description" rows="4" 
            placeholder="Describe the purpose or details of this round..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10 @error('description') border-red-400 focus:ring-red-100 @enderror">{{ old('description', $round->description ?? '') }}</textarea>
        
        @error('description')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status Toggle --}}
    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-slate-700">Active Status</span>
                <span class="text-xs text-slate-400">Enable this round to be visible in the examination list.</span>
            </div>
            
            <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $round->is_active ?? true) ? 'checked' : '' }}>
                <div class="peer h-6 w-11 rounded-full bg-slate-300 transition-all after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full peer-focus:ring-4 peer-focus:ring-primary/20"></div>
            </label>
        </div>
    </div>
</div>