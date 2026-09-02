<div class="space-y-5 p-5 sm:p-6">

    {{-- Set Name --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Set Name
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $examSet->name ?? '') }}"
            placeholder="Enter exam set name"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
        >

        @error('name')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>


    {{-- Type + Set Number --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

        <div>
            <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">
                Type
                <span class="text-red-500">*</span>
            </label>

            <select
                name="type"
                id="type"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
                <option value="">Select type</option>

                <option value="mid"
                    @selected(old('type', $examSet->type ?? '') === 'mid')>
                    Mid
                </option>

                <option value="monthly"
                    @selected(old('type', $examSet->type ?? '') === 'monthly')>
                    Monthly
                </option>
            </select>

            @error('type')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="set_number" class="mb-2 block text-sm font-semibold text-slate-700">
                Set Number
                <span class="text-red-500">*</span>
            </label>

            <input
                type="number"
                name="set_number"
                id="set_number"
                min="1"
                max="255"
                value="{{ old('set_number', $examSet->set_number ?? '') }}"
                placeholder="e.g. 1"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >

            @error('set_number')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

    </div>


    {{-- Question Type + Mode --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

        <div>
            <label for="question_type" class="mb-2 block text-sm font-semibold text-slate-700">
                Question Type
                <span class="text-red-500">*</span>
            </label>

            <select
                name="question_type"
                id="question_type"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
                <option value="">Select question type</option>

                <option value="mcq"
                    @selected(old('question_type', $examSet->question_type ?? '') === 'mcq')>
                    MCQ
                </option>

                <option value="evidence"
                    @selected(old('question_type', $examSet->question_type ?? '') === 'evidence')>
                    Evidence
                </option>
            </select>

            @error('question_type')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="mode" class="mb-2 block text-sm font-semibold text-slate-700">
                Mode
                <span class="text-red-500">*</span>
            </label>

            <select
                name="mode"
                id="mode"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
                <option value="">Select mode</option>

                <option value="online"
                    @selected(old('mode', $examSet->mode ?? '') === 'online')>
                    Online
                </option>

                <option value="offline"
                    @selected(old('mode', $examSet->mode ?? '') === 'offline')>
                    Offline
                </option>
            </select>

            @error('mode')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

    </div>


    {{-- Status + Duration --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

        <div>
            <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
                Status
                <span class="text-red-500">*</span>
            </label>

            <select
                name="status"
                id="status"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
                <option value="">Select status</option>

                <option value="draft"
                    @selected(old('status', $examSet->status ?? 'draft') === 'draft')>
                    Draft
                </option>

                <option value="published"
                    @selected(old('status', $examSet->status ?? '') === 'published')>
                    Published
                </option>

                <option value="processing"
                    @selected(old('status', $examSet->status ?? '') === 'processing')>
                    Processing
                </option>

                <option value="completed"
                    @selected(old('status', $examSet->status ?? '') === 'completed')>
                    Completed
                </option>

                <option value="cancelled"
                    @selected(old('status', $examSet->status ?? '') === 'cancelled')>
                    Cancelled
                </option>
            </select>

            @error('status')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="duration_minutes" class="mb-2 block text-sm font-semibold text-slate-700">
                Duration
                <span class="font-normal text-slate-400">(Optional)</span>
            </label>

            <div class="relative">
                <input
                    type="number"
                    name="duration_minutes"
                    id="duration_minutes"
                    min="1"
                    value="{{ old('duration_minutes', $examSet->duration_minutes ?? '') }}"
                    placeholder="Enter duration"
                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 pr-20 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                >

                <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs text-slate-400">
                    Minutes
                </span>
            </div>

            @error('duration_minutes')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

    </div>


    {{-- Marks --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">

        <div>
            <label for="total_marks" class="mb-2 block text-sm font-semibold text-slate-700">
                Total Marks
                <span class="text-red-500">*</span>
            </label>

            <input
                type="number"
                name="total_marks"
                id="total_marks"
                min="0"
                step="0.01"
                value="{{ old('total_marks', $examSet->total_marks ?? '') }}"
                placeholder="e.g. 100"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >

            @error('total_marks')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="pass_marks" class="mb-2 block text-sm font-semibold text-slate-700">
                Pass Marks
                <span class="text-red-500">*</span>
            </label>

            <input
                type="number"
                name="pass_marks"
                id="pass_marks"
                min="0"
                step="0.01"
                value="{{ old('pass_marks', $examSet->pass_marks ?? '') }}"
                placeholder="e.g. 40"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >

            @error('pass_marks')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="weight_percentage" class="mb-2 block text-sm font-semibold text-slate-700">
                Weight
                <span class="text-red-500">*</span>
            </label>

            <div class="relative">
                <input
                    type="number"
                    name="weight_percentage"
                    id="weight_percentage"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('weight_percentage', $examSet->weight_percentage ?? '') }}"
                    placeholder="e.g. 20"
                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 pr-9 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                >

                <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs text-slate-400">
                    %
                </span>
            </div>

            @error('weight_percentage')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

    </div>


    {{-- Settings --}}
    <div class="rounded-lg border border-slate-200 bg-slate-50">

        <div class="border-b border-slate-200 px-4 py-3">
            <h3 class="text-sm font-semibold text-slate-700">
                Settings
            </h3>

            <p class="mt-0.5 text-xs text-slate-400">
                Configure exam set preferences.
            </p>
        </div>


        <div class="divide-y divide-slate-200 px-4">

            {{-- Shuffle Questions --}}
            <div class="flex items-center justify-between gap-4 py-4">

                <div>
                    <p class="text-sm font-semibold text-slate-700">
                        Shuffle Questions
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Randomize question order.
                    </p>
                </div>

                <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                    <input
                        type="checkbox"
                        name="shuffle_questions"
                        value="1"
                        class="peer sr-only"
                        @checked(old('shuffle_questions', $examSet->shuffle_questions ?? true))
                    >

                    <span
                        class="relative h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary
                            after:absolute after:left-[2px] after:top-[2px]
                            after:h-5 after:w-5 after:rounded-full
                            after:bg-white after:shadow-sm
                            after:transition-all
                            peer-checked:after:translate-x-full">
                    </span>
                </label>

            </div>


            {{-- Shuffle Options --}}
            <div class="flex items-center justify-between gap-4 py-4">

                <div>
                    <p class="text-sm font-semibold text-slate-700">
                        Shuffle Options
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Randomize MCQ option order.
                    </p>
                </div>

                <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                    <input
                        type="checkbox"
                        name="shuffle_options"
                        value="1"
                        class="peer sr-only"
                        @checked(old('shuffle_options', $examSet->shuffle_options ?? true))
                    >

                    <span
                        class="relative h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary
                            after:absolute after:left-[2px] after:top-[2px]
                            after:h-5 after:w-5 after:rounded-full
                            after:bg-white after:shadow-sm
                            after:transition-all
                            peer-checked:after:translate-x-full">
                    </span>
                </label>

            </div>


            {{-- Active --}}
            <div class="flex items-center justify-between gap-4 py-4">

                <div>
                    <p class="text-sm font-semibold text-slate-700">
                        Active
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Make this exam set available for use.
                    </p>
                </div>

                <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="peer sr-only"
                        @checked(old('is_active', $examSet->is_active ?? true))
                    >

                    <span
                        class="relative h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary
                            after:absolute after:left-[2px] after:top-[2px]
                            after:h-5 after:w-5 after:rounded-full
                            after:bg-white after:shadow-sm
                            after:transition-all
                            peer-checked:after:translate-x-full">
                    </span>
                </label>

            </div>

        </div>

    </div>

</div>