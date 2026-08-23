@if ($paginator->hasPages())

    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- ========================= --}}
        {{-- Mobile Pagination --}}
        {{-- ========================= --}}
        <div class="flex items-center justify-between gap-3 sm:hidden">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())

                <span
                    class="inline-flex items-center gap-2 rounded-lg
                           border border-slate-200 bg-slate-50
                           px-4 py-2 text-xs font-medium
                           text-slate-400 cursor-not-allowed">

                    <i class="bi bi-chevron-left text-[10px]"></i>

                    Previous

                </span>

            @else

                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    rel="prev"
                    class="inline-flex items-center gap-2 rounded-lg
                           border border-slate-200 bg-white
                           px-4 py-2 text-xs font-semibold
                           text-slate-600 transition
                           hover:border-primary/30
                           hover:bg-primary/10
                           hover:text-primary
                           focus:outline-none
                           focus:ring-2
                           focus:ring-primary/20"
                >

                    <i class="bi bi-chevron-left text-[10px]"></i>

                    Previous

                </a>

            @endif


            {{-- Page Information --}}
            <span class="text-xs font-medium text-slate-500">

                Page
                <span class="font-semibold text-slate-700">
                    {{ $paginator->currentPage() }}
                </span>
                of
                <span class="font-semibold text-slate-700">
                    {{ $paginator->lastPage() }}
                </span>

            </span>


            {{-- Next --}}
            @if ($paginator->hasMorePages())

                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    class="inline-flex items-center gap-2 rounded-lg
                           border border-slate-200 bg-white
                           px-4 py-2 text-xs font-semibold
                           text-slate-600 transition
                           hover:border-primary/30
                           hover:bg-primary/10
                           hover:text-primary
                           focus:outline-none
                           focus:ring-2
                           focus:ring-primary/20"
                >

                    Next

                    <i class="bi bi-chevron-right text-[10px]"></i>

                </a>

            @else

                <span
                    class="inline-flex items-center gap-2 rounded-lg
                           border border-slate-200 bg-slate-50
                           px-4 py-2 text-xs font-medium
                           text-slate-400 cursor-not-allowed"
                >

                    Next

                    <i class="bi bi-chevron-right text-[10px]"></i>

                </span>

            @endif

        </div>


        {{-- ========================= --}}
        {{-- Desktop Pagination --}}
        {{-- ========================= --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between sm:gap-5">


            {{-- Results --}}
            <div>

                <p class="text-xs text-slate-500">

                    Showing

                    @if ($paginator->firstItem())

                        <span class="font-semibold text-slate-700">
                            {{ $paginator->firstItem() }}
                        </span>

                        <span class="px-0.5 text-slate-400">
                            –
                        </span>

                        <span class="font-semibold text-slate-700">
                            {{ $paginator->lastItem() }}
                        </span>

                    @else

                        <span class="font-semibold text-slate-700">
                            0
                        </span>

                    @endif

                    of

                    <span class="font-semibold text-slate-700">
                        {{ $paginator->total() }}
                    </span>

                    results

                </p>

            </div>


            {{-- Pagination Buttons --}}
            <div>

                <div class="flex items-center gap-1.5">


                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())

                        <span
                            class="inline-flex h-9 w-9 items-center
                                   justify-center rounded-lg
                                   border border-slate-200
                                   bg-slate-50 text-slate-300
                                   cursor-not-allowed"
                            aria-disabled="true"
                        >

                            <i class="bi bi-chevron-left text-xs"></i>

                        </span>

                    @else

                        <a
                            href="{{ $paginator->previousPageUrl() }}"
                            rel="prev"
                            aria-label="{{ __('pagination.previous') }}"
                            class="inline-flex h-9 w-9 items-center
                                   justify-center rounded-lg
                                   border border-slate-200
                                   bg-white text-slate-500
                                   transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-primary/20"
                        >

                            <i class="bi bi-chevron-left text-xs"></i>

                        </a>

                    @endif


                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)

                        {{-- Three Dots --}}
                        @if (is_string($element))

                            <span
                                class="inline-flex h-9 min-w-9
                                       items-center justify-center
                                       rounded-lg px-2
                                       text-xs font-medium
                                       text-slate-400"
                            >

                                {{ $element }}

                            </span>

                        @endif


                        {{-- Page Links --}}
                        @if (is_array($element))

                            @foreach ($element as $page => $url)

                                @if ($page == $paginator->currentPage())

                                    {{-- Active Page --}}
                                    <span
                                        aria-current="page"
                                        class="inline-flex h-9 min-w-9
                                               items-center justify-center
                                               rounded-lg bg-primary
                                               px-2.5 text-xs font-semibold
                                               text-white shadow-sm"
                                    >

                                        {{ $page }}

                                    </span>

                                @else

                                    {{-- Normal Page --}}
                                    <a
                                        href="{{ $url }}"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                        class="inline-flex h-9 min-w-9
                                               items-center justify-center
                                               rounded-lg border
                                               border-slate-200
                                               bg-white px-2.5
                                               text-xs font-medium
                                               text-slate-600 transition
                                               hover:border-primary/30
                                               hover:bg-primary/10
                                               hover:text-primary
                                               focus:outline-none
                                               focus:ring-2
                                               focus:ring-primary/20"
                                    >

                                        {{ $page }}

                                    </a>

                                @endif

                            @endforeach

                        @endif

                    @endforeach


                    {{-- Next --}}
                    @if ($paginator->hasMorePages())

                        <a
                            href="{{ $paginator->nextPageUrl() }}"
                            rel="next"
                            aria-label="{{ __('pagination.next') }}"
                            class="inline-flex h-9 w-9 items-center
                                   justify-center rounded-lg
                                   border border-slate-200
                                   bg-white text-slate-500
                                   transition
                                   hover:border-primary/30
                                   hover:bg-primary/10
                                   hover:text-primary
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-primary/20"
                        >

                            <i class="bi bi-chevron-right text-xs"></i>

                        </a>

                    @else

                        <span
                            class="inline-flex h-9 w-9 items-center
                                   justify-center rounded-lg
                                   border border-slate-200
                                   bg-slate-50 text-slate-300
                                   cursor-not-allowed"
                            aria-disabled="true"
                        >

                            <i class="bi bi-chevron-right text-xs"></i>

                        </span>

                    @endif

                </div>

            </div>

        </div>

    </nav>

@endif