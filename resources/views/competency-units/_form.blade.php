<div class="space-y-6">

    {{-- Prefix --}}
    <div>
        <label for="prefix" class="mb-2 block text-sm font-semibold text-slate-700">
            Prefix
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="prefix"
            id="prefix"
            value="{{ old('prefix', $competencyUnit->prefix ?? 'STC') }}"
            maxlength="10"
            placeholder="e.g. STC"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5
                   text-sm text-slate-700 outline-none transition
                   focus:border-primary focus:ring-2 focus:ring-primary/20"
        >
    </div>


    {{-- Course --}}
    <div>
        <label for="course_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Course
            <span class="text-red-500">*</span>
        </label>

        <select
            name="course_id"
            id="course_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5
                   text-sm text-slate-700 outline-none transition
                   focus:border-primary focus:ring-2 focus:ring-primary/20"
        >

            <option value="">Select Course</option>

            @foreach ($courses as $course)

                <option
                    value="{{ $course->id }}"
                    {{ old('course_id', $competencyUnit->module->course_id ?? '') == $course->id ? 'selected' : '' }}
                >
                    {{ $course->code }} - {{ $course->name }}
                </option>

            @endforeach

        </select>
    </div>


    {{-- Module --}}
    <div>

        <label for="module_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Module
            <span class="text-red-500">*</span>
        </label>

        <select
            name="module_id"
            id="module_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5
                   text-sm text-slate-700 outline-none transition
                   focus:border-primary focus:ring-2 focus:ring-primary/20"
        >

            <option value="">Select Module</option>

            @foreach ($modules ?? [] as $module)

                <option
                    value="{{ $module->id }}"
                    {{ old('module_id', $competencyUnit->module_id ?? '') == $module->id ? 'selected' : '' }}
                >
                    Module {{ $module->module_number }} - {{ $module->name }}
                </option>

            @endforeach

        </select>

    </div>


    {{-- Generated Code --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Competency Unit Code
        </label>

        <div
            id="competency_unit_preview"
            class="flex min-h-[42px] items-center rounded-lg
                   border border-slate-200 bg-slate-50 px-4
                   text-sm font-semibold text-slate-700"
        >
            {{ $competencyUnit->code ?? '-' }}
        </div>

    </div>


    {{-- Active Status --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Status
        </label>

        <label
            class="flex cursor-pointer items-center justify-between rounded-lg
                   border border-slate-200 bg-slate-50/50 px-4 py-3"
        >

            <div>

                <p class="text-sm font-medium text-slate-700">
                    Active Competency Unit
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this competency unit to be used in the quiz system.
                </p>

            </div>

            <div class="relative">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="peer sr-only"
                    {{ old('is_active', $competencyUnit->is_active ?? true) ? 'checked' : '' }}
                >

                <div
                    class="h-6 w-11 rounded-full bg-slate-300 transition
                           peer-checked:bg-primary"
                ></div>

                <div
                    class="absolute left-1 top-1 h-4 w-4 rounded-full
                           bg-white shadow-sm transition
                           peer-checked:translate-x-5"
                ></div>

            </div>

        </label>

    </div>

</div>