<x-layouts.resident>

    {{-- Page Header --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-[#1B4332]">
            Announcements
        </h1>

        <p class="mt-1 text-gray-500">
            View announcements and important updates from the LGU.
        </p>

    </div>


    {{-- Announcement List --}}
    <div class="space-y-5">

        @forelse ($announcements as $announcement)

            <div
                class="bg-white rounded-2xl
                       border border-gray-200
                       shadow-sm p-6"
            >

                {{-- Announcement Header --}}
                <div class="flex items-start gap-4">

                    <div
                        class="w-12 h-12 rounded-xl
                               bg-[#D8F3DC]
                               flex items-center justify-center
                               text-2xl flex-shrink-0"
                    >
                        📢
                    </div>


                    <div class="flex-1 min-w-0">

                        <h2 class="text-xl font-bold text-[#1B4332]">
                            {{ $announcement->title }}
                        </h2>

                        <p class="mt-1 text-xs text-gray-400">

                            Published:

                            {{ $announcement->published_at
                                ? $announcement->published_at->format('F d, Y • h:i A')
                                : '—'
                            }}

                        </p>

                    </div>

                </div>


                {{-- Message --}}
                <div class="mt-5">

                    <p class="text-gray-600 leading-7 whitespace-pre-line">
                        {{ $announcement->message }}
                    </p>

                </div>


                {{-- Audience --}}
                <div class="mt-5 pt-4 border-t border-gray-100">

                    @if ($announcement->audience === 'all')

                        <span
                            class="inline-flex items-center
                                   px-3 py-1 rounded-full
                                   bg-green-100 text-green-700
                                   text-xs font-semibold"
                        >
                            📢 All Residents
                        </span>

                    @elseif ($announcement->audience === 'barangay')

                        <span
                            class="inline-flex items-center
                                   px-3 py-1 rounded-full
                                   bg-blue-100 text-blue-700
                                   text-xs font-semibold"
                        >
                            🏘️
                            {{ $announcement->barangay?->name ?? 'Your Barangay' }}
                        </span>

                    @elseif ($announcement->audience === 'zone')

                        <span
                            class="inline-flex items-center
                                   px-3 py-1 rounded-full
                                   bg-purple-100 text-purple-700
                                   text-xs font-semibold"
                        >
                            📍
                            {{ $announcement->barangay?->name ?? 'Your Barangay' }}
                            -
                            {{ $announcement->zone }}
                        </span>

                    @endif

                </div>

            </div>

        @empty

            {{-- Empty State --}}
            <div
                class="bg-white rounded-2xl
                       border border-gray-200
                       shadow-sm p-8 text-center"
            >

                <div
                    class="mx-auto w-16 h-16 rounded-2xl
                           bg-[#D8F3DC]
                           flex items-center justify-center
                           text-3xl"
                >
                    📢
                </div>


                <h2 class="mt-4 text-xl font-semibold text-gray-800">
                    No announcements yet
                </h2>


                <p class="mt-2 text-sm text-gray-500">
                    New LGU announcements will appear here.
                </p>

            </div>

        @endforelse

    </div>

</x-layouts.resident>