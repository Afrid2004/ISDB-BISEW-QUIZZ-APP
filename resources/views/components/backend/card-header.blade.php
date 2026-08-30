<div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-4 sm:flex-row
            sm:items-center sm:justify-between sm:px-6">
<div>

    <h2 class="text-base font-semibold text-slate-800">
        {{ $title }}
    </h2>

    <p class="mt-0.5 text-xs text-slate-400">
        {{ $count }}
        {{ $count != 1 ? $plural : $singular }}
    </p>

</div>


{{-- Search --}}
<form method="GET"
    action="{{ $action }}"
    class="w-full sm:w-auto">

    <div class="relative sm:w-80">

        <i class="bi bi-search absolute left-3 top-1/2
                  -translate-y-1/2 text-slate-400"></i>

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="{{ $placeholder }}"
            class="w-full rounded-lg border border-slate-200
                   bg-white py-2.5 pl-10 pr-4 text-sm
                   text-slate-700 placeholder:text-slate-400
                   outline-none transition
                   focus:border-primary
                   focus:ring-2 focus:ring-primary/20"
        >

    </div>

</form>

</div>
