<header class="sticky top-0 z-30 border-b border-slate-200 bg-white">

    <div class="flex h-20 items-center justify-between px-4 sm:px-6">

        {{-- Left --}}
        <div class="flex items-center gap-3">

            {{-- Mobile Menu --}}
            <button
                id="sidebarToggle"
                type="button"
                class="
                    flex h-10 w-10 items-center justify-center
                    rounded-lg border border-slate-200
                    text-slate-600
                    transition
                    hover:border-primary/30
                    hover:bg-primary/10
                    hover:text-primary
                    focus:outline-none
                    focus:ring-2
                    focus:ring-primary/30
                    lg:hidden
                "
            >
                <i class="bi bi-list text-xl"></i>
            </button>


            {{-- Page Title --}}
            <div>

                <h2 class="text-base font-semibold text-slate-800 sm:text-lg">
                    Dashboard
                </h2>

            </div>

        </div>


        {{-- Right --}}
        <div class="flex items-center gap-2 sm:gap-4">

            {{-- Academic Year --}}
            <button
                type="button"
                class="
                    hidden items-center gap-2
                    rounded-lg border border-slate-200
                    px-3 py-2
                    text-xs font-medium text-slate-600
                    transition
                    hover:border-primary/30
                    hover:bg-primary/10
                    hover:text-primary
                    focus:outline-none
                    focus:ring-2
                    focus:ring-primary/30
                    sm:flex
                "
            >

                <span>Academic year 2024–25</span>

                <i class="bi bi-chevron-down text-[10px]"></i>

            </button>


            {{-- Mobile Year --}}
            <button
                type="button"
                class="
                    flex h-9 w-9 items-center justify-center
                    rounded-lg border border-slate-200
                    text-slate-500
                    transition
                    hover:border-primary/30
                    hover:bg-primary/10
                    hover:text-primary
                    focus:outline-none
                    focus:ring-2
                    focus:ring-primary/30
                    sm:hidden
                "
            >
                <i class="bi bi-calendar3"></i>
            </button>


            {{-- Profile --}}
            <div class="relative">

                {{-- Avatar Button --}}
                <button
                    id="profileToggle"
                    type="button"
                    class="
                        flex h-9 w-9 shrink-0
                        items-center justify-center
                        rounded-full
                        bg-primary/10
                        text-xs font-semibold
                        text-primary
                        transition
                        hover:ring-4
                        hover:ring-primary/10
                        focus:outline-none
                        focus:ring-4
                        focus:ring-primary/10
                    "
                >
                    AR
                </button>


                {{-- Profile Popup --}}
                <div
                    id="profilePopup"
                    class="
                        absolute right-0 top-12 z-50
                        hidden w-72
                        overflow-hidden
                        rounded-xl
                        border border-slate-200
                        bg-white
                        shadow-lg
                    "
                >

                    {{-- Profile Header --}}
                    <div class="border-b border-slate-100 px-4 py-4">

                        <div class="flex items-center gap-3">

                            {{-- Avatar --}}
                            <div
                                class="
                                    flex h-11 w-11 shrink-0
                                    items-center justify-center
                                    rounded-full
                                    bg-primary/10
                                    text-sm font-bold
                                    text-primary
                                "
                            >
                                AR
                            </div>


                            {{-- User Info --}}
                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-slate-800">
                                    Amina Rahman
                                </p>

                                <p class="truncate text-xs text-slate-400">
                                    amina@example.com
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Information --}}
                    <div class="px-4 py-3">

                        {{-- Role --}}
                        <div class="flex items-center gap-3 py-2">

                            <div
                                class="
                                    flex h-8 w-8
                                    items-center justify-center
                                    rounded-lg
                                    bg-primary/10
                                    text-primary
                                "
                            >
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>

                                <p class="text-[11px] text-slate-400">
                                    Role
                                </p>

                                <p class="text-xs font-semibold text-slate-700">
                                    Administrator
                                </p>

                            </div>

                        </div>



                        {{-- Status --}}
                        <div class="flex items-center gap-3 py-2">

                            <div
                                class="
                                    flex h-8 w-8
                                    items-center justify-center
                                    rounded-lg
                                    bg-emerald-50
                                    text-emerald-600
                                "
                            >
                                <i class="bi bi-person-check"></i>
                            </div>

                            <div>

                                <p class="text-[11px] text-slate-400">
                                    Status
                                </p>

                                <p class="text-xs font-semibold text-emerald-600">
                                    Active
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="border-t border-slate-100 p-3">

                        <button
                            type="button"
                            class="
                                flex w-full items-center gap-3
                                rounded-lg px-3 py-2.5
                                text-sm font-medium
                                text-slate-600
                                transition
                                hover:bg-primary/5
                                hover:text-primary
                            "
                        >

                            <i class="bi bi-person-circle"></i>

                            <span>My Profile</span>

                            <i class="bi bi-chevron-right ml-auto text-[10px]"></i>

                        </button>


                        {{-- Logout --}}
                        <button
                            type="button"
                            class="
                                flex w-full items-center gap-3
                                rounded-lg px-3 py-2.5
                                text-sm font-medium
                                text-red-500
                                transition
                                hover:bg-red-50
                            "
                        >

                            <i class="bi bi-box-arrow-right"></i>

                            <span>Logout</span>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</header>


{{-- Profile Popup Script --}}
@push('scripts')
    <script src="{{ asset('/assets/js/profilePopup.js') }}"></script>
@endpush