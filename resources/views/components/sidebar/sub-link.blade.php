@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
    class="
        flex items-center gap-3
        rounded-lg
        px-3 py-2.5
        text-[13px]
        transition

        {{ $isActive
            ? 'bg-primary/10 font-medium text-primary'
            : 'text-slate-500 hover:bg-primary/10 hover:text-primary' }}
    ">
    {{ $slot }}

    @if ($isActive)
        <span
            class="
                ml-auto
                h-1.5 w-1.5
                rounded-full
                bg-primary
            "></span>
    @endif
</a>
