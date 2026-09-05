<div class="space-y-6">

    <div>
        <label for="batch_id"
            class="mb-2 block text-sm font-semibold text-slate-700">

            Batch <span class="text-red-500">*</span>

        </label>

        <select
            name="batch_id"
            id="batch_id"
            required
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <option value="">Select a batch</option>

            @foreach ($batches as $batch)
                <option
                    value="{{ $batch->id }}"
                    {{ old('batch_id') == $batch->id ? 'selected' : '' }}>

                    {{ $batch->name }}

                </option>
            @endforeach

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the batch for this exam set.
        </p>
    </div>

    <div>
        <label for="exam_id"
            class="mb-2 block text-sm font-semibold text-slate-700">

            Exam <span class="text-red-500">*</span>

        </label>

        <select
            name="exam_id"
            id="exam_id"
            required
            disabled
            class="w-full rounded-lg border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed">

            <option value="">Select an exam</option>

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the exam under the selected batch.
        </p>
    </div>

    <div>
        <label for="exam_set_id"
            class="mb-2 block text-sm font-semibold text-slate-700">

            Exam Set <span class="text-red-500">*</span>

        </label>

        <select
            name="exam_set_id"
            id="exam_set_id"
            required
            disabled
            class="w-full rounded-lg border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed">

            <option value="">Select an exam set</option>

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the exam set for which questions will be generated.
        </p>
    </div>

    <div
        id="questionSummary"
        class="hidden rounded-lg border border-slate-200 bg-slate-50/50">

        <div class="border-b border-slate-200 px-4 py-3">

            <div class="flex items-center justify-between gap-3">

                <div>
                    <p class="text-sm font-semibold text-slate-700">
                        Question Distribution
                    </p>

                    <p class="mt-0.5 text-xs text-slate-400">
                        Questions will be selected automatically based on competency unit requirements.
                    </p>
                </div>

                <span
                    id="totalQuestionBadge"
                    class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">

                    0 Questions

                </span>

            </div>

        </div>

        <div
            id="loadingMessage"
            class="hidden px-4 py-4 text-center text-sm text-slate-400">

            Loading question distribution...

        </div>

        <div
            id="noAssignmentMessage"
            class="hidden px-4 py-4 text-sm text-amber-600">

            No competency units are assigned to this exam set.

        </div>

        <div
            id="assignmentList"
            class="hidden overflow-hidden">

            <div
                class="grid grid-cols-12 border-b border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">

                <div class="col-span-2">
                    Code
                </div>

                <div class="col-span-6">
                    Competency Unit
                </div>

                <div class="col-span-2 text-center">
                    Questions
                </div>

                <div class="col-span-2 text-center">
                    Action
                </div>

            </div>

            <div id="assignmentRows"></div>

        </div>

    </div>

</div>