<x-admin-layout>

    {{-- Page Header --}}
    <div class="mb-8">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Announcement Details
                </h1>

                <p class="mt-1 text-gray-500">
                    View the complete announcement information.
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


    {{-- Announcement --}}
    <div class="bg-white rounded-xl shadow-sm
                border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-start gap-4">

                <div
                    class="w-12 h-12 rounded-xl
                           bg-[#D8F3DC]
                           flex items-center justify-center
                           text-2xl flex-shrink-0"
                >
                    📢
                </div>

                <div class="flex-1">

                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $announcement->title }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Published:
                        {{ $announcement->published_at
                            ? $announcement->published_at->format('F d, Y h:i A')
                            : '—'
                        }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Content --}}
        <div class="p-6 space-y-6">

            {{-- Message --}}
            <div>

                <h3 class="text-sm font-semibold text-gray-500 uppercase">
                    Message
                </h3>

                <div
                    class="mt-2 p-4 rounded-lg
                           bg-gray-50
                           text-gray-700
                           whitespace-pre-line"
                >
                    {{ $announcement->message }}
                </div>

            </div>


            {{-- Audience --}}
            <div>

                <h3 class="text-sm font-semibold text-gray-500 uppercase">
                    Audience
                </h3>

                <div class="mt-2">

                    @if ($announcement->audience === 'all')

                        <span
                            class="inline-flex px-3 py-1 rounded-full
                                   bg-green-100 text-green-700
                                   text-sm font-semibold"
                        >
                            All Residents
                        </span>

                    @elseif ($announcement->audience === 'barangay')

                        <span
                            class="inline-flex px-3 py-1 rounded-full
                                   bg-blue-100 text-blue-700
                                   text-sm font-semibold"
                        >
                            Barangay:
                            {{ $announcement->barangay?->name ?? '—' }}
                        </span>

                    @elseif ($announcement->audience === 'zone')

                        <span
                            class="inline-flex px-3 py-1 rounded-full
                                   bg-purple-100 text-purple-700
                                   text-sm font-semibold"
                        >
                            {{ $announcement->barangay?->name ?? '—' }}
                            •
                            {{ $announcement->zone ?? '—' }}
                        </span>

                    @endif

                </div>

            </div>


            {{-- Barangay --}}
            <div>

                <h3 class="text-sm font-semibold text-gray-500 uppercase">
                    Barangay
                </h3>

                <p class="mt-2 text-gray-800">
                    {{ $announcement->barangay?->name ?? 'All Barangays' }}
                </p>

            </div>


            {{-- Zone --}}
            <div>

                <h3 class="text-sm font-semibold text-gray-500 uppercase">
                    Zone
                </h3>

                <p class="mt-2 text-gray-800">
                    {{ $announcement->zone ?? 'All Zones' }}
                </p>

            </div>

        </div>


        {{-- Actions --}}
        <div
            class="px-6 py-5
                   border-t border-gray-100
                   flex justify-end gap-3"
        >

            <a
                href="{{ route('admin.announcements.index') }}"
                class="px-5 py-2.5 rounded-lg
                       bg-gray-100 text-gray-700
                       font-medium
                       hover:bg-gray-200
                       transition"
            >
                Back
            </a>

            <a
                href="{{ route('admin.announcements.edit', $announcement) }}"
                class="px-5 py-2.5 rounded-lg
                       bg-[#2D6A4F]
                       text-white font-medium
                       hover:bg-[#1B4332]
                       transition"
            >
                Edit Announcement
            </a>

        </div>

    </div>

</x-admin-layout>