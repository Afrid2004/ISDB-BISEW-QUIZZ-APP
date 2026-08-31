<aside id="sidebar"
    class="
        fixed inset-y-0 left-0 z-50
        flex w-64 flex-col
        border-r border-slate-200
        bg-white
        transform -translate-x-full
        transition-transform duration-300 ease-in-out
        lg:translate-x-0
    ">

    {{-- Logo --}}
    <div class="flex h-20 shrink-0 items-center border-b border-slate-100 px-5">

        <div class="flex items-center gap-3">

            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('/assets/images/logo.png') }}" alt="isdb logo" class="w-70">
            </a>

        </div>

    </div>


    {{-- Navigation --}}
    <div class="sidebar-scroll flex-1 overflow-y-auto px-3 py-5">

        <p class="mb-3 px-3 text-[10px] font-semibold uppercase
                  tracking-wider text-slate-400">
            Administration
        </p>


        <nav class="space-y-1">

            {{-- Dashboard --}}
            <x-sidebar.link route="dashboard" icon="bi-speedometer2">
                Dashboard
            </x-sidebar.link>

            {{-- Rounds Dropdown --}}
            <x-sidebar.dropdown title="Rounds" route="rounds.*" icon="bi-layers">
                <x-sidebar.sub-link route="rounds.index">
                    All Rounds
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="rounds.create">
                    Create Round
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="rounds.deleted">
                    Deleted Rounds
                </x-sidebar.sub-link>
            </x-sidebar.dropdown>

            {{-- Course Dropdown --}}
            <x-sidebar.dropdown title="Courses" route="courses.*" icon="bi-book">
                <x-sidebar.sub-link route="courses.index">
                    All Courses
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="courses.create">
                    Create Course
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="courses.deleted">
                    Deleted Courses
                </x-sidebar.sub-link>
            </x-sidebar.dropdown>

            {{-- Modules Dropdown --}}
            <x-sidebar.dropdown title="Modules" route="modules.*" icon="bi-collection">
                <x-sidebar.sub-link route="modules.index">
                    All Modules
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="modules.create">
                    Create Module
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="modules.deleted">
                    Deleted Modules
                </x-sidebar.sub-link>
            </x-sidebar.dropdown>

            {{-- Competency Units Dropdown --}}
            <x-sidebar.dropdown title="Competency Units" route="competency-units.*" icon="bi-folder2-open">

                <x-sidebar.sub-link route="competency-units.index">
                    All Competency Units
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="competency-units.create">
                    Create Competency Unit
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="competency-units.deleted">
                    Deleted Competency Units
                </x-sidebar.sub-link>

            </x-sidebar.dropdown>

            {{-- Elements Dropdown --}}
            <x-sidebar.dropdown title="Elements" route="elements.*" icon="bi-puzzle">
                <x-sidebar.sub-link route="elements.index">
                    All Elements
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="elements.create">
                    Create Element
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="elements.deleted">
                    Deleted Elements
                </x-sidebar.sub-link>
            </x-sidebar.dropdown>

            {{-- Questions Dropdown --}}
            <x-sidebar.dropdown title="Qustions" route="questions.*" icon="bi-layers">
                <x-sidebar.sub-link route="questions.index">
                    All Questions
                </x-sidebar.sub-link>
                <x-sidebar.sub-link route="questions.create">
                    Create Question
                </x-sidebar.sub-link>
            </x-sidebar.dropdown>

            {{-- Exams Dropdown --}}
            <x-sidebar.dropdown title="Exams" route="exams.*" icon="bi-file-earmark-text">
                <x-sidebar.sub-link route="exams.index">
                    All Exams
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="exams.create">
                    Create Exam
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="exams.deleted">
                    Deleted Exams
                </x-sidebar.sub-link>
            </x-sidebar.dropdown>

            {{-- Exam Sets Dropdown --}}
            <x-sidebar.dropdown title="Exam Sets" route="exam-sets.*" icon="bi-collection">
                <x-sidebar.sub-link route="exam-sets.index">
                    All Exam Sets
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="exam-sets.create">
                    Create Exam Set
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="exam-sets.deleted">
                    Deleted Exam Sets
                </x-sidebar.sub-link>

            </x-sidebar.dropdown>

            {{-- Training Centers Dropdown --}}
            <x-sidebar.dropdown title="Training Centers" route="training-centers.*" icon="bi-building">

                <x-sidebar.sub-link route="training-centers.index">
                    All Training Centers
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="training-centers.create">
                    Create Training Center
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="training-centers.deleted">
                    Deleted Training Centers
                </x-sidebar.sub-link>

            </x-sidebar.dropdown>


            {{-- Shifts Dropdown --}}
            <x-sidebar.dropdown title="Shifts" route="shifts.*" icon="bi-clock-history">

                <x-sidebar.sub-link route="shifts.index">
                    All Shifts
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="shifts.create">
                    Create Shift
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="shifts.deleted">
                    Deleted Shifts
                </x-sidebar.sub-link>

            </x-sidebar.dropdown>

            {{-- Batches Dropdown --}}
            <x-sidebar.dropdown title="Batches" route="batches.*" icon="bi-people">

                <x-sidebar.sub-link route="batches.index">
                    All Batches
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="batches.create">
                    Create Batch
                </x-sidebar.sub-link>

                <x-sidebar.sub-link route="batches.deleted">
                    Deleted Batches
                </x-sidebar.sub-link>

            </x-sidebar.dropdown>


            {{-- Question Bank --}}
            <a href="#"
                class="flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm text-slate-500
                       transition hover:bg-primary/10
                       hover:text-primary">

                <i class="bi bi-question-circle text-base"></i>

                <span>Question Bank</span>

            </a>


            {{-- CSV Import --}}
            <a href="#"
                class="flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm text-slate-500
                       transition hover:bg-primary/10
                       hover:text-primary">

                <i class="bi bi-upload text-base"></i>

                <span>CSV Import</span>

            </a>


            {{-- Quizzes --}}
            <a href="#"
                class="flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm text-slate-500
                       transition hover:bg-primary/10
                       hover:text-primary">

                <i class="bi bi-journal-check text-base"></i>

                <span>Quizzes</span>

            </a>


            {{-- Results --}}
            <a href="#"
                class="flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm text-slate-500
                       transition hover:bg-primary/10
                       hover:text-primary">

                <i class="bi bi-bar-chart text-base"></i>

                <span>Results</span>

            </a>


            {{-- Feedback --}}
            <a href="#"
                class="flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm text-slate-500
                       transition hover:bg-primary/10
                       hover:text-primary">

                <i class="bi bi-chat-left-text text-base"></i>

                <span>Feedback</span>

            </a>

        </nav>


        {{-- Bottom Navigation --}}
        <div class="mt-6 border-t border-slate-100 pt-5">

            <nav class="space-y-1">

                {{-- Settings --}}
                <a href="#"
                    class="flex items-center gap-3 rounded-lg
                           px-3 py-2.5 text-sm text-slate-500
                           transition hover:bg-primary/10
                           hover:text-primary">

                    <i class="bi bi-gear"></i>

                    <span>Settings</span>

                </a>


                {{-- Help Center --}}
                <a href="#"
                    class="flex items-center gap-3 rounded-lg
                           px-3 py-2.5 text-sm text-slate-500
                           transition hover:bg-primary/10
                           hover:text-primary">

                    <i class="bi bi-question-circle"></i>

                    <span>Help center</span>

                </a>

            </nav>

        </div>

    </div>


    {{-- User --}}
    <div class="border-t border-slate-100 p-4">

        <div class="flex items-center gap-3">

            {{-- User Avatar --}}
            <div
                class="flex h-9 w-9 shrink-0 items-center
                        justify-center rounded-full
                        bg-primary/10 text-xs font-semibold
                        text-primary">

                AR

            </div>


            {{-- User Information --}}
            <div class="min-w-0 flex-1">

                <p class="truncate text-sm font-semibold text-slate-700">
                    Admin
                </p>

                <p class="truncate text-xs text-slate-400">
                    Administrator
                </p>

            </div>


            {{-- Logout --}}
            <button class="text-slate-400 transition
                       hover:text-primary">

                <i class="bi bi-box-arrow-right"></i>

            </button>

        </div>

    </div>

</aside>
