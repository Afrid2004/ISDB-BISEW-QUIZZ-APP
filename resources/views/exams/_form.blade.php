<div class="space-y-6">


    {{-- Title --}}
    <div>
        <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">
            Exam Title
            <span class="text-red-500">*</span>
        </label>

        <input type="text" name="title" id="title" value="{{ old('title', $exam->title ?? '') }}"
            placeholder="Enter exam title"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Enter a clear and meaningful title for this exam.
        </p>
    </div>


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
                    {{ old('course_id', $exam->course_id ?? '') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }} ({{ $course->code ?? 'No code' }})
                </option>
            @endforeach
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the course this exam belongs to.
        </p>
    </div>


    {{-- Batch --}}
    <div>
        <label for="batch_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Batch
            <span class="text-red-500">*</span>
        </label>

        <select name="batch_id" id="batch_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            <option value="">
                Select a batch
            </option>

            @foreach ($batches ?? [] as $batch)
                <option value="{{ $batch->id }}"
                    {{ old('batch_id', $exam->batch_id ?? '') == $batch->id ? 'selected' : '' }}>
                    {{ $batch->name }}
                </option>
            @endforeach
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the batch whose students can attend this exam.
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

        <textarea name="description" id="description" rows="4" placeholder="Enter a short description about this exam..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('description', $exam->description ?? '') }}</textarea>

        <p class="mt-1.5 text-xs text-slate-400">
            Provide a brief description or instruction for this exam.
        </p>
    </div>


    {{-- Active --}}
    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-4">
        <div class="flex items-center justify-between gap-4">

            <div>
                <label for="is_active" class="block text-sm font-semibold text-slate-700">
                    Active
                </label>

                <p class="mt-1 text-xs text-slate-400">
                    Make this exam available for students.
                </p>
            </div>

            <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $exam->is_active ?? true) ? 'checked' : '' }}>

                <div
                    class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary
                        after:absolute after:left-[2px] after:top-[2px]
                        after:h-5 after:w-5 after:rounded-full
                        after:border after:border-slate-300 after:bg-white
                        after:transition-all
                        peer-checked:after:translate-x-full
                        peer-checked:after:border-white">
                </div>
            </label>

        </div>
    </div>


</div>
