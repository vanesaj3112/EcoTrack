<x-layouts.resident>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-8">

        <div class="flex items-center gap-3">

            <div
                class="flex h-11 w-11 items-center justify-center
                       rounded-xl bg-eco-light"
            >

                <i
                    data-lucide="layout-dashboard"
                    class="h-6 w-6 text-eco-green"
                    stroke-width="2"
                ></i>

            </div>


            <div>

                <h1 class="text-2xl font-bold text-eco-dark">
                    Resident Dashboard
                </h1>

                <p class="mt-1 text-gray-500">
                    Welcome, {{ auth()->user()->name }}.
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- BASIC INFORMATION --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


        {{-- ACCOUNT STATUS --}}
        <div
            class="rounded-xl border border-gray-100
                   bg-white p-6 shadow-sm"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-lg bg-eco-light"
                >

                    <i
                        data-lucide="user-check"
                        class="h-5 w-5 text-eco-green"
                        stroke-width="2"
                    ></i>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Account Status
                    </p>


                    @if (auth()->user()->status === 'approved')

                        <p class="mt-1 text-xl font-bold text-eco-green">
                            Approved
                        </p>

                    @elseif (auth()->user()->status === 'rejected')

                        <p class="mt-1 text-xl font-bold text-red-600">
                            Rejected
                        </p>

                    @else

                        <p class="mt-1 text-xl font-bold text-yellow-600">
                            Pending
                        </p>

                    @endif

                </div>

            </div>

        </div>


        {{-- MY BARANGAY --}}
        <div
            class="rounded-xl border border-gray-100
                   bg-white p-6 shadow-sm"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-lg bg-eco-light"
                >

                    <i
                        data-lucide="map-pin"
                        class="h-5 w-5 text-eco-green"
                        stroke-width="2"
                    ></i>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        My Barangay
                    </p>

                    <p class="mt-1 text-xl font-bold text-eco-dark">
                        {{ auth()->user()->barangay?->name ?? 'Not assigned' }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Zone: {{ auth()->user()->zone ?? 'Not assigned' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TODAY & NEXT COLLECTION --}}
    {{-- ========================================================= --}}

    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">


        {{-- ========================================================= --}}
        {{-- TODAY'S COLLECTION --}}
        {{-- ========================================================= --}}

        <div
            class="rounded-xl border border-gray-100
                   bg-white p-6 shadow-sm"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-lg bg-eco-light"
                >

                    <i
                        data-lucide="truck"
                        class="h-5 w-5 text-eco-green"
                        stroke-width="2"
                    ></i>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Today's Collection
                    </p>


                    @if ($todaySchedule)

                        <p class="mt-1 text-lg font-bold text-eco-dark">
                            {{ $todaySchedule->day_of_week }}
                        </p>

                    @else

                        <p class="mt-1 text-lg font-bold text-gray-500">
                            No Collection Today
                        </p>

                    @endif

                </div>

            </div>


            @if ($todaySchedule)

                {{-- Today's instance is already filtered by the controller --}}
                @php
                    $todayInstance = $todaySchedule->instances->first();
                @endphp


                <div class="mt-5 rounded-lg bg-[#F5F7F6] p-4">

                    <p class="font-semibold text-eco-dark">
                        {{ $todaySchedule->barangay?->name ?? 'N/A' }}
                        • Zone {{ $todaySchedule->zone }}
                    </p>


                    <p class="mt-1 text-sm text-gray-500">

                        {{ \Carbon\Carbon::parse($todaySchedule->start_time)->format('g:i A') }}

                        -

                        {{ \Carbon\Carbon::parse($todaySchedule->end_time)->format('g:i A') }}

                    </p>


                    {{-- ================================================= --}}
                    {{-- ACTUAL COLLECTION STATUS --}}
                    {{-- ================================================= --}}

                    <div class="mt-4">


                        {{-- COMPLETED --}}
                        @if ($todayInstance?->status === 'completed')

                            <span
                                class="inline-flex items-center gap-2
                                       rounded-full
                                       bg-eco-light
                                       px-4 py-2
                                       text-sm font-semibold
                                       text-eco-dark"
                            >

                                <i
                                    data-lucide="circle-check"
                                    class="h-4 w-4 text-eco-green"
                                    stroke-width="2"
                                ></i>

                                Completed

                            </span>


                        {{-- IN PROGRESS --}}
                        @elseif ($todayInstance?->status === 'in_progress')

                            <span
                                class="inline-flex items-center gap-2
                                       rounded-full
                                       bg-yellow-100
                                       px-4 py-2
                                       text-sm font-semibold
                                       text-yellow-700"
                            >

                                <i
                                    data-lucide="truck"
                                    class="h-4 w-4"
                                    stroke-width="2"
                                ></i>

                                On the Way

                            </span>


                        {{-- CANCELLED --}}
                        @elseif ($todayInstance?->status === 'cancelled')

                            <span
                                class="inline-flex items-center gap-2
                                       rounded-full
                                       bg-red-50
                                       px-4 py-2
                                       text-sm font-semibold
                                       text-red-600"
                            >

                                <i
                                    data-lucide="circle-x"
                                    class="h-4 w-4"
                                    stroke-width="2"
                                ></i>

                                Cancelled

                            </span>


                        {{-- SCHEDULED --}}
                        @else

                            <span
                                class="inline-flex items-center gap-2
                                       rounded-full
                                       bg-gray-100
                                       px-4 py-2
                                       text-sm font-semibold
                                       text-gray-600"
                            >

                                <i
                                    data-lucide="clock-3"
                                    class="h-4 w-4"
                                    stroke-width="2"
                                ></i>

                                Scheduled

                            </span>

                        @endif

                    </div>

                </div>


            @else

                <div
                    class="mt-4 flex items-center gap-2
                           text-sm text-gray-500"
                >

                    <i
                        data-lucide="calendar-off"
                        class="h-4 w-4"
                        stroke-width="2"
                    ></i>

                    <span>
                        Today is a rest day. No collection is scheduled.
                    </span>

                </div>

            @endif

        </div>


        {{-- ========================================================= --}}
        {{-- NEXT COLLECTION --}}
        {{-- ========================================================= --}}

        <div
            class="rounded-xl border border-gray-100
                   bg-white p-6 shadow-sm"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-lg bg-eco-light"
                >

                    <i
                        data-lucide="calendar-days"
                        class="h-5 w-5 text-eco-green"
                        stroke-width="2"
                    ></i>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Next Collection
                    </p>


                    @if ($nextSchedule)

                        <p class="mt-1 text-lg font-bold text-eco-dark">
                            {{ $nextSchedule->collection_day->format('l') }}
                        </p>

                    @else

                        <p class="mt-1 text-lg font-bold text-gray-500">
                            No Upcoming Collection
                        </p>

                    @endif

                </div>

            </div>


            @if ($nextSchedule)

                <div class="mt-5 rounded-lg bg-[#F5F7F6] p-4">

                    <p class="font-semibold text-eco-dark">
                        {{ $nextSchedule->collection_day->format('F d, Y') }}
                    </p>


                    <p class="mt-1 text-sm text-gray-700">
                        {{ $nextSchedule->barangay?->name ?? 'N/A' }}
                        • Zone {{ $nextSchedule->zone }}
                    </p>


                    <p class="mt-1 text-sm text-gray-500">

                        {{ \Carbon\Carbon::parse($nextSchedule->start_time)->format('g:i A') }}

                        -

                        {{ \Carbon\Carbon::parse($nextSchedule->end_time)->format('g:i A') }}

                    </p>


                    {{-- NEXT COLLECTION IS ALWAYS SCHEDULED --}}
                    <div class="mt-4">

                        <span
                            class="inline-flex items-center gap-2
                                   rounded-full
                                   bg-gray-100
                                   px-4 py-2
                                   text-sm font-semibold
                                   text-gray-600"
                        >

                            <i
                                data-lucide="calendar-clock"
                                class="h-4 w-4"
                                stroke-width="2"
                            ></i>

                            Scheduled

                        </span>

                    </div>

                </div>


            @else

                <div
                    class="mt-4 flex items-center gap-2
                           text-sm text-gray-500"
                >

                    <i
                        data-lucide="calendar-x"
                        class="h-4 w-4"
                        stroke-width="2"
                    ></i>

                    <span>
                        No upcoming collection this week.
                    </span>

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ANNOUNCEMENTS --}}
    {{-- ========================================================= --}}

    <div
        class="mt-6 rounded-xl border border-gray-100
               bg-white p-6 shadow-sm"
    >

        <div class="flex items-center gap-3">

            <div
                class="flex h-10 w-10 items-center justify-center
                       rounded-lg bg-eco-light"
            >

                <i
                    data-lucide="megaphone"
                    class="h-5 w-5 text-eco-green"
                    stroke-width="2"
                ></i>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Announcements
                </p>

                <p class="mt-1 text-lg font-semibold text-gray-800">
                    No announcements yet
                </p>

            </div>

        </div>

    </div>


</x-layouts.resident>