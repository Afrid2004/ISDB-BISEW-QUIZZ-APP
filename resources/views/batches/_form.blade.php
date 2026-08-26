<div class="space-y-6">


    {{-- Relationships Dropdowns --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        {{-- Round --}}
        <div>

            <label for="round_id" class="mb-2 block text-sm font-semibold text-slate-700">
                Round <span class="text-red-500">*</span>
            </label>


            <select name="round_id" id="round_id"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('round_id') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror">

                <option value="">Select Round</option>

                @foreach ($rounds as $round)
                    <option value="{{ $round->id }}" {{ old('round_id') == $round->id ? 'selected' : '' }}>
                        Round {{ $round->round_number }}
                    </option>
                @endforeach

            </select>


            @error('round_id')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror

        </div>


        {{-- Training Center --}}
        <div>

            <label for="training_center_id" class="mb-2 block text-sm font-semibold text-slate-700">
                Training Center <span class="text-red-500">*</span>
            </label>


            <select name="training_center_id" id="training_center_id"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('training_center_id') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror">

                <option value="">Select Center</option>

                @foreach ($trainingCenters as $center)
                    <option value="{{ $center->id }}"
                        {{ old('training_center_id') == $center->id ? 'selected' : '' }}>
                        {{ $center->name }}
                    </option>
                @endforeach

            </select>


            @error('training_center_id')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror

        </div>


        {{-- Shift --}}
        <div>

            <label for="shift_id" class="mb-2 block text-sm font-semibold text-slate-700">
                Shift <span class="text-red-500">*</span>
            </label>


            <select name="shift_id" id="shift_id"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('shift_id') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror">

                <option value="">Select Shift</option>

                @foreach ($shifts as $shift)
                    <option value="{{ $shift->id }}" {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                        {{ $shift->name }}
                    </option>
                @endforeach

            </select>


            @error('shift_id')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror

        </div>

    </div>


    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Batch Number --}}
        <div>

            <label for="batch_number" class="mb-2 block text-sm font-semibold text-slate-700">

                Batch Number

                <span class="text-red-500">*</span>

            </label>


            <input type="text" name="batch_number" id="batch_number" maxlength="50"
                value="{{ old('batch_number') }}" placeholder="e.g. B-2024-01"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('batch_number') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror">


            @error('batch_number')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <p class="mt-1.5 text-xs text-slate-400">
                Enter a unique identifier for this batch.
            </p>

        </div>


        {{-- Max Students --}}
        <div>

            <label for="max_students" class="mb-2 block text-sm font-semibold text-slate-700">

                Max Students

            </label>


            <input type="number" name="max_students" id="max_students" min="1"
                value="{{ old('max_students', 50) }}"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('max_students') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror">


            @error('max_students')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <p class="mt-1.5 text-xs text-slate-400">
                Maximum number of students allowed.
            </p>

        </div>

    </div>


    {{-- Name --}}
    <div>

        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

            Batch Name

            <span class="text-red-500">*</span>

        </label>


        <input type="text" name="name" id="name" maxlength="100" value="{{ old('name') }}"
            placeholder="e.g. IT Batch 2024 - Morning Shift"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('name') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror">


        @error('name')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror

    </div>


    {{-- Description --}}
    <div>

        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">

            Description

            <span class="font-normal text-slate-400">(Optional)</span>

        </label>


        <textarea name="description" id="description" rows="4" placeholder="Enter a short description about this batch..."
            class="w-full resize-none rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 @error('description') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror">{{ old('description') }}</textarea>


        @error('description')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror

    </div>


    {{-- Active Status --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>


        <label
            class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3 transition hover:bg-slate-50">

            <div>

                <p class="text-sm font-medium text-slate-700">
                    Active Batch
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Allow this batch to be used for enrollment.
                </p>

            </div>


            <div class="relative">

                <input type="checkbox" name="is_active" value="1" class="peer sr-only"
                    {{ old('is_active', true) ? 'checked' : '' }}>


                <div
                    class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-primary peer-focus:ring-2 peer-focus:ring-primary/30">
                </div>


                <div
                    class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5">
                </div>

            </div>

        </label>

    </div>

</div>
