<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- Batch --}}
    <div>
        <label for="batch_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Batch <span class="text-red-500">*</span>
        </label>

        <select name="batch_id" id="batch_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            <option value="">Select Batch</option>

            @foreach ($batches ?? [] as $batch)
                <option value="{{ $batch->id }}"
                    {{ old('batch_id', $examSetCompetencyUnit->examSet->exam->batch_id ?? '') == $batch->id ? 'selected' : '' }}>
                    {{ $batch->name }}
                </option>
            @endforeach
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the batch for the exam and module.
        </p>

        @error('batch_id')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>


    {{-- Exam --}}
    <div>
        <label for="exam_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Exam <span class="text-red-500">*</span>
        </label>

        <select name="exam_id" id="exam_id" disabled
            data-selected="{{ old('exam_id', $examSetCompetencyUnit->examSet->exam_id ?? '') }}"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400">
            <option value="">Select Exam</option>
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Exams will be loaded based on the selected batch.
        </p>

        @error('exam_id')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>


    {{-- Exam Set --}}
    <div>
        <label for="exam_set_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Exam Set <span class="text-red-500">*</span>
        </label>

        <select name="exam_set_id" id="exam_set_id" disabled
            data-selected="{{ old('exam_set_id', $examSetCompetencyUnit->exam_set_id ?? '') }}"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400">
            <option value="">Select Exam Set</option>
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Exam sets will be loaded after selecting an exam.
        </p>

        @error('exam_set_id')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Module --}}
    <div>
        <label for="module_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Module <span class="text-red-500">*</span>
        </label>

        <select name="module_id" id="module_id" disabled
            data-selected="{{ old('module_id', $examSetCompetencyUnit->competencyUnit->module_id ?? '') }}"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400">
            <option value="">Select Module</option>
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Modules will be loaded based on the selected batch course.
        </p>

        @error('module_id')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>


    {{-- Competency Units --}}
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Competency Units <span class="text-red-500">*</span>
        </label>

        <div id="competencyUnitsContainer" class="space-y-2 rounded-lg border border-slate-200 bg-slate-50 p-3"
            data-existing-mappings='@json(
                ($existingMappings ?? collect())->mapWithKeys(function ($mapping) {
                    return [
                        $mapping->competency_unit_id => [
                            'question_count' => $mapping->question_count,
                        ],
                    ];
                }))'>
            <p class="text-sm text-slate-400">
                Select a module to load competency units.
            </p>
        </div>

        @error('competency_units')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror

        @error('competency_units.*.question_count')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>


    {{-- Active --}}
    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-4">
        <div class="flex items-center justify-between gap-4">

            <div>
                <label for="is_active" class="block text-sm font-semibold text-slate-700">
                    Active
                </label>

                <p class="mt-1 text-xs text-slate-400">
                    Make this competency unit assignment active.
                </p>
            </div>

            <label class="relative inline-flex cursor-pointer items-center">

                <input type="hidden" name="is_active" value="0">

                <input type="checkbox" name="is_active" id="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', $examSetCompetencyUnit->is_active ?? true) ? 'checked' : '' }}>

                <div
                    class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white">
                </div>

            </label>

        </div>
    </div>

</div>
