<div class="space-y-6">

    {{-- Course Name --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Course Name
            <span class="text-red-500">*</span>
        </label>

        <input type="text" name="name" id="name" value="{{ old('name', $course->name ?? '') }}"
            placeholder="Enter course name"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Enter the name of the course.
        </p>
    </div>


    {{-- Course Code --}}
    <div>
        <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">
            Course Code
            <span class="text-red-500">*</span>
        </label>

        <input type="text" name="code" id="code" value="{{ old('code', $course->code ?? '') }}"
            placeholder="e.g. WAD-101"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Enter a unique code for this course.
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
            placeholder="Enter a short description about this course..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('description', $course->description ?? '') }}</textarea>

        <p class="mt-1.5 text-xs text-slate-400">
            Provide a brief description of the course.
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
                    Active Course
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this course to be used in the quiz system.
                </p>
            </div>

            {{-- Toggle --}}
            <div class="relative">

                <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $course->is_active ?? true) ? 'checked' : '' }}>

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
