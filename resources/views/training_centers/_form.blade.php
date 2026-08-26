<div class="space-y-6">
    {{-- Name --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Center Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" id="name"
            value="{{ old('name', $trainingCenter->name ?? '') }}" 
            maxlength="150" placeholder="e.g. Dhaka IT Training Center"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('name') border-red-400 focus:border-red-500 @enderror">
        @error('name') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    {{-- Code --}}
    <div>
        <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">
            Center Code <span class="text-red-500">*</span>
        </label>
        <input type="text" name="code" id="code"
            value="{{ old('code', $trainingCenter->code ?? '') }}" 
            maxlength="50" placeholder="e.g. TC-DHK-001"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('code') border-red-400 focus:border-red-500 @enderror">
        @error('code') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    {{-- Location --}}
    <div>
        <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">
            Location <span class="font-normal text-slate-400">(Optional)</span>
        </label>
        <textarea name="location" id="location" rows="4" placeholder="Enter training center address..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('location') border-red-400 focus:border-red-500 @enderror">{{ old('location', $trainingCenter->location ?? '') }}</textarea>
        @error('location') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    {{-- Active Status --}}
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
        <label class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3 transition hover:bg-slate-50">
            <div>
                <p class="text-sm font-medium text-slate-700">Active Training Center</p>
                <p class="mt-0.5 text-xs text-slate-400">Enable this training center for active operations.</p>
            </div>
            <div class="relative">
                <input type="checkbox" name="is_active" value="1" class="peer sr-only" 
                    {{ old('is_active', $trainingCenter->is_active ?? true) ? 'checked' : '' }}>
                <div class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary"></div>
                <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
            </div>
        </label>
    </div>
</div>