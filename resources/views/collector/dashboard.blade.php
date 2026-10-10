<x-collector-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-xl font-semibold text-[#1B4332]">
                    Garbage Collector Dashboard
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Welcome, {{ auth()->user()->name }}
                </p>
            </div>

            <div
                class="rounded-full bg-[#D8F3DC] px-4 py-2 text-sm font-semibold text-[#1B4332]"
            >
                Garbage Collector
            </div>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- WELCOME --}}
            <div
                class="mb-8 rounded-2xl bg-[#1B4332] p-6 text-white shadow-sm"
            >

                <p class="text-sm text-[#B7E4C7]">
                    EcoTrack Collection Management
                </p>

                <h1 class="mt-2 text-2xl font-bold">
                    Garbage Collection Dashboard
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-[#D8F3DC]">
                    View your collection routes for today and check your
                    upcoming assigned garbage collection schedules.
                </p>

            </div>


            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))

                <div
                    class="mb-6 rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4 text-sm font-medium text-[#1B4332]"
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- ERROR MESSAGE --}}
            @if (session('error'))

                <div
                    class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700"
                >
                    {{ session('error') }}
                </div>

            @endif

            
{{-- INCOMING COLLECTION REQUESTS --}}
<div class="mb-8 rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-gray-200 px-6 py-5">
        <h3 class="text-lg font-bold text-[#1B4332]">
            Incoming Collection Requests
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Review requests sent directly by residents.
        </p>
    </div>

    @if ($incomingRequests->isNotEmpty())
        <div class="divide-y divide-gray-100">
            @foreach ($incomingRequests as $collectionRequest)
                <div class="p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <p class="font-semibold text-[#1B4332]">
                                {{ $collectionRequest->resident?->name ?? 'Resident' }}
                            </p>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ $collectionRequest->barangay?->name ?? 'Barangay' }}
                                · Zone {{ $collectionRequest->zone }}
                            </p>

                            <p class="mt-2 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($collectionRequest->requested_date)->format('F j, Y') }}
                                ·
                                {{ \Carbon\Carbon::parse($collectionRequest->preferred_start_time)->format('g:i A') }}
                                –
                                {{ \Carbon\Carbon::parse($collectionRequest->preferred_end_time)->format('g:i A') }}
                            </p>

                            @if ($collectionRequest->notes)
                                <p class="mt-2 text-sm text-gray-500">
                                    Notes: {{ $collectionRequest->notes }}
                                </p>
                            @endif

                            <span class="mt-3 inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                Pending
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <form method="POST"
                                  action="{{ route('collector.collection-requests.accept', $collectionRequest) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="rounded-lg bg-[#2D6A4F] px-4 py-2 text-sm font-semibold text-white hover:bg-[#1B4332]"
                                        onclick="return confirm('Accept this collection request?')">
                                    Accept
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('collector.collection-requests.reject', $collectionRequest) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50"
                                        onclick="return confirm('Reject this collection request?')">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="px-6 py-10 text-center">
            <h4 class="font-semibold text-[#1B4332]">
                No Pending Requests
            </h4>
            <p class="mt-2 text-sm text-gray-500">
                Resident collection requests assigned to you will appear here.
            </p>
        </div>
    @endif
</div>



{{-- Accepted Collection Requests --}}
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">
        Accepted Collection Requests
    </h2>

    @if ($acceptedRequests->isEmpty())
        <p class="text-gray-500">
            Wala pang accepted collection requests.
        </p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Resident
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Contact
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Barangay
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Zone
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Date
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Preferred Time
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Notes
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($acceptedRequests as $request)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800">
                                <div class="font-medium">
                                    {{ $request->resident->name ?? 'N/A' }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $request->resident->email ?? '' }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $request->resident->address ?? '' }}
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $request->resident->mobile ?? $request->resident->phone ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $request->barangay->name ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $request->zone }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $request->requested_date?->format('M d, Y') ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ \Illuminate\Support\Carbon::parse($request->preferred_start_time)->format('g:i A') }}
                                –
                                {{ \Illuminate\Support\Carbon::parse($request->preferred_end_time)->format('g:i A') }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $request->notes ?: 'No notes' }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                    Accepted
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>




            {{-- ===================================================== --}}
            {{-- TODAY'S COLLECTION --}}
            {{-- ===================================================== --}}

            <div
                class="rounded-2xl border border-gray-200 bg-white shadow-sm"
            >

                <div
                    class="border-b border-gray-200 px-6 py-5"
                >

                    <h3 class="text-lg font-bold text-[#1B4332]">
                        Today's Collection
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Collection schedules assigned to you for today.
                    </p>

                </div>


                @if ($schedules->count())

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-[#F5F7F6]">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Barangay
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Zone
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Day
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Time
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Status
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach ($schedules as $schedule)

                                    @php

                                        $instance = $schedule->instances()
                                            ->whereDate(
                                                'collection_date',
                                                today()
                                            )
                                            ->first();

                                    @endphp


                                    <tr class="hover:bg-[#F5F7F6]">


                                        {{-- BARANGAY --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <div
                                                class="font-semibold text-[#1B4332]"
                                            >
                                                {{ $schedule->barangay?->name ?? 'N/A' }}
                                            </div>

                                        </td>


                                        {{-- ZONE --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <span
                                                class="rounded-full bg-[#D8F3DC] px-3 py-1 text-xs font-semibold text-[#1B4332]"
                                            >
                                                {{ $schedule->zone }}
                                            </span>

                                        </td>


                                        {{-- DAY --}}
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-700"
                                        >
                                            {{ $schedule->day_of_week }}
                                        </td>


                                        {{-- TIME --}}
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-700"
                                        >

                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}

                                            -

                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            @if ($instance?->status === 'completed')

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-[#D8F3DC] px-3 py-1 text-xs font-semibold text-[#1B4332]"
                                                >
                                                    <span>🟢</span>
                                                    Completed
                                                </span>


                                            @elseif ($instance?->status === 'in_progress')

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-[#FFF4CC] px-3 py-1 text-xs font-semibold text-[#7A5A00]"
                                                >
                                                    <span>🟡</span>
                                                    On the Way
                                                </span>


                                            @elseif ($instance?->status === 'cancelled')

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600"
                                                >
                                                    <span>🔴</span>
                                                    Cancelled
                                                </span>


                                            @else

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-[#FFF4CC] px-3 py-1 text-xs font-semibold text-[#7A5A00]"
                                                >
                                                    <span>🟡</span>
                                                    Scheduled
                                                </span>

                                            @endif

                                        </td>


                                        {{-- ACTION --}}
                                        <td class="whitespace-nowrap px-6 py-4">


                                            {{-- NOT STARTED --}}
                                            @if (! $instance || $instance->status === 'scheduled')

                                                <details class="group relative inline-block">

                                                    <summary
                                                        class="flex cursor-pointer list-none items-center gap-2 rounded-lg bg-[#2D6A4F] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#1B4332]"
                                                    >

                                                        <span>
                                                            On the Way
                                                        </span>

                                                        <svg
                                                            class="h-4 w-4 transition group-open:rotate-180"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 9l-7 7-7-7"
                                                            />
                                                        </svg>

                                                    </summary>


                                                    <div
                                                        class="absolute right-0 z-30 mt-2 w-48 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg"
                                                    >

                                                        {{-- ON THE WAY --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'collector.collection.start',
                                                                $schedule
                                                            ) }}"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium text-[#2D6A4F] transition hover:bg-[#D8F3DC]"
                                                            >
                                                                <span>🟡</span>

                                                                <span>
                                                                    On the Way
                                                                </span>
                                                            </button>

                                                        </form>


                                                        {{-- CANCELLED --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'collector.collection.cancel',
                                                                $schedule
                                                            ) }}"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50"
                                                            >
                                                                <span>🔴</span>

                                                                <span>
                                                                    Cancelled
                                                                </span>
                                                            </button>

                                                        </form>


                                                        {{-- COMPLETED --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'collector.collection.complete',
                                                                $schedule
                                                            ) }}"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium text-[#1B4332] transition hover:bg-[#D8F3DC]"
                                                            >
                                                                <span>🟢</span>

                                                                <span>
                                                                    Completed
                                                                </span>
                                                            </button>

                                                        </form>

                                                    </div>

                                                </details>


                                            {{-- ON THE WAY --}}
                                            @elseif ($instance->status === 'in_progress')

                                                <details class="group relative inline-block">

                                                    <summary
                                                        class="flex cursor-pointer list-none items-center gap-2 rounded-lg bg-[#D8A400] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#B88C00]"
                                                    >

                                                        <span>
                                                            On the Way
                                                        </span>

                                                        <svg
                                                            class="h-4 w-4 transition group-open:rotate-180"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 9l-7 7-7-7"
                                                            />
                                                        </svg>

                                                    </summary>


                                                    <div
                                                        class="absolute right-0 z-30 mt-2 w-48 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg"
                                                    >

                                                        {{-- ON THE WAY --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'collector.collection.start',
                                                                $schedule
                                                            ) }}"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium text-[#2D6A4F] transition hover:bg-[#D8F3DC]"
                                                            >
                                                                <span>🟡</span>

                                                                <span>
                                                                    On the Way
                                                                </span>
                                                            </button>

                                                        </form>


                                                        {{-- CANCELLED --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'collector.collection.cancel',
                                                                $schedule
                                                            ) }}"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50"
                                                            >
                                                                <span>🔴</span>

                                                                <span>
                                                                    Cancelled
                                                                </span>
                                                            </button>

                                                        </form>


                                                        {{-- COMPLETED --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'collector.collection.complete',
                                                                $schedule
                                                            ) }}"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium text-[#1B4332] transition hover:bg-[#D8F3DC]"
                                                            >
                                                                <span>🟢</span>

                                                                <span>
                                                                    Completed
                                                                </span>
                                                            </button>

                                                        </form>

                                                    </div>

                                                </details>


                                            {{-- COMPLETED --}}
                                            @elseif ($instance->status === 'completed')

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-[#D8F3DC] px-3 py-2 text-sm font-semibold text-[#1B4332]"
                                                >
                                                    <span>🟢</span>

                                                    Completed Today
                                                </span>


                                            {{-- CANCELLED --}}
                                            @elseif ($instance->status === 'cancelled')

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-2 text-sm font-semibold text-red-600"
                                                >
                                                    <span>🔴</span>

                                                    Cancelled Today
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                @else

                    {{-- NO COLLECTION TODAY --}}
                    <div class="px-6 py-16 text-center">

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
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />

                            </svg>

                        </div>


                        <h3
                            class="mt-4 text-lg font-semibold text-[#1B4332]"
                        >
                            No Collection Today
                        </h3>


                        <p
                            class="mx-auto mt-2 max-w-md text-sm text-gray-500"
                        >
                            You have no garbage collection schedule assigned
                            for today.
                        </p>

                    </div>

                @endif

            </div>


            {{-- ===================================================== --}}
            {{-- INCOMING COLLECTION SCHEDULE --}}
            {{-- ===================================================== --}}

            <div
                class="mt-8 rounded-2xl border border-gray-200 bg-white shadow-sm"
            >

                {{-- HEADER --}}
                <div
                    class="border-b border-gray-200 px-6 py-5"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F3DC]"
                        >

                            <svg
                                class="h-6 w-6 text-[#1B4332]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />

                            </svg>

                        </div>


                        <div>

                            <h3 class="text-lg font-bold text-[#1B4332]">
                                Incoming Collection Schedule
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Your upcoming assigned garbage collection routes.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- INCOMING SCHEDULES --}}
                @if ($incomingSchedules->count())

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-[#F5F7F6]">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Barangay
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Zone
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Day
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Time
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Schedule Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach ($incomingSchedules as $schedule)

                                    <tr
                                        class="transition hover:bg-[#F5F7F6]"
                                    >

                                        {{-- BARANGAY --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="flex items-center gap-3">

                                                <div
                                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#D8F3DC]"
                                                >

                                                    <svg
                                                        class="h-5 w-5 text-[#1B4332]"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 7h2m-2 4h2m-2 4h2m4-8h2m-2 4h2m-2 4h2"
                                                        />

                                                    </svg>

                                                </div>


                                                <div>

                                                    <p
                                                        class="font-semibold text-[#1B4332]"
                                                    >
                                                        {{ $schedule->barangay?->name ?? 'N/A' }}
                                                    </p>

                                                    <p class="text-xs text-gray-400">
                                                        Assigned route
                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- ZONE --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <span
                                                class="rounded-full bg-[#D8F3DC] px-3 py-1 text-xs font-semibold text-[#1B4332]"
                                            >
                                                {{ $schedule->zone }}
                                            </span>

                                        </td>


                                        {{-- DAY --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <span
                                                class="font-semibold text-gray-700"
                                            >
                                                {{ $schedule->day_of_week }}
                                            </span>

                                        </td>


                                        {{-- TIME --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <p class="font-semibold text-[#1B4332]">

                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}

                                                -

                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}

                                            </p>

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            @if ($schedule->status === 'scheduled')

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-[#D8F3DC] px-3 py-1 text-xs font-semibold text-[#1B4332]"
                                                >
                                                    <span>📅</span>
                                                    Scheduled
                                                </span>

                                            @else

                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600"
                                                >
                                                    <span>🔴</span>
                                                    Cancelled
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    {{-- NO INCOMING SCHEDULE --}}
                    <div class="px-6 py-14 text-center">

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100"
                        >

                            <svg
                                class="h-7 w-7 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />

                            </svg>

                        </div>

                        <h3
                            class="mt-4 text-base font-semibold text-[#1B4332]"
                        >
                            No Incoming Schedule
                        </h3>


                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                            You currently have no upcoming garbage collection
                            schedules assigned to you.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-collector-layout>