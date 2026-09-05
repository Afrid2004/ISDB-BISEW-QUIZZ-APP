<div
    class="manage-questions-data"
    data-existing-mappings='@json($existingMappings ?? [])'
    data-modules='@json($modules ?? [])'
    data-total-marks="{{ $examSet->total_marks }}">

    <div class="grid grid-cols-1 gap-6">

        <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-slate-700">
                        Exam Set Marks
                    </p>
                    <p class="mt-1 text-xs text-slate-400">
                        Total marks for this exam set.
                    </p>
                </div>

                <span class="text-lg font-bold text-primary">
                    {{ $examSet->total_marks }}
                </span>
            </div>

            <div class="mt-3 border-t border-slate-200 pt-3">
                <p class="text-sm text-slate-600">
                    Selected Marks:
                    <span class="selected-total-marks font-semibold text-primary">
                        0
                    </span>
                    /
                    <span class="total-exam-marks font-semibold">
                        {{ $examSet->total_marks }}
                    </span>
                </p>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">
                Modules
                <span class="text-red-500">*</span>
            </label>

            <div class="module-sections space-y-5"></div>

            <button
                type="button"
                class="add-module-btn mt-4 inline-flex cursor-pointer items-center gap-2 rounded-lg border border-primary/20 bg-primary/5 px-4 py-2.5 text-sm font-semibold text-primary transition hover:bg-primary/10">
                <i class="bi bi-plus-lg"></i>
                Add Module
            </button>

            @error('modules')
                <p class="mt-1.5 text-xs text-red-500">
                    {{ $message }}
                </p>
            @enderror

            @error('modules.*.module_id')
                <p class="mt-1.5 text-xs text-red-500">
                    {{ $message }}
                </p>
            @enderror

            @error('modules.*.competency_units')
                <p class="mt-1.5 text-xs text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700">
                        Active
                    </label>

                    <p class="mt-1 text-xs text-slate-400">
                        Make this question distribution active.
                    </p>
                </div>

                <label class="relative inline-flex cursor-pointer items-center">
                    <input
                        type="hidden"
                        name="is_active"
                        value="0">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="peer sr-only"
                        {{ old('is_active', $savedActive ?? true) ? 'checked' : '' }}>

                    <div
                        class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white">
                    </div>
                </label>
            </div>
        </div>

    </div>
</div>