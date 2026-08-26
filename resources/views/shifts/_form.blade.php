<div class="space-y-6">

    {{-- Name --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-bold text-slate-700">
            Shift Name <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <i class="bi bi-clock text-slate-400"></i>
            </div>
            <input type="text" name="name" id="name" maxlength="50"
                value="{{ old('name', $shift->name ?? '') }}" placeholder="e.g. Morning Shift"
                class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10 @error('name') border-red-400 focus:ring-red-100 @enderror">
        </div>
        @error('name') <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
    </div>

    {{-- Code --}}
    <div>
        <label for="code" class="mb-2 block text-sm font-bold text-slate-700">
            Shift Code <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <i class="bi bi-upc-scan text-slate-400"></i>
            </div>
            <input type="text" name="code" id="code" maxlength="20"
                value="{{ old('code', $shift->code ?? '') }}" placeholder="e.g. SH-M-01"
                class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10 @error('code') border-red-400 focus:ring-red-100 @enderror">
        </div>
        @error('code') <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
    </div>

    {{-- Time Range --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label for="start_time" class="mb-2 block text-sm font-bold text-slate-700">
                Start Time <span class="text-xs font-normal text-slate-400">(Optional)</span>
            </label>
            <input type="time" name="start_time" id="start_time"
                value="{{ old('start_time', $shift->start_time ?? '') }}"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10 @error('start_time') border-red-400 focus:ring-red-100 @enderror">
        </div>

        <div>
            <label for="end_time" class="mb-2 block text-sm font-bold text-slate-700">
                End Time <span class="text-xs font-normal text-slate-400">(Optional)</span>
            </label>
            <input type="time" name="end_time" id="end_time"
                value="{{ old('end_time', $shift->end_time ?? '') }}"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10 @error('end_time') border-red-400 focus:ring-red-100 @enderror">
        </div>
    </div>

    {{-- Status --}}
    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-slate-700">Active Status</span>
                <span class="text-xs text-slate-400">Enable this shift for active operations.</span>
            </div>
            
            <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $shift->is_active ?? true) ? 'checked' : '' }}>
                <div class="peer h-6 w-11 rounded-full bg-slate-300 transition-all after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full peer-focus:ring-4 peer-focus:ring-primary/20"></div>
            </label>
        </div>
    </div>
</div>