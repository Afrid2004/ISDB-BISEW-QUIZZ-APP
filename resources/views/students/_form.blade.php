<form action="{{ route('students.store') }}"
    method="POST"
    enctype="multipart/form-data"
    id="manualSection"
    class="hidden p-5 sm:p-6 lg:p-8">


@csrf


{{-- Section Header --}}
<div class="mb-6">

    <div class="flex items-center gap-3">

        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
            <i class="bi bi-person-plus text-lg"></i>
        </div>

        <div>

            <h2 class="text-base font-semibold text-slate-800">
                Add Student Manually
            </h2>

            <p class="mt-0.5 text-xs text-slate-400">
                Create a student by entering the information below.
            </p>

        </div>

    </div>

</div>


{{-- Student Form Fields --}}
<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

    {{-- Round --}}
    <div>

        <label for="round_id"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Round <span class="text-red-500">*</span>
        </label>

        <select name="round_id"
            id="round_id"
            required
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

            <option value="">
                Select Round
            </option>

            @foreach ($rounds as $round)
                <option value="{{ $round->id }}"
                    {{ old('round_id') == $round->id ? 'selected' : '' }}>
                    Round {{ $round->round_number }}
                </option>
            @endforeach

        </select>

        @error('round_id')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Batch --}}
    <div>

        <label for="batch_id"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Batch <span class="text-red-500">*</span>
        </label>

        <select name="batch_id"
            id="batch_id"
            required
            disabled
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

            <option value="">
                Select Round First
            </option>

        </select>

        @error('batch_id')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Student Name --}}
    <div>

        <label for="name"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Student Name <span class="text-red-500">*</span>
        </label>

        <input type="text"
            name="name"
            id="name"
            value="{{ old('name') }}"
            placeholder="Enter student name"
            required
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

        @error('name')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Email --}}
    <div>

        <label for="email"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Email <span class="text-red-500">*</span>
        </label>

        <input type="email"
            name="email"
            id="email"
            value="{{ old('email') }}"
            placeholder="example@email.com"
            required
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

        @error('email')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Phone --}}
    <div>

        <label for="phone"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Phone <span class="text-red-500">*</span>
        </label>

        <input type="text"
            name="phone"
            id="phone"
            value="{{ old('phone') }}"
            placeholder="01XXXXXXXXX"
            required
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

        @error('phone')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Date of Birth --}}
    <div>

        <label for="dob"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Date of Birth <span class="text-red-500">*</span>
        </label>

        <input type="date"
            name="dob"
            id="dob"
            value="{{ old('dob') }}"
            required
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

        @error('dob')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Status --}}
    <div>

        <label for="status"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Status <span class="text-red-500">*</span>
        </label>

        <select name="status"
            id="status"
            required
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

            <option value="active"
                {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="inactive"
                {{ old('status') == 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

        @error('status')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Photo --}}
    <div class="md:col-span-2">

        <label for="photo"
            class="mb-1.5 block text-sm font-semibold text-slate-700">
            Student Photo
        </label>

        <input type="file"
            name="photo"
            id="photo"
            accept=".jpg,.jpeg,.png,.webp"
            class="block w-full rounded-lg border border-slate-200 bg-white text-sm text-slate-500
            file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-2.5
            file:text-sm file:font-semibold file:text-slate-600
            hover:file:bg-slate-200">

        <p class="mt-1.5 text-xs text-slate-400">
            Supported formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
        </p>

        @error('photo')
            <p class="mt-1 text-xs text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>

</div>


{{-- Form Actions --}}
<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

    <a href="{{ route('students.index') }}"
        class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

        <i class="bi bi-x-lg"></i>
        Cancel

    </a>


    <button type="submit"
        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/20">

        <i class="bi bi-check-lg"></i>
        Create Student

    </button>

</div>


</form>