<x-layouts.resident>

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-[#1B4332]">
            Report a Concern
        </h1>

        <p class="mt-1 text-gray-500">
            Tell the LGU about a garbage collection problem.
        </p>

    </div>


    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">

            <p class="font-semibold text-red-700 mb-2">
                Please fix the following:
            </p>

            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('resident.concerns.store') }}"
        enctype="multipart/form-data"
    >

        @csrf


        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">


            {{-- Category --}}
            <div class="mb-5">

                <label
                    for="category"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Concern Category
                </label>

                <select
                    id="category"
                    name="category"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3
                           bg-white
                           focus:border-[#2D6A4F]
                           focus:ring-2
                           focus:ring-[#B7E4C7]
                           focus:outline-none"
                >

                    <option value="">
                        Select concern category
                    </option>

                    <option value="Missed Garbage Collection">
                        Missed Garbage Collection
                    </option>

                    <option value="Garbage Not Collected">
                        Garbage Not Collected
                    </option>

                    <option value="Overflowing Garbage">
                        Overflowing Garbage
                    </option>

                    <option value="Illegal Dumping">
                        Illegal Dumping
                    </option>

                    <option value="Collection Schedule Problem">
                        Collection Schedule Problem
                    </option>

                    <option value="Collector Concern">
                        Collector Concern
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>


            {{-- Subject --}}
            <div class="mb-5">

                <label
                    for="subject"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Subject
                </label>

                <input
                    id="subject"
                    name="subject"
                    type="text"
                    value="{{ old('subject') }}"
                    required
                    maxlength="255"
                    placeholder="Example: Garbage was not collected today"
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3
                           focus:border-[#2D6A4F]
                           focus:ring-2
                           focus:ring-[#B7E4C7]
                           focus:outline-none"
                >

            </div>


            {{-- Description --}}
            <div class="mb-5">

                <label
                    for="description"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    required
                    maxlength="5000"
                    placeholder="Describe what happened..."
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3
                           resize-y
                           focus:border-[#2D6A4F]
                           focus:ring-2
                           focus:ring-[#B7E4C7]
                           focus:outline-none"
                >{{ old('description') }}</textarea>

            </div>


            {{-- Photo --}}
            <div class="mb-6">

                <label
                    for="photo"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Supporting Photo
                    <span class="font-normal text-gray-400">
                        (Optional)
                    </span>
                </label>

                <input
                    id="photo"
                    name="photo"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full rounded-xl border border-gray-300
                           bg-white
                           px-4 py-3
                           text-sm"
                >

                <p class="mt-2 text-xs text-gray-500">
                    JPG, JPEG, PNG, or WEBP. Maximum 2MB.
                </p>

            </div>


            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">

                <a
                    href="{{ route('resident.concerns.index') }}"
                    class="inline-flex items-center justify-center
                           rounded-xl
                           border border-gray-300
                           px-5 py-3
                           font-semibold
                           text-gray-700
                           hover:bg-gray-50
                           transition"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center
                           rounded-xl
                           bg-[#2D6A4F]
                           px-6 py-3
                           font-semibold
                           text-white
                           hover:bg-[#1B4332]
                           transition"
                >
                    Submit Concern
                </button>

            </div>

        </div>

    </form>

</x-layouts.resident>