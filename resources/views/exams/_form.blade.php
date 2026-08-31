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


</div>
