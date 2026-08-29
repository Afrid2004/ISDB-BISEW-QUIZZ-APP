<div class="space-y-6">

    {{-- Module --}}
    <div>
        <label for="module_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Module
            <span class="text-red-500">*</span>
        </label>

        <select name="module_id" id="module_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <option value="">
                Select a module
            </option>

            @foreach ($modules as $module)
                <option value="{{ $module->id }}"
                    {{ old('module_id', $competencyUnit->module_id ?? '') == $module->id ? 'selected' : '' }}>
                    {{ $module->name }}
                </option>
            @endforeach

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the module this competency unit belongs to.
        </p>
    </div>


    {{-- Competency Unit Name --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Competency Unit Name
            <span class="text-red-500">*</span>
        </label>

        <input type="text" name="name" id="name" value="{{ old('name', $competencyUnit->name ?? '') }}"
            placeholder="Enter competency unit name"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Enter the name of the competency unit.
        </p>
    </div>


    {{-- Description --}}
    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
            Description
            <span class="font-normal text-slate-400">
                (Optional)
            </span>
        </label>

        <textarea name="description" id="description" rows="4"
            placeholder="Enter a short description about this competency unit..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('description', $competencyUnit->description ?? '') }}</textarea>

        <p class="mt-1.5 text-xs text-slate-400">
            Provide a brief description of the competency unit.
        </p>
    </div>


    {{-- Competency Unit Order --}}
    <div>
        <label for="competency_unit_order" class="mb-2 block text-sm font-semibold text-slate-700">
            Competency Unit Order
            <span class="font-normal text-slate-400">
                (Optional)
            </span>
        </label>

        <input type="number" name="competency_unit_order" id="competency_unit_order"
            value="{{ old('competency_unit_order', $competencyUnit->competency_unit_order ?? '') }}" min="1"
            placeholder="Enter order number"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Set the display order of this competency unit within the module.
        </p>
    </div>


    {{-- Active Status --}}
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Status
        </label>

        <label
            class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3 transition hover:bg-slate-50">

            <div>
                <p class="text-sm font-medium text-slate-700">
                    Active Competency Unit
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this competency unit to be used in the quiz system.
                </p>
            </div>

            {{-- Toggle --}}
            <div class="relative">

                <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $competencyUnit->is_active ?? true) ? 'checked' : '' }}>

                {{-- Toggle Background --}}
                <div
                    class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/30">
                </div>

                {{-- Toggle Circle --}}
                <div
                    class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                </div>

            </div>

        </label>
    </div>

</div>
