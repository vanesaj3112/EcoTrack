<x-layouts.admin>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Collection Requests
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Review resident requests and assign an approved collector.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
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

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Resident</th>
                    <th class="px-4 py-3">Area</th>
                    <th class="px-4 py-3">Requested Date</th>
                    <th class="px-4 py-3">Preferred Time</th>
                    <th class="px-4 py-3">Notes</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Review</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($requests as $collectionRequest)
                    <tr class="align-top">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-800">
                                {{ $collectionRequest->resident?->name ?? 'Resident unavailable' }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $collectionRequest->resident?->mobile_number ?? '' }}
                            </p>
                        </td>

                        <td class="px-4 py-3">
                            {{ $collectionRequest->barangay?->name ?? '—' }}
                            <div class="text-xs text-gray-500">
                                Zone {{ $collectionRequest->zone }}
                            </div>
                        </td>

                        <td class="whitespace-nowrap px-4 py-3">
                            {{ $collectionRequest->requested_date->format('M d, Y') }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-3">
                            {{ \Carbon\Carbon::parse($collectionRequest->preferred_start_time)->format('h:i A') }}
                            –
                            {{ \Carbon\Carbon::parse($collectionRequest->preferred_end_time)->format('h:i A') }}
                        </td>

                        <td class="max-w-xs px-4 py-3">
                            {{ $collectionRequest->notes ?: '—' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold
                                {{ $collectionRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $collectionRequest->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $collectionRequest->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $collectionRequest->status === 'cancelled' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ ucfirst($collectionRequest->status) }}
                            </span>

                            @if ($collectionRequest->assignedCollector)
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $collectionRequest->assignedCollector->name }}
                                </p>
                            @endif
                        </td>

                        <td class="min-w-64 px-4 py-3">
                            @if ($collectionRequest->status === 'pending')
                                <form
                                    method="POST"
                                    action="{{ route('admin.collection-requests.review', $collectionRequest) }}"
                                    class="space-y-3"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <label class="block text-xs font-medium text-gray-600">
                                        Assign Collector
                                    </label>

                                    <select
                                        name="assigned_collector_id"
                                        required
                                        class="w-full rounded-lg border-gray-300 text-sm"
                                    >
                                        <option value="">Select collector</option>

                                        @foreach ($collectors as $collector)
                                            <option
                                                value="{{ $collector->id }}"
                                                @selected(old('assigned_collector_id') == $collector->id)
                                            >
                                                {{ $collector->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <textarea
                                        name="admin_notes"
                                        rows="2"
                                        maxlength="1000"
                                        class="w-full rounded-lg border-gray-300 text-sm"
                                        placeholder="Admin notes (optional)"
                                    >{{ old('admin_notes') }}</textarea>

                                    <div class="flex flex-wrap gap-2">
                                        <button
                                            type="submit"
                                            name="decision"
                                            value="approved"
                                            class="rounded-lg bg-green-700 px-3 py-2 text-xs font-semibold text-white hover:bg-green-800"
                                        >
                                            Approve
                                        </button>

                                        <button
                                            type="submit"
                                            name="decision"
                                            value="rejected"
                                            formnovalidate
                                            class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700"
                                        >
                                            Reject
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p class="text-xs text-gray-500">
                                    Reviewed {{ $collectionRequest->reviewed_at?->format('M d, Y h:i A') ?? '—' }}
                                </p>

                                @if ($collectionRequest->admin_notes)
                                    <p class="mt-1 text-xs text-gray-600">
                                        {{ $collectionRequest->admin_notes }}
                                    </p>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            No collection requests yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>