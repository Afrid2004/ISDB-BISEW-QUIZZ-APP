<div class="space-y-6">


    {{-- Exam --}}
    <div>
        <label for="exam_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Exam
            <span class="text-red-500">*</span>
        </label>

        <select name="exam_id" id="exam_id"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            <option value="">
                Select an exam
            </option>

            @foreach ($exams ?? [] as $examItem)
                <option value="{{ $examItem->id }}"
                    {{ old('exam_id', $examSet->exam_id ?? '') == $examItem->id ? 'selected' : '' }}>
                    {{ $examItem->title }}
                </option>
            @endforeach
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the exam this set belongs to.
        </p>
    </div>


    {{-- Set Name --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Set Name
            <span class="text-red-500">*</span>
        </label>

        <input type="text" name="name" id="name" value="{{ old('name', $examSet->name ?? '') }}"
            placeholder="Enter set name"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

        <p class="mt-1.5 text-xs text-slate-400">
            Enter a meaningful name for this exam set.
        </p>
    </div>


    {{-- Type --}}
    <div>
        <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">
            Exam Type
            <span class="text-red-500">*</span>
        </label>

        <select name="type" id="type"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            <option value="">
                Select exam type
            </option>

            <option value="mid" {{ old('type', $examSet->type ?? '') == 'mid' ? 'selected' : '' }}>
                Mid
            </option>

            <option value="monthly" {{ old('type', $examSet->type ?? '') == 'monthly' ? 'selected' : '' }}>
                Monthly
            </option>
        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the type of this exam set.
        </p>
    </div>


    {{-- Question Type --}}
    <div>
        <label for="question_type" class="mb-2 block text-sm font-semibold text-slate-700">
            Question Type
            <span class="text-red-500">*</span>
        </label>

        <select name="question_type" id="question_type"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <option value="">
                Select question type
            </option>

            <option value="mcq" {{ old('question_type', $examSet->question_type ?? '') == 'mcq' ? 'selected' : '' }}>
                MCQ
            </option>

            <option value="evidence"
                {{ old('question_type', $examSet->question_type ?? '') == 'evidence' ? 'selected' : '' }}>
                Evidence
            </option>

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the type of questions used in this set.
        </p>
    </div>


    {{-- Mode --}}
    <div>
        <label for="mode" class="mb-2 block text-sm font-semibold text-slate-700">
            Mode
            <span class="text-red-500">*</span>
        </label>

        <select name="mode" id="mode"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <option value="">
                Select mode
            </option>

            <option value="online" {{ old('mode', $examSet->mode ?? '') == 'online' ? 'selected' : '' }}>
                Online
            </option>

            <option value="offline" {{ old('mode', $examSet->mode ?? '') == 'offline' ? 'selected' : '' }}>
                Offline
            </option>

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select whether this set will be conducted online or offline.
        </p>
    </div>


    {{-- Set Number + Duration --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

        {{-- Set Number --}}
        <div>
            <label for="set_number" class="mb-2 block text-sm font-semibold text-slate-700">
                Set Number
                <span class="text-red-500">*</span>
            </label>

            <select name="set_number" id="set_number"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

                <option value="">
                    Select set number
                </option>

                @for ($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}"
                        {{ old('set_number', $examSet->set_number ?? '') == $i ? 'selected' : '' }}>
                        Set {{ $i }}
                    </option>
                @endfor

            </select>

            <p class="mt-1.5 text-xs text-slate-400">
                Select the set number from 1 to 4.
            </p>
        </div>


        {{-- Duration --}}
        <div>
            <label for="duration_minutes" class="mb-2 block text-sm font-semibold text-slate-700">
                Duration
                <span class="font-normal text-slate-400">(Minutes)</span>
            </label>

            <input type="number" name="duration_minutes" id="duration_minutes" min="1"
                value="{{ old('duration_minutes', $examSet->duration_minutes ?? '') }}" placeholder="e.g. 60"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <p class="mt-1.5 text-xs text-slate-400">
                Enter the duration of this set in minutes.
            </p>
        </div>

    </div>


    {{-- Total Marks + Pass Marks --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

        {{-- Total Marks --}}
        <div>
            <label for="total_marks" class="mb-2 block text-sm font-semibold text-slate-700">
                Total Marks
                <span class="text-red-500">*</span>
            </label>

            <input type="number" name="total_marks" id="total_marks" min="0" step="0.01"
                value="{{ old('total_marks', $examSet->total_marks ?? '0.00') }}" placeholder="e.g. 100"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <p class="mt-1.5 text-xs text-slate-400">
                Enter the total marks for this set.
            </p>
        </div>


        {{-- Pass Marks --}}
        <div>
            <label for="pass_marks" class="mb-2 block text-sm font-semibold text-slate-700">
                Pass Marks
                <span class="text-red-500">*</span>
            </label>

            <input type="number" name="pass_marks" id="pass_marks" min="0" step="0.01"
                value="{{ old('pass_marks', $examSet->pass_marks ?? '0.00') }}" placeholder="e.g. 40"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <p class="mt-1.5 text-xs text-slate-400">
                Enter the minimum marks required to pass this set.
            </p>
        </div>

    </div>


    {{-- Weight Percentage --}}
    <div>
        <label for="weight_percentage" class="mb-2 block text-sm font-semibold text-slate-700">
            Weight Percentage
            <span class="text-red-500">*</span>
        </label>

        <div class="relative">
            <input type="number" name="weight_percentage" id="weight_percentage" min="0" max="100"
                step="0.01" value="{{ old('weight_percentage', $examSet->weight_percentage ?? '0.00') }}"
                placeholder="e.g. 25"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 pr-12 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">
                %
            </span>
        </div>

        <p class="mt-1.5 text-xs text-slate-400">
            Enter how much this set contributes to the overall exam result.
        </p>
    </div>


    {{-- Status --}}
    <div>
        <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
            Status
            <span class="text-red-500">*</span>
        </label>

        <select name="status" id="status"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            <option value="draft" {{ old('status', $examSet->status ?? 'draft') == 'draft' ? 'selected' : '' }}>
                Draft
            </option>

            <option value="published" {{ old('status', $examSet->status ?? '') == 'published' ? 'selected' : '' }}>
                Published
            </option>

            <option value="processing" {{ old('status', $examSet->status ?? '') == 'processing' ? 'selected' : '' }}>
                Processing
            </option>

            <option value="completed" {{ old('status', $examSet->status ?? '') == 'completed' ? 'selected' : '' }}>
                Completed
            </option>

            <option value="cancelled" {{ old('status', $examSet->status ?? '') == 'cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>

        </select>

        <p class="mt-1.5 text-xs text-slate-400">
            Select the current status of this exam set.
        </p>
    </div>


    {{-- Question Settings --}}
    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-4">

        <div class="mb-4">
            <h3 class="text-sm font-semibold text-slate-700">
                Question Settings
            </h3>

            <p class="mt-1 text-xs text-slate-400">
                Configure how questions and options should be displayed.
            </p>
        </div>


        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            {{-- Shuffle Questions --}}
            <label
                class="group flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-white p-4 transition hover:border-primary/30 hover:bg-primary/5">

                <div>
                    <p class="text-sm font-medium text-slate-700">
                        Shuffle Questions
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Randomize question order.
                    </p>
                </div>

                <div class="relative">
                    <input type="hidden" name="shuffle_questions" value="0">

                    <input type="checkbox" name="shuffle_questions" value="1" class="peer sr-only"
                        {{ old('shuffle_questions', $examSet->shuffle_questions ?? true) ? 'checked' : '' }}>

                    <div
                        class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/20">
                    </div>

                    <div
                        class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                    </div>
                </div>

            </label>


            {{-- Shuffle Options --}}
            <label
                class="group flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-white p-4 transition hover:border-primary/30 hover:bg-primary/5">

                <div>
                    <p class="text-sm font-medium text-slate-700">
                        Shuffle Options
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Randomize answer option order.
                    </p>
                </div>

                <div class="relative">
                    <input type="hidden" name="shuffle_options" value="0">

                    <input type="checkbox" name="shuffle_options" value="1" class="peer sr-only"
                        {{ old('shuffle_options', $examSet->shuffle_options ?? true) ? 'checked' : '' }}>

                    <div
                        class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/20">
                    </div>

                    <div
                        class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                    </div>
                </div>

            </label>


            {{-- Active Status --}}
            <label
                class="group flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-white p-4 transition hover:border-primary/30 hover:bg-primary/5">

                <div>
                    <p class="text-sm font-medium text-slate-700">
                        Active
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Make this exam set available for students.
                    </p>
                </div>

                <div class="relative">
                    <input type="hidden" name="is_active" value="0">

                    <input type="checkbox" name="is_active" id="is_active" value="1" class="peer sr-only"
                        {{ old('is_active', $examSet->is_active ?? true) ? 'checked' : '' }}>

                    <div
                        class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/20">
                    </div>

                    <div
                        class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                    </div>
                </div>

            </label>




        </div>
    </div>


</div>
