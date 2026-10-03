<x-admin-layout>

    {{-- Page Header --}}
    <div class="mb-8">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Announcements
                </h1>

                <p class="mt-1 text-gray-500">
                    Manage announcements for EcoTrack residents.
                </p>
            </div>

            <a
                href="#create-announcement"
                class="px-4 py-2 rounded-lg
                       bg-[#2D6A4F]
                       text-white font-medium
                       hover:bg-[#1B4332]
                       transition"
            >
                + New Announcement
            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="mb-6 px-5 py-4 rounded-xl
                    bg-green-50 border border-green-200
                    text-green-700">

            {{ session('success') }}

        </div>

    @endif


    {{-- Validation Errors --}}
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


    {{-- Create Announcement Form --}}
    <div
        id="create-announcement"
        class="bg-white rounded-xl shadow-sm
               border border-gray-100 overflow-hidden mb-8"
    >

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                Create Announcement
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Publish an announcement for EcoTrack residents.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('admin.announcements.store') }}"
            class="p-6 space-y-6"
        >

            @csrf


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
                    value="{{ old('title') }}"
                    placeholder="Example: Garbage Collection Schedule Update"
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
                    rows="5"
                    placeholder="Write your announcement here..."
                    required
                    class="w-full rounded-lg border-gray-300
                           focus:border-[#2D6A4F]
                           focus:ring-[#2D6A4F]"
                >{{ old('message') }}</textarea>

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

                    <option value="all">
                        All Residents
                    </option>

                    <option value="barangay">
                        Specific Barangay
                    </option>

                    <option value="zone">
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
                            {{ old('brgy_id') == $barangay->id ? 'selected' : '' }}
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
                    value="{{ old('zone') }}"
                    placeholder="Example: Zone 1"
                    class="w-full rounded-lg border-gray-300
                           focus:border-[#2D6A4F]
                           focus:ring-[#2D6A4F]"
                >

            </div>


            {{-- Submit --}}
            <div class="flex justify-end">

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg
                           bg-[#2D6A4F]
                           text-white font-medium
                           hover:bg-[#1B4332]
                           transition"
                >
                    Publish Announcement
                </button>

            </div>

        </form>

    </div>


    {{-- Published Announcements --}}
    <div class="bg-white rounded-xl shadow-sm
                border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                Published Announcements
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Announcements published by the LGU will appear here.
            </p>

        </div>


        <div class="p-6">

            @forelse ($announcements as $announcement)

                <div
                    class="border border-gray-200
                           rounded-xl p-5 mb-4
                           last:mb-0"
                >

                    <div class="flex flex-col lg:flex-row
                                lg:items-start lg:justify-between gap-5">


                        {{-- Announcement Details --}}
                        <div class="flex-1">

                            <div class="flex items-start gap-3">

                                <div
                                    class="w-11 h-11 rounded-lg
                                           bg-[#D8F3DC]
                                           flex items-center justify-center
                                           text-xl flex-shrink-0"
                                >
                                    📢
                                </div>


                                <div>

                                    <h3 class="font-semibold text-gray-800">
                                        {{ $announcement->title }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-2">
                                        {{ $announcement->message }}
                                    </p>

                                </div>

                            </div>


                            {{-- Audience --}}
                            <div class="mt-4 flex flex-wrap gap-2">

                                @if ($announcement->audience === 'all')

                                    <span
                                        class="px-3 py-1 rounded-full
                                               bg-green-100 text-green-700
                                               text-xs font-semibold"
                                    >
                                        All Residents
                                    </span>

                                @elseif ($announcement->audience === 'barangay')

                                    <span
                                        class="px-3 py-1 rounded-full
                                               bg-blue-100 text-blue-700
                                               text-xs font-semibold"
                                    >
                                        Barangay:
                                        {{ $announcement->barangay?->name ?? '—' }}
                                    </span>

                                @elseif ($announcement->audience === 'zone')

                                    <span
                                        class="px-3 py-1 rounded-full
                                               bg-purple-100 text-purple-700
                                               text-xs font-semibold"
                                    >
                                        {{ $announcement->barangay?->name ?? '—' }}
                                        •
                                        {{ $announcement->zone }}
                                    </span>

                                @endif

                            </div>


                            {{-- Published Date --}}
                            <p class="text-xs text-gray-400 mt-3">

                                Published:

                                {{ $announcement->published_at
                                    ? $announcement->published_at->format('F d, Y h:i A')
                                    : '—'
                                }}

                            </p>

                        </div>


                        {{-- Actions --}}
                        <div class="flex flex-wrap gap-2">

                            <a
                                href="{{ route('admin.announcements.show', $announcement) }}"
                                class="px-4 py-2 rounded-lg
                                       bg-gray-100 text-gray-700
                                       text-sm font-medium
                                       hover:bg-gray-200 transition"
                            >
                                View
                            </a>


                            <a
                                href="{{ route('admin.announcements.edit', $announcement) }}"
                                class="px-4 py-2 rounded-lg
                                       bg-[#D8F3DC] text-[#1B4332]
                                       text-sm font-medium
                                       hover:bg-[#2D6A4F]
                                       hover:text-white transition"
                            >
                                Edit
                            </a>


                            <form
                                method="POST"
                                action="{{ route('admin.announcements.destroy', $announcement) }}"
                                onsubmit="return confirm('Are you sure you want to delete this announcement?');"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="px-4 py-2 rounded-lg
                                           bg-red-50 text-red-600
                                           text-sm font-medium
                                           hover:bg-red-600
                                           hover:text-white transition"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="py-14 text-center">

                    <div
                        class="mx-auto w-16 h-16 rounded-full
                               bg-[#D8F3DC]
                               flex items-center justify-center"
                    >

                        <span class="text-2xl">
                            📢
                        </span>

                    </div>


                    <h3 class="mt-5 text-lg font-semibold text-gray-800">
                        No announcements yet
                    </h3>


                    <p class="mt-2 text-sm text-gray-500">
                        Announcements created by the LGU will appear here.
                    </p>


                    <a
                        href="#create-announcement"
                        class="inline-block mt-5 px-4 py-2 rounded-lg
                               bg-[#2D6A4F]
                               text-white text-sm font-medium
                               hover:bg-[#1B4332]
                               transition"
                    >
                        + Create First Announcement
                    </a>

                </div>

            @endforelse

        </div>

    </div>

</x-admin-layout>