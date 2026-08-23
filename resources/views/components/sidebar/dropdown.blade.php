@php
    $isActive = request()->routeIs($route);
@endphp

<div class="sidebar-dropdown">

    {{-- Parent --}}
    <button type="button"
        class="
            sidebar-dropdown-toggle
            flex w-full items-center gap-3
            rounded-lg
            px-3 py-2.5
            text-sm
            transition-all
            cursor-pointer
            {{ $isActive
                ? 'bg-primary/10 font-medium text-primary'
                : 'text-slate-500 hover:bg-primary/10 hover:text-primary' }}
        ">

        <i class="bi {{ $icon }} text-base"></i>

        <span>
            {{ $title }}
        </span>

        <i
            class="
                bi bi-chevron-down
                ml-auto text-xs
                transition-transform duration-200
                {{ $isActive ? 'rotate-180' : '' }}
            "></i>

    </button>


    {{-- Children --}}
    <div
        class="transition-all ease-in-out sidebar-dropdown-menu border-l-2 border-gray-300/50 pl-2
        {{ $isActive ? 'max-h-96 opacity-100 mt-2' : 'max-h-0 opacity-0 mt-0' }}">
        <div class="space-y-1.5">

            {{ $slot }}

        </div>
    </div>

</div>
