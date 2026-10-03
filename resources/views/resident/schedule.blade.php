<x-layouts.resident>

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-[#1B4332]">
            Collection Schedule
        </h1>

        <p class="mt-1 text-gray-500">
            Your assigned barangay garbage collection schedule.
        </p>

    </div>


    {{-- Resident Collection Area --}}
    <div class="bg-[#D8F3DC] rounded-xl p-5 mb-6">

        <p class="text-sm text-[#1B4332]">
            Your collection area
        </p>

        <div class="mt-2 flex flex-wrap gap-x-6 gap-y-1">

            <p class="font-semibold text-[#1B4332]">
                Barangay:
                {{ auth()->user()->barangay?->name ?? '—' }}
            </p>

            <p class="font-semibold text-[#1B4332]">
                Zone:
                {{ auth()->user()->zone ?? '—' }}
            </p>

        </div>

    </div>


    {{-- Schedule List --}}
    <div class="space-y-4">

        @forelse ($schedules as $schedule)

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                    {{-- Schedule Information --}}
                    <div>

                        <div class="flex items-center gap-3">

                            <div
                                class="w-12 h-12 rounded-xl
                                       bg-[#D8F3DC]
                                       flex items-center justify-center
                                       text-2xl"
                            >
                                🚛
                            </div>

                            <div>

                                <h2 class="text-lg font-bold text-[#1B4332]">
                                    Garbage Collection
                                </h2>

                                <p class="text-sm text-gray-500">
                                    {{ $schedule->barangay?->name ?? '—' }}
                                    •
                                    {{ $schedule->zone }}
                                </p>

                            </div>

                        </div>


                        {{-- Collection Date --}}
                        <div class="mt-5">

                            <p class="text-sm text-gray-500">
                                Collection Date
                            </p>

                            <p class="mt-1 text-xl font-bold text-gray-800">

                                {{ \Carbon\Carbon::parse($schedule->collection_date)->format('F d, Y') }}

                            </p>

                        </div>

                    </div>


                    {{-- Time and Status --}}
                    <div class="md:text-right">

                        <p class="text-sm text-gray-500">
                            Collection Time
                        </p>

                        <p class="mt-1 text-lg font-semibold text-[#2D6A4F]">

                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}

                            -

                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}

                        </p>

                        <span
                            class="inline-flex mt-3 px-3 py-1
                                   rounded-full
                                   bg-green-100
                                   text-green-700
                                   text-xs font-semibold"
                        >
                            Scheduled
                        </span>

                    </div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-10 text-center">

                <div
                    class="mx-auto w-16 h-16 rounded-2xl
                           bg-[#D8F3DC]
                           flex items-center justify-center
                           text-3xl"
                >
                    📅
                </div>

                <h2 class="mt-4 text-xl font-semibold text-gray-800">
                    No upcoming collection schedule
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    There are currently no scheduled garbage collections
                    for your barangay and zone.
                </p>

            </div>

        @endforelse

    </div>

</x-layouts.resident>