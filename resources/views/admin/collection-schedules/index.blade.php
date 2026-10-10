<x-admin-layout>

    <div class="space-y-8">

        {{-- HEADER --}}
        <div>
            <p class="text-sm font-semibold text-[#2D6A4F]">
                EcoTrack Collection Management
            </p>

            <h1 class="mt-1 text-3xl font-bold text-[#1B4332]">
                Collection Schedules
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Select a barangay to manage its weekly garbage collection schedule.
            </p>
        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div
                class="rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4 text-sm font-medium text-[#1B4332]"
            >
                {{ session('success') }}
            </div>

        @endif


        {{-- BARANGAY CARDS --}}
        @if ($barangays->count())

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($barangays as $barangay)

                    <a
                        href="{{ route('admin.collection-schedules.show', $barangay) }}"
                        class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-[#B7E4C7] hover:shadow-md"
                    >

                        {{-- ICON --}}
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#D8F3DC] text-[#1B4332]"
                        >

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"
                                />
                            </svg>

                        </div>


                        {{-- BARANGAY NAME --}}
                        <div class="mt-5">

                            <h2
                                class="text-xl font-bold text-[#1B4332] group-hover:text-[#2D6A4F]"
                            >
                                {{ $barangay->name }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Manage collection schedule
                            </p>

                        </div>


                        {{-- FOOTER --}}
                        <div
                            class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4"
                        >

                            <span class="text-xs text-gray-500">
                                {{ $barangay->users_count }} registered residents
                            </span>

                            <span
                                class="text-sm font-semibold text-[#2D6A4F]"
                            >
                                View Schedule →
                            </span>

                        </div>

                    </a>

                @endforeach

            </div>

        @else

            {{-- EMPTY STATE --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm"
            >

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#D8F3DC]"
                >

                    <svg
                        class="h-8 w-8 text-[#2D6A4F]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"
                        />
                    </svg>

                </div>

                <h3 class="mt-4 text-lg font-bold text-[#1B4332]">
                    No Barangays Found
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Add a barangay first before creating collection schedules.
                </p>

            </div>

        @endif

    </div>

</x-admin-layout>