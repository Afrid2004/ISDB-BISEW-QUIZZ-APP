<div class="space-y-6">

    {{-- =========================================================
        Course
    ========================================================== --}}
    <div>

        <label for="course_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Course
            <span class="text-red-500">*</span>
        </label>


        <select id="course_id" data-current-course-id="{{ $currentCourse?->id ?? '' }}"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <option value="">
                Select a course
            </option>


            @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    {{ old('course_id', $currentCourse?->id ?? '') == $course->id ? 'selected' : '' }}>
                    {{ $course->code }} - {{ $course->name }}
                </option>
            @endforeach

        </select>


        <p class="mt-1.5 text-xs text-slate-400">
            Select a course to filter its modules.
        </p>

    </div>


    {{-- =========================================================
        Module
    ========================================================== --}}
    <div>

        <label for="module_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Module
            <span class="text-red-500">*</span>
        </label>


        <select id="module_id" data-current-module-id="{{ $currentModule?->id ?? '' }}" disabled
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400">

            <option value="">
                Select a module
            </option>

        </select>


        <p class="mt-1.5 text-xs text-slate-400">
            Select a module to filter its competency units.
        </p>

    </div>


    {{-- =========================================================
        Competency Unit
    ========================================================== --}}
    <div>

        <label for="competency_unit_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Competency Unit
            <span class="text-red-500">*</span>
        </label>


        <select name="competency_unit_id" id="competency_unit_id"
            data-current-competency-unit-id="{{ $currentCompetencyUnit?->id ?? '' }}" disabled
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400">

            <option value="">
                Select a competency unit
            </option>

        </select>


        <p class="mt-1.5 text-xs text-slate-400">
            Select the competency unit this element belongs to.
        </p>

    </div>


    {{-- =========================================================
        Element Name
    ========================================================== --}}
    <div>

        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Element Name
            <span class="text-red-500">*</span>
        </label>


        <input type="text" name="name" id="name" value="{{ old('name', $element?->name ?? '') }}"
            placeholder="Enter element name"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">


        <p class="mt-1.5 text-xs text-slate-400">
            Enter the name of the element.
        </p>

    </div>


    {{-- =========================================================
        Description
    ========================================================== --}}
    <div>

        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
            Description

            <span class="font-normal text-slate-400">
                (Optional)
            </span>

        </label>


        <textarea name="description" id="description" rows="4"
            placeholder="Enter a short description about this element..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('description', $element?->description ?? '') }}</textarea>


        <p class="mt-1.5 text-xs text-slate-400">
            Provide a brief description of the element.
        </p>

    </div>


    {{-- =========================================================
        Active Status
    ========================================================== --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Status
        </label>


        <label
            class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3 transition hover:bg-slate-50">

            <div>

                <p class="text-sm font-medium text-slate-700">
                    Active Element
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this element to be used in the quiz system.
                </p>

            </div>


            <div class="relative">

                <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $element?->is_active ?? true) ? 'checked' : '' }}>


                <div
                    class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/30">
                </div>


                <div
                    class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                </div>

            </div>

        </label>

    </div>

</div>
