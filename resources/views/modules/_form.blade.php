<div class="space-y-6">

    {{-- Course --}}
    <div>
        <label for="course_id" class="mb-2 block text-sm font-semibold text-slate-700">

            Course

            <span class="text-red-500">*</span>

        </label>

        <select name="course_id" id="course_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <option value="">
                Select a course
            </option>

            @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    {{ old('course_id', $module->course_id ?? '') == $course->id ? 'selected' : '' }}>

                    {{ $course->name }} ({{ $course->code ?? 'No code' }})

                </option>
            @endforeach

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the course this module belongs to.
        </p>
    </div>


    {{-- Module Number --}}
    <div>

        <label for="module_number" class="mb-2 block text-sm font-semibold text-slate-700">

            Module Number

            <span class="text-red-500">*</span>

        </label>

        <input type="text" min="1" name="module_number" id="module_number"
            value="{{ old('module_number', $module->module_number ?? '') }}" placeholder="Enter module number"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Enter the number of the module.
        </p>

    </div>


    {{-- Module Name --}}
    <div>

        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

            Module Name

            <span class="font-normal text-slate-400">
                (Optional)
            </span>
        </label>

        <input type="text" name="name" id="name" value="{{ old('name', $module->name ?? '') }}"
            placeholder="Enter module name"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Enter the name of the module.
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
            placeholder="Enter a short description about this module..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('description', $module->description ?? '') }}</textarea>

        <p class="mt-1.5 text-xs text-slate-400">
            Provide a brief description of the module.
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
                    Active Module
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this module to be used in the quiz system.
                </p>

            </div>


            {{-- Toggle --}}
            <div class="relative">

                <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $module->is_active ?? true) ? 'checked' : '' }}>

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
