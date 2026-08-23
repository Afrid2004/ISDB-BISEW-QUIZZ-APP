@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
    class="
        flex items-center gap-3
        rounded-lg
        px-3 py-2.5
        text-sm
        transition

        {{ $isActive
            ? 'bg-primary/10 font-medium text-primary'
            : 'text-slate-500 hover:bg-primary/10 hover:text-primary' }}
    ">
    <i class="bi {{ $icon }} text-base"></i>

    <span>
        {{ $slot }}
    </span>

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
