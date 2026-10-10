<x-admin-layout>

    <div class="mb-8">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Edit Announcement
                </h1>

                <p class="mt-1 text-gray-500">
                    Update announcement information.
                </p>
            </div>

            <a
                href="{{ route('admin.announcements.index') }}"
                class="px-4 py-2 rounded-lg
                       bg-gray-100 text-gray-700
                       font-medium
                       hover:bg-gray-200
                       transition"
            >
                ← Back to Announcements
            </a>

        </div>

    </div>


    @if ($errors->any())

        <div class="mb-6 px-5 py-4 rounded-xl
                    bg-red-50 border border-red-200
                    text-red-700">

            <p class="font-semibold mb-2">
                Please fix the following:
            </p>

            <ul class="list-disc list-inside text-sm space-y-1">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white rounded-xl shadow-sm
                border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                Announcement Details
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Modify the announcement information below.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('admin.announcements.update', $announcement) }}"
            class="p-6 space-y-6"
        >

            @csrf
            @method('PUT')


            {{-- Title --}}
            <div>

                <label
                    for="title"
                    class="block text-sm font-medium text-gray-700 mb-2"
                >
                    Announcement Title
                </label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $announcement->title) }}"
                    required
                    class="w-full rounded-lg border-gray-300
                           focus:border-[#2D6A4F]
                           focus:ring-[#2D6A4F]"
                >

            </div>


            {{-- Message --}}
            <div>

                <label
                    for="message"
                    class="block text-sm font-medium text-gray-700 mb-2"
                >
                    Message
                </label>

                <textarea
                    id="message"
                    name="message"
                    rows="6"
                    required
                    class="w-full rounded-lg border-gray-300
                           focus:border-[#2D6A4F]
                           focus:ring-[#2D6A4F]"
                >{{ old('message', $announcement->message) }}</textarea>

            </div>


            {{-- Audience --}}
            <div>

                <label
                    for="audience"
                    class="block text-sm font-medium text-gray-700 mb-2"
                >
                    Audience
                </label>

                <select
                    id="audience"
                    name="audience"
                    required
                    class="w-full rounded-lg border-gray-300
                           focus:border-[#2D6A4F]
                           focus:ring-[#2D6A4F]"
                >

                    <option
                        value="all"
                        {{ old('audience', $announcement->audience) === 'all' ? 'selected' : '' }}
                    >
                        All Residents
                    </option>

                    <option
                        value="barangay"
                        {{ old('audience', $announcement->audience) === 'barangay' ? 'selected' : '' }}
                    >
                        Specific Barangay
                    </option>

                    <option
                        value="zone"
                        {{ old('audience', $announcement->audience) === 'zone' ? 'selected' : '' }}
                    >
                        Specific Zone
                    </option>

                </select>

            </div>


            {{-- Barangay --}}
            <div>

                <label
                    for="brgy_id"
                    class="block text-sm font-medium text-gray-700 mb-2"
                >
                    Barangay
                </label>

                <select
                    id="brgy_id"
                    name="brgy_id"
                    class="w-full rounded-lg border-gray-300
                           focus:border-[#2D6A4F]
                           focus:ring-[#2D6A4F]"
                >

                    <option value="">
                        Select Barangay
                    </option>

                    @foreach ($barangays as $barangay)

                        <option
                            value="{{ $barangay->id }}"
                            {{ old('brgy_id', $announcement->brgy_id) == $barangay->id ? 'selected' : '' }}
                        >
                            {{ $barangay->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Zone --}}
            <div>

                <label
                    for="zone"
                    class="block text-sm font-medium text-gray-700 mb-2"
                >
                    Zone
                </label>

                <input
                    id="zone"
                    type="text"
                    name="zone"
                    value="{{ old('zone', $announcement->zone) }}"
                    placeholder="Example: Zone 1"
                    class="w-full rounded-lg border-gray-300
                           focus:border-[#2D6A4F]
                           focus:ring-[#2D6A4F]"
                >

            </div>


            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3">

                <a
                    href="{{ route('admin.announcements.index') }}"
                    class="px-5 py-2.5 rounded-lg
                           bg-gray-100 text-gray-700
                           font-medium
                           hover:bg-gray-200
                           transition"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg
                           bg-[#2D6A4F]
                           text-white font-medium
                           hover:bg-[#1B4332]
                           transition"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</x-admin-layout>