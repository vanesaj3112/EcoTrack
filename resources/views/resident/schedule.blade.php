<x-layouts.resident>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#1B4332]">
            Collection Schedule
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            View your regular schedule or request an additional collection
            directly from an available collector.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 rounded-xl bg-[#D8F3DC] p-4">
        <p class="text-sm text-[#1B4332]">Your collection area</p>

        <p class="mt-1 font-semibold text-[#1B4332]">
            {{ auth()->user()->barangay?->name ?? 'No barangay assigned' }}
            · Zone {{ auth()->user()->zone ?? '—' }}
        </p>
    </div>

    {{-- Regular collection schedule --}}
    <div class="mb-8 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="border-b border-gray-200 p-4">
            <h2 class="font-semibold text-gray-800">Regular Schedule</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Date / Day</th>
                        <th class="px-4 py-3">Time</th>
                        <th class="px-4 py-3">Collector</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($schedules as $schedule)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-800">
                                @if (!empty($schedule->collection_date))
                                    {{ \Carbon\Carbon::parse($schedule->collection_date)->format('M d, Y') }}
                                @else
                                    {{ $schedule->day_of_week }}
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-4 py-3">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                –
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $schedule->collector?->name ?? 'Unassigned' }}
                            </td>

                            <td class="px-4 py-3">
                                @if ($schedule->status === 'cancelled')
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Cancelled
                                    </span>
                                @else
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                        Scheduled
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                No regular collection schedules for your area yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Additional collection request --}}
    <div class="mb-8 rounded-xl border border-gray-200 bg-white p-5">
        <h2 class="text-lg font-semibold text-[#1B4332]">
            Request an Additional Collection
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Choose your preferred date, time, and collector. Your request
            will be sent directly to that collector for acceptance or rejection.
            You may choose a collector from another barangay if needed.
        </p>

        <form
            method="POST"
            action="{{ route('resident.collection-requests.store') }}"
            class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2"
        >
            @csrf

            <div>
                <label for="requested_date" class="mb-1 block text-sm font-medium text-gray-700">
                    Preferred Date
                </label>

                <input
                    id="requested_date"
                    type="date"
                    name="requested_date"
                    min="{{ now()->toDateString() }}"
                    value="{{ old('requested_date') }}"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-green-700 focus:ring-green-700"
                >
            </div>

            <div>
                <label for="assigned_collector_id" class="mb-1 block text-sm font-medium text-gray-700">
                    Choose Collector
                </label>

                <select
                    id="assigned_collector_id"
                    name="assigned_collector_id"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-green-700 focus:ring-green-700"
                >
                    <option value="">Select a collector</option>

                    @forelse ($availableCollectors as $collector)
                        <option
                            value="{{ $collector->id }}"
                            @selected(old('assigned_collector_id') == $collector->id)
                        >
                            {{ $collector->name }}
                            — {{ $collector->barangay?->name ?? 'Barangay not assigned' }}
                        </option>
                    @empty
                        <option value="" disabled>No collectors available</option>
                    @endforelse
                </select>

                <p class="mt-1 text-xs text-gray-500">
                    The list depends on the availability data supplied by the controller.
                </p>
            </div>

            <div>
                <label for="preferred_start_time" class="mb-1 block text-sm font-medium text-gray-700">
                    Preferred Start Time
                </label>

                <input
                    id="preferred_start_time"
                    type="time"
                    name="preferred_start_time"
                    value="{{ old('preferred_start_time') }}"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-green-700 focus:ring-green-700"
                >
            </div>

            <div>
                <label for="preferred_end_time" class="mb-1 block text-sm font-medium text-gray-700">
                    Preferred End Time
                </label>

                <input
                    id="preferred_end_time"
                    type="time"
                    name="preferred_end_time"
                    value="{{ old('preferred_end_time') }}"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-green-700 focus:ring-green-700"
                >
            </div>

            <div class="md:col-span-2">
                <label for="notes" class="mb-1 block text-sm font-medium text-gray-700">
                    Notes (Optional)
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    maxlength="1000"
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-green-700 focus:ring-green-700"
                    placeholder="Waste type, pickup location, or additional instructions..."
                >{{ old('notes') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <button
                    type="submit"
                    @disabled($availableCollectors->isEmpty())
                    class="rounded-lg bg-[#1B4332] px-5 py-3 text-sm font-semibold text-white hover:bg-[#2D6A4F] disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Send Request to Collector
                </button>
            </div>
        </form>
    </div>

    {{-- Resident's collection request history --}}
    @isset($myRequests)
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="border-b border-gray-200 p-4">
                <h2 class="font-semibold text-gray-800">
                    My Additional Collection Requests
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Time</th>
                            <th class="px-4 py-3">Collector</th>
                            <th class="px-4 py-3">Barangay / Zone</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($myRequests as $request)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3">
                                    {{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y') }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-3">
                                    {{ \Carbon\Carbon::parse($request->preferred_start_time)->format('h:i A') }}
                                    –
                                    {{ \Carbon\Carbon::parse($request->preferred_end_time)->format('h:i A') }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $request->assignedCollector?->name ?? 'Not assigned' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $request->barangay?->name ?? '—' }}
                                    / Zone {{ $request->zone }}
                                </td>

                                <td class="px-4 py-3">
                                    @switch($request->status)
                                        @case('pending')
                                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                                Pending Collector
                                            </span>
                                            @break

                                        @case('approved')
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                                Accepted
                                            </span>
                                            @break

                                        @case('rejected')
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                Rejected
                                            </span>
                                            @break

                                        @case('cancelled')
                                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                                Cancelled
                                            </span>
                                            @break

                                        @default
                                            {{ ucfirst($request->status) }}
                                    @endswitch
                                </td>

                                <td class="px-4 py-3">
                                    @if ($request->status === 'pending')
                                        <form
                                            method="POST"
                                            action="{{ route('resident.collection-requests.cancel', $request) }}"
                                            onsubmit="return confirm('Cancel this collection request?')"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="font-semibold text-red-600 hover:text-red-800"
                                            >
                                                Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    You have not submitted any additional collection requests.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
</x-layouts.resident>