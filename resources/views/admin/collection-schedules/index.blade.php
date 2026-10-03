<x-admin-layout>

    <div class="mb-8">

        <h1 class="text-2xl font-bold text-gray-800">
            Collection Schedules
        </h1>

        <p class="mt-1 text-gray-500">
            Manage barangay garbage collection schedules.
        </p>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-5 py-4 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-5 py-4">

            <p class="font-semibold text-red-700">
                Please fix the following:
            </p>

            <ul class="mt-2 list-disc list-inside text-sm text-red-600">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- Add Schedule --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                Add Collection Schedule
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Create a garbage collection schedule for a barangay and zone.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('admin.collection-schedules.store') }}"
            class="p-6"
        >

            @csrf


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


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
                        required
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
                        type="text"
                        id="zone"
                        name="zone"
                        value="{{ old('zone') }}"
                        placeholder="e.g. Zone 1"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-[#2D6A4F]
                               focus:ring-[#2D6A4F]"
                    >

                </div>


                {{-- Collection Date --}}
                <div>

                    <label
                        for="collection_date"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Collection Date
                    </label>

                    <input
                        type="date"
                        id="collection_date"
                        name="collection_date"
                        value="{{ old('collection_date') }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-[#2D6A4F]
                               focus:ring-[#2D6A4F]"
                    >

                </div>


                {{-- Status --}}
                <div>

                    <label
                        for="status"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-[#2D6A4F]
                               focus:ring-[#2D6A4F]"
                    >

                        <option value="scheduled"
                            {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>
                            Scheduled
                        </option>

                        <option value="completed"
                            {{ old('status') === 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="cancelled"
                            {{ old('status') === 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- Start Time --}}
                <div>

                    <label
                        for="start_time"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Start Time
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        value="{{ old('start_time') }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-[#2D6A4F]
                               focus:ring-[#2D6A4F]"
                    >

                </div>


                {{-- End Time --}}
                <div>

                    <label
                        for="end_time"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        End Time
                    </label>

                    <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        value="{{ old('end_time') }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-[#2D6A4F]
                               focus:ring-[#2D6A4F]"
                    >

                </div>

            </div>


            {{-- Submit --}}
            <div class="mt-6 flex justify-end">

                <button
                    type="submit"
                    class="px-5 py-3 rounded-lg
                           bg-[#2D6A4F]
                           text-white font-medium
                           hover:bg-[#1B4332]
                           transition"
                >
                    + Save Schedule
                </button>

            </div>

        </form>

    </div>


    {{-- Schedule List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                Garbage Collection Schedule
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Scheduled garbage collection activities.
            </p>

        </div>


        <div class="p-6">

            @forelse ($schedules as $schedule)

                <div class="border border-gray-100 rounded-lg p-5 mb-4">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>

                            <h3 class="font-semibold text-gray-800">
                                {{ $schedule->barangay?->name ?? 'No Barangay' }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Zone:
                                {{ $schedule->zone ?? 'All Zones' }}
                            </p>

                            <p class="text-sm mt-2">

                                @if ($schedule->status === 'scheduled')

                                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                        Scheduled
                                    </span>

                                @elseif ($schedule->status === 'completed')

                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                        Completed
                                    </span>

                                @else

                                    <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">
                                        Cancelled
                                    </span>

                                @endif

                            </p>

                        </div>


                        <div class="md:text-right">

                            <p class="font-medium text-gray-800">

                                {{ \Carbon\Carbon::parse($schedule->collection_date)->format('M d, Y') }}

                            </p>

                            <p class="text-sm text-gray-500">

                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}

                            </p>

                        </div>

                    </div>

                </div>

            @empty

                <div class="py-12 text-center">

                    <div class="text-4xl mb-4">
                        📅
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        No collection schedules yet
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Collection schedules created by the LGU will appear here.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</x-admin-layout>