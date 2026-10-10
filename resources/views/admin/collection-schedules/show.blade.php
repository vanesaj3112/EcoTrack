<x-admin-layout>

    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <a
                    href="{{ route('admin.collection-schedules.index') }}"
                    class="text-sm font-semibold text-[#2D6A4F] hover:underline"
                >
                    ← Back to Barangays
                </a>

                <p class="mt-4 text-sm font-semibold text-[#2D6A4F]">
                    Collection Schedule
                </p>

                <h1 class="mt-1 text-3xl font-bold text-[#1B4332]">
                    {{ $barangay->name }}
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Manage the weekly garbage collection schedule for this barangay.
                </p>

            </div>

            <button
                type="button"
                onclick="document.getElementById('addScheduleForm').scrollIntoView({ behavior: 'smooth' })"
                class="rounded-xl bg-[#1B4332] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2D6A4F]"
            >
                + Add Schedule
            </button>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div
                class="rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4 text-sm font-medium text-[#1B4332]"
            >
                {{ session('success') }}
            </div>

        @endif


        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div
                class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700"
            >

                <p class="font-semibold">
                    Please fix the following:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- WEEKLY SCHEDULE --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-5">

                <h2 class="text-lg font-bold text-[#1B4332]">
                    Weekly Collection Schedule
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Current collection schedules for {{ $barangay->name }}.
                </p>

            </div>


            @if ($schedules->count())

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-[#F5F7F6]">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Zone
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Day
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Time
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Collector
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @foreach ($schedules as $schedule)

                                {{-- SCHEDULE ROW --}}
                                <tr class="hover:bg-[#F5F7F6]">

                                    {{-- ZONE --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <span
                                            class="rounded-full bg-[#D8F3DC] px-3 py-1 text-xs font-semibold text-[#1B4332]"
                                        >
                                            {{ $schedule->zone }}
                                        </span>

                                    </td>


                                    {{-- DAY --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-700">

                                        {{ $schedule->day_of_week }}

                                    </td>


                                    {{-- TIME --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">

                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}

                                        -

                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}

                                    </td>


                                    {{-- COLLECTOR --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">

                                        {{ $schedule->collector?->name ?? 'Not assigned' }}

                                    </td>


                                    {{-- STATUS --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($schedule->status === 'scheduled')

                                            <span
                                                class="rounded-full bg-[#FFF4CC] px-3 py-1 text-xs font-semibold text-[#7A5A00]"
                                            >
                                                Active
                                            </span>

                                        @elseif ($schedule->status === 'cancelled')

                                            <span
                                                class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600"
                                            >
                                                Cancelled
                                            </span>

                                        @else

                                            <span
                                                class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600"
                                            >
                                                {{ ucfirst($schedule->status) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ACTION --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">

                                        <div class="flex items-center justify-end gap-4">

                                            {{-- EDIT --}}
                                            <button
                                                type="button"
                                                onclick="document.getElementById('editSchedule{{ $schedule->id }}').classList.toggle('hidden')"
                                                class="text-sm font-semibold text-[#2D6A4F] hover:underline"
                                            >
                                                Edit
                                            </button>


                                            {{-- DELETE --}}
                                            <form
                                                method="POST"
                                                action="{{ route('admin.collection-schedules.destroy', [$barangay, $schedule]) }}"
                                                onsubmit="return confirm('Delete this weekly schedule?');"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-sm font-semibold text-[#D64045] hover:underline"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                                {{-- EDIT FORM --}}
                                <tr
                                    id="editSchedule{{ $schedule->id }}"
                                    class="hidden bg-[#F5F7F6]"
                                >

                                    <td colspan="6" class="px-6 py-6">

                                        <div class="rounded-2xl border border-[#D8F3DC] bg-white p-6">

                                            <div class="mb-6">

                                                <h3 class="text-lg font-bold text-[#1B4332]">
                                                    Edit Weekly Schedule
                                                </h3>

                                                <p class="mt-1 text-sm text-gray-500">
                                                    Update the collection schedule for
                                                    {{ $barangay->name }}.
                                                </p>

                                            </div>


                                            <form
                                                method="POST"
                                                action="{{ route('admin.collection-schedules.update', [$barangay, $schedule]) }}"
                                                class="grid gap-6 md:grid-cols-2"
                                            >

                                                @csrf

                                                @method('PUT')


                                                {{-- ZONE --}}
                                                <div>

                                                    <label
                                                        for="zone_{{ $schedule->id }}"
                                                        class="block text-sm font-semibold text-gray-700"
                                                    >
                                                        Zone
                                                    </label>

                                                    <input
                                                        id="zone_{{ $schedule->id }}"
                                                        name="zone"
                                                        type="text"
                                                        value="{{ $schedule->zone }}"
                                                        placeholder="Example: Zone 1"
                                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                                                        required
                                                    >

                                                </div>


                                                {{-- DAY --}}
                                                <div>

                                                    <label
                                                        for="day_{{ $schedule->id }}"
                                                        class="block text-sm font-semibold text-gray-700"
                                                    >
                                                        Collection Day
                                                    </label>

                                                    <select
                                                        id="day_{{ $schedule->id }}"
                                                        name="day_of_week"
                                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                                                        required
                                                    >

                                                        @foreach ([
                                                            'Monday',
                                                            'Tuesday',
                                                            'Wednesday',
                                                            'Thursday',
                                                            'Friday',
                                                            'Saturday',
                                                            'Sunday'
                                                        ] as $day)

                                                            <option
                                                                value="{{ $day }}"
                                                                @selected($schedule->day_of_week === $day)
                                                            >
                                                                {{ $day }}
                                                            </option>

                                                        @endforeach

                                                    </select>

                                                </div>


                                                {{-- START TIME --}}
                                                <div>

                                                    <label
                                                        for="start_{{ $schedule->id }}"
                                                        class="block text-sm font-semibold text-gray-700"
                                                    >
                                                        Start Time
                                                    </label>

                                                    <input
                                                        id="start_{{ $schedule->id }}"
                                                        name="start_time"
                                                        type="time"
                                                        value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}"
                                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                                                        required
                                                    >

                                                </div>


                                                {{-- END TIME --}}
                                                <div>

                                                    <label
                                                        for="end_{{ $schedule->id }}"
                                                        class="block text-sm font-semibold text-gray-700"
                                                    >
                                                        End Time
                                                    </label>

                                                    <input
                                                        id="end_{{ $schedule->id }}"
                                                        name="end_time"
                                                        type="time"
                                                        value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}"
                                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                                                        required
                                                    >

                                                </div>


                                                {{-- COLLECTOR --}}
                                                <div>

                                                    <label
                                                        for="collector_{{ $schedule->id }}"
                                                        class="block text-sm font-semibold text-gray-700"
                                                    >
                                                        Garbage Collector
                                                    </label>

                                                    <select
                                                        id="collector_{{ $schedule->id }}"
                                                        name="collector_id"
                                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                                                    >

                                                        <option value="">
                                                            Not assigned
                                                        </option>

                                                        @foreach ($collectors as $collector)

                                                            <option
                                                                value="{{ $collector->id }}"
                                                                @selected($schedule->collector_id == $collector->id)
                                                            >
                                                                {{ $collector->name }}
                                                            </option>

                                                        @endforeach

                                                    </select>

                                                </div>


                                                {{-- STATUS --}}
                                                <div>

                                                    <label
                                                        for="status_{{ $schedule->id }}"
                                                        class="block text-sm font-semibold text-gray-700"
                                                    >
                                                        Schedule Status
                                                    </label>

                                                    <select
                                                        id="status_{{ $schedule->id }}"
                                                        name="status"
                                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                                                        required
                                                    >

                                                        <option
                                                            value="scheduled"
                                                            @selected($schedule->status === 'scheduled')
                                                        >
                                                            Active
                                                        </option>

                                                        <option
                                                            value="cancelled"
                                                            @selected($schedule->status === 'cancelled')
                                                        >
                                                            Cancelled
                                                        </option>

                                                    </select>

                                                </div>


                                                {{-- BUTTONS --}}
                                                <div class="md:col-span-2 flex justify-end gap-3">

                                                    <button
                                                        type="button"
                                                        onclick="document.getElementById('editSchedule{{ $schedule->id }}').classList.add('hidden')"
                                                        class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-100"
                                                    >
                                                        Cancel
                                                    </button>


                                                    <button
                                                        type="submit"
                                                        class="rounded-xl bg-[#1B4332] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2D6A4F]"
                                                    >
                                                        Update Schedule
                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-14 text-center">

                    <h3 class="text-lg font-semibold text-[#1B4332]">
                        No schedules yet
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Add the first weekly collection schedule below.
                    </p>

                </div>

            @endif

        </div>


        {{-- ADD SCHEDULE --}}
        <div
            id="addScheduleForm"
            class="rounded-2xl border border-gray-200 bg-white shadow-sm"
        >

            <div class="border-b border-gray-200 px-6 py-5">

                <h2 class="text-lg font-bold text-[#1B4332]">
                    Add Collection Schedule
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Create a recurring weekly schedule for this barangay.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.collection-schedules.store', $barangay) }}"
                class="space-y-6 p-6"
            >

                @csrf


                {{-- ZONE --}}
                <div>

                    <label
                        for="zone"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Zone
                    </label>

                    <input
                        id="zone"
                        name="zone"
                        type="text"
                        value="{{ old('zone') }}"
                        placeholder="Example: Zone 1"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                        required
                    >

                </div>


                {{-- DAY --}}
                <div>

                    <label
                        for="day_of_week"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Collection Day
                    </label>

                    <select
                        id="day_of_week"
                        name="day_of_week"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                        required
                    >

                        <option value="">
                            Select day
                        </option>

                        @foreach ([
                            'Monday',
                            'Tuesday',
                            'Wednesday',
                            'Thursday',
                            'Friday',
                            'Saturday',
                            'Sunday'
                        ] as $day)

                            <option
                                value="{{ $day }}"
                                @selected(old('day_of_week') === $day)
                            >
                                {{ $day }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TIME --}}
                <div class="grid gap-6 sm:grid-cols-2">

                    <div>

                        <label
                            for="start_time"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Start Time
                        </label>

                        <input
                            id="start_time"
                            name="start_time"
                            type="time"
                            value="{{ old('start_time') }}"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                            required
                        >

                    </div>


                    <div>

                        <label
                            for="end_time"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            End Time
                        </label>

                        <input
                            id="end_time"
                            name="end_time"
                            type="time"
                            value="{{ old('end_time') }}"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                            required
                        >

                    </div>

                </div>


                {{-- COLLECTOR --}}
                <div>

                    <label
                        for="collector_id"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Garbage Collector
                    </label>

                    <select
                        id="collector_id"
                        name="collector_id"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                    >

                        <option value="">
                            Not assigned
                        </option>

                        @foreach ($collectors as $collector)

                            <option
                                value="{{ $collector->id }}"
                                @selected(old('collector_id') == $collector->id)
                            >
                                {{ $collector->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}
                <div>

                    <label
                        for="status"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Schedule Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                        required
                    >

                        <option
                            value="scheduled"
                            @selected(old('status', 'scheduled') === 'scheduled')
                        >
                            Active
                        </option>

                        <option
                            value="cancelled"
                            @selected(old('status') === 'cancelled')
                        >
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- SUBMIT --}}
                <div class="flex justify-end">

                    <button
                        type="submit"
                        class="rounded-xl bg-[#1B4332] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#2D6A4F]"
                    >
                        Save Schedule
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>