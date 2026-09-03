<div class="space-y-6">

    {{-- Classification --}}
    <div>

        <h3 class="mb-4 text-sm font-semibold text-slate-700">
            Question Classification
        </h3>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            {{-- Course --}}
            <div>

                <label class="mb-2 block text-xs font-semibold
                               text-slate-600">

                    Course

                    <span class="text-red-500">*</span>

                </label>

                <select id="course_id" name="course_id"
                    class="w-full rounded-lg border border-slate-200
                               bg-white px-3 py-2.5 text-sm
                               text-slate-600 outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">

                    <option value="">
                        Select Course
                    </option>

                    {{-- Course options will be added here --}}
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">
                            {{ $course->name }}
                        </option>
                    @endforeach

                </select>

            </div>


            {{-- Module --}}
            <div>

                <label class="mb-2 block text-xs font-semibold
                               text-slate-600">

                    Module

                    <span class="text-red-500">*</span>

                </label>

                <select id="module_id" name="module_id"
                    class="w-full rounded-lg border border-slate-200
                               bg-white px-3 py-2.5 text-sm
                               text-slate-600 outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">

                    <option value="">
                        Select Module
                    </option>

                    {{-- Module options will be added here --}}

                </select>

            </div>


            {{-- Competency unit --}}
            <div>

                <label class="mb-2 block text-xs font-semibold
                               text-slate-600">

                    Competency unit

                    <span class="text-red-500">*</span>

                </label>

                <select id="competency_unit_id" name="competency_unit_id"
                    class="w-full rounded-lg border border-slate-200
                               bg-white px-3 py-2.5 text-sm
                               text-slate-600 outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">

                    <option value="">
                        Select Competency unit
                    </option>

                    {{-- Competency unit options will be added here --}}

                </select>

            </div>
            {{-- Elements --}}
            <div>

                <label class="mb-2 block text-xs font-semibold
                               text-slate-600">

                   Elements

                    <span class="text-red-500">*</span>

                </label>

                <select id="elements" name="elements"
                    class="w-full rounded-lg border border-slate-200
                               bg-white px-3 py-2.5 text-sm
                               text-slate-600 outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">

                    <option value="">
                        Select Element
                    </option>

                    {{-- Competency unit options will be added here --}}

                </select>

            </div>


            {{-- Marks --}}
            <div>

                <label for="marks" class="mb-2 block text-xs font-semibold text-slate-600">

                    Marks

                    <span class="text-red-500">*</span>

                </label>

                <input type="number" id="marks" name="marks" value="2" min="1"
                    placeholder="Enter marks"
                    class="w-full rounded-lg border border-slate-200
                               bg-white px-3 py-2.75 text-sm
                               text-slate-600 outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">

            </div>

        </div>

    </div>


    {{-- Divider --}}
    <div class="border-t border-slate-100"></div>


    {{-- Question --}}
    <div>

        <label for="question" class="mb-2 block text-sm font-semibold
                       text-slate-700">

            Question

            <span class="text-red-500">*</span>

        </label>

        <textarea id="question" name="question" rows="5" placeholder="Write your question here..."
            class="w-full resize-none rounded-lg
                       border border-slate-200 bg-white
                       px-4 py-3 text-sm text-slate-700
                       placeholder:text-slate-400
                       outline-none transition
                       focus:border-primary
                       focus:ring-2 focus:ring-primary/10"></textarea>

    </div>


    {{-- Question Type --}}
    <div>

        <label class="mb-3 block text-sm font-semibold text-slate-700">
            Question Type
        </label>

        <div class="flex flex-wrap gap-3">

            {{-- Single Choice --}}
            <label
                class="flex cursor-pointer items-center gap-2
                           rounded-lg border border-slate-200 bg-white
                           px-4 py-2.5 transition
                           has-checked:border-primary/20
                           has-checked:bg-primary/5">

                <input type="radio" name="question_type" value="single_choice" checked
                    class="accent-primary question-type">

                <span class="text-sm font-medium text-slate-700">
                    Single Choice
                </span>

            </label>


            {{-- Multiple Choice --}}
            <label
                class="flex cursor-pointer items-center gap-2
                           rounded-lg border border-slate-200 bg-white
                           px-4 py-2.5 transition
                           has-checked:border-primary/20
                           has-checked:bg-primary/5">

                <input type="radio" name="question_type" value="multiple_choice" class="accent-primary question-type">

                <span class="text-sm font-medium text-slate-700">
                    Multiple Choice
                </span>

            </label>

        </div>

    </div>


    {{-- Answer Options --}}
    <div>

        <div class="mb-3 flex items-center justify-between">

            <div>

                <h3 class="text-sm font-semibold text-slate-700">
                    Answer Options
                </h3>

                <p class="mt-1 text-xs text-slate-400">
                    Select the correct answer.
                </p>

            </div>

            <span class="text-xs font-medium text-slate-400">
                <span id="option-count">4</span> Options
            </span>

        </div>


        <div id="options-container" class="space-y-3">

            {{-- Option A --}}
            <div class="option-row flex items-center gap-3">

                <span
                    class="option-letter flex h-9 w-9 shrink-0
                               items-center justify-center rounded-lg
                               bg-slate-100 text-sm font-bold text-slate-500">

                    A

                </span>

                <input type="text" name="options[A]" placeholder="Enter option A"
                    class="option-input w-full rounded-lg
                               border border-slate-200 bg-white
                               px-4 py-2.5 text-sm outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">


                <label
                    class="correct-option flex h-9 w-9 shrink-0
                               cursor-pointer items-center justify-center
                               rounded-lg border border-slate-200
                               text-slate-400 transition
                               hover:border-primary
                               hover:bg-primary/5
                               hover:text-primary"
                    title="Mark as correct answer">

                    <input type="radio" name="correct_answer" value="A" class="correct-input sr-only">

                    <i class="bi bi-check-lg"></i>

                </label>


                {{-- Delete --}}
                <button type="button"
                    class="delete-option border border-red-100
                               bg-red-300/20 text-red-300 flex h-9 w-9
                               shrink-0 items-center justify-center
                               rounded-lg transition hover:bg-red-50
                               hover:text-red-500"
                    title="Delete option">

                    <i class="bi bi-trash"></i>

                </button>

            </div>


            {{-- Option B --}}
            <div class="option-row flex items-center gap-3">

                <span
                    class="option-letter flex h-9 w-9 shrink-0
                               items-center justify-center rounded-lg
                               bg-slate-100 text-sm font-bold text-slate-500">

                    B

                </span>

                <input type="text" name="options[B]" placeholder="Enter option B"
                    class="option-input w-full rounded-lg
                               border border-slate-200 bg-white
                               px-4 py-2.5 text-sm outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">


                <label
                    class="correct-option flex h-9 w-9 shrink-0
                               cursor-pointer items-center justify-center
                               rounded-lg border border-slate-200
                               text-slate-400 transition
                               hover:border-primary
                               hover:bg-primary/5
                               hover:text-primary"
                    title="Mark as correct answer">

                    <input type="radio" name="correct_answer" value="B" class="correct-input sr-only">

                    <i class="bi bi-check-lg"></i>

                </label>


                {{-- Delete --}}
                <button type="button"
                    class="delete-option border border-red-100
                               bg-red-300/20 text-red-300 flex h-9 w-9
                               shrink-0 items-center justify-center
                               rounded-lg transition hover:bg-red-50
                               hover:text-red-500"
                    title="Delete option">

                    <i class="bi bi-trash"></i>

                </button>

            </div>


            {{-- Option C --}}
            <div class="option-row flex items-center gap-3">

                <span
                    class="option-letter flex h-9 w-9 shrink-0
                               items-center justify-center rounded-lg
                               bg-slate-100 text-sm font-bold text-slate-500">

                    C

                </span>

                <input type="text" name="options[C]" placeholder="Enter option C"
                    class="option-input w-full rounded-lg
                               border border-slate-200 bg-white
                               px-4 py-2.5 text-sm outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">


                <label
                    class="correct-option flex h-9 w-9 shrink-0
                               cursor-pointer items-center justify-center
                               rounded-lg border border-slate-200
                               text-slate-400 transition
                               hover:border-primary
                               hover:bg-primary/5
                               hover:text-primary"
                    title="Mark as correct answer">

                    <input type="radio" name="correct_answer" value="C" class="correct-input sr-only">

                    <i class="bi bi-check-lg"></i>

                </label>


                {{-- Delete --}}
                <button type="button"
                    class="delete-option border border-red-100
                               bg-red-300/20 text-red-300 flex h-9 w-9
                               shrink-0 items-center justify-center
                               rounded-lg transition hover:bg-red-50
                               hover:text-red-500"
                    title="Delete option">

                    <i class="bi bi-trash"></i>

                </button>

            </div>


            {{-- Option D --}}
            <div class="option-row flex items-center gap-3">

                <span
                    class="option-letter flex h-9 w-9 shrink-0
                               items-center justify-center rounded-lg
                               bg-slate-100 text-sm font-bold text-slate-500">

                    D

                </span>

                <input type="text" name="options[D]" placeholder="Enter option D"
                    class="option-input w-full rounded-lg
                               border border-slate-200 bg-white
                               px-4 py-2.5 text-sm outline-none
                               transition
                               focus:border-primary
                               focus:ring-2 focus:ring-primary/10">


                <label
                    class="correct-option flex h-9 w-9 shrink-0
                               cursor-pointer items-center justify-center
                               rounded-lg border border-slate-200
                               text-slate-400 transition
                               hover:border-primary
                               hover:bg-primary/5
                               hover:text-primary"
                    title="Mark as correct answer">

                    <input type="radio" name="correct_answer" value="D" class="correct-input sr-only">

                    <i class="bi bi-check-lg"></i>

                </label>


                {{-- Delete --}}
                <button type="button"
                    class="delete-option border border-red-100
                               bg-red-300/20 text-red-300 flex h-9 w-9
                               shrink-0 items-center justify-center
                               rounded-lg transition hover:bg-red-50
                               hover:text-red-500"
                    title="Delete option">

                    <i class="bi bi-trash"></i>

                </button>

            </div>

        </div>


        {{-- Add button MUST be outside options-container --}}
        <div class="mt-3">

            <button type="button" id="add-option"
                class="hidden items-center gap-2 rounded-lg
                           border border-dashed border-primary
                           px-4 py-2 text-sm font-medium
                           text-primary transition
                           hover:bg-primary/5">

                <i class="bi bi-plus-lg"></i>

                Add Option

            </button>

        </div>

    </div>


    {{-- Status --}}
    <div>

        <label
            class="flex cursor-pointer items-center
                       justify-between rounded-lg
                       border border-slate-200
                       bg-slate-50/50 px-4 py-3">

            <div>

                <p class="text-sm font-semibold text-slate-700">
                    Active Question
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this question to be used in quizzes.
                </p>

            </div>


            <div class="relative">

                <input type="checkbox" name="is_active" value="1" checked class="peer sr-only">

                <div
                    class="h-6 w-11 rounded-full bg-slate-300
                               transition peer-checked:bg-primary">
                </div>

                <div
                    class="absolute left-1 top-1 h-4 w-4
                               rounded-full bg-white shadow-sm
                               transition peer-checked:translate-x-5">
                </div>

            </div>

        </label>

    </div>

</div>


@push('scripts')
    <script src="{{ asset('/assets/js/dependencyDropdown.js') }}"></script>
@endpush
