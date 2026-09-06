
<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- Round --}}
    <div>
        <label for="round_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Round
            <span class="text-red-500">*</span>
        </label>

        <select
            name="round_id"
            id="round_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            required
        >
            <option value="">
                Select a round
            </option>

            @foreach ($rounds as $round)
                <option
                    value="{{ $round->id }}"
                    {{ old('round_id', $selectedRoundId ?? '') == $round->id ? 'selected' : '' }}
                >
                    Round - {{ $round->round_number }}
                </option>
            @endforeach
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the round for this exam slot.
        </p>

        @error('round_id')
            <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Batch --}}
    <div>
        <label for="batch_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Batch
            <span class="text-red-500">*</span>
        </label>

        <select
            name="batch_id"
            id="batch_id"
            data-selected="{{ old('batch_id', $examSlot->batch_id ?? '') }}"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-50"
            required
            disabled
        >
            <option value="">
                Select a batch
            </option>
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Batches available for the selected round will appear here.
        </p>

        @error('batch_id')
            <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Exam --}}
    <div>
        <label for="exam_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Exam
            <span class="text-red-500">*</span>
        </label>

        <select
            name="exam_id"
            id="exam_id"
            data-selected="{{ old('exam_id', $selectedExamId ?? '') }}"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-50"
            required
            disabled
        >
            <option value="">
                Select Exam
            </option>
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Active exams for the selected batch will appear here.
        </p>

        @error('exam_id')
            <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Exam Set --}}
    <div>
        <label for="exam_set_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Exam Set
            <span class="text-red-500">*</span>
        </label>

        <select
            name="exam_set_id"
            id="exam_set_id"
            data-selected="{{ old('exam_set_id', $examSlot->exam_set_id ?? '') }}"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-50"
            required
            disabled
        >
            <option value="">
                Select Exam Set
            </option>
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Incomplete exam sets for the selected exam will appear here.
        </p>

        @error('exam_set_id')
            <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Start Date & Time --}}
    <div>
        <label for="start_at" class="mb-2 block text-sm font-semibold text-slate-700">
            Start Date & Time
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="start_at"
            id="start_at"
            value="{{ old('start_at', isset($examSlot) ? $examSlot->start_at->format('Y-m-d H:i') : '') }}"
            placeholder="Select start date & time"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            required
        >

        <p class="mt-1.5 text-xs text-slate-400">
            Select when the exam will start.
        </p>

        @error('start_at')
            <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- End Date & Time --}}
    <div>
        <label for="end_at" class="mb-2 block text-sm font-semibold text-slate-700">
            End Date & Time
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="end_at"
            id="end_at"
            value="{{ old('end_at', isset($examSlot) ? $examSlot->end_at->format('Y-m-d H:i') : '') }}"
            placeholder="Select end date & time"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            required
        >

        <p class="mt-1.5 text-xs text-slate-400">
            Select when the exam will end.
        </p>

        @error('end_at')
            <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Active Status --}}
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Status
        </label>

        <label class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3 transition hover:bg-slate-50">

            <div>
                <p class="text-sm font-medium text-slate-700">
                    Active Exam Slot
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this exam slot to be used for the online exam.
                </p>
            </div>

            <div class="relative">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="peer sr-only"
                    {{ old('is_active', $examSlot->is_active ?? true) ? 'checked' : '' }}
                >

                <div class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/30">
                </div>

                <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                </div>
            </div>

        </label>

        @error('is_active')
            <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror
    </div>

</div>

