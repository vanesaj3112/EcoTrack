<x-admin-layout>

    <div class="mb-6">

        <a
            href="{{ route('admin.resident-concerns.index') }}"
            class="text-sm font-semibold text-[#2D6A4F] hover:text-[#1B4332]"
        >
            ← Back to Resident Reports
        </a>

    </div>


    @if (session('success'))

        <div class="mb-6 rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4 text-[#1B4332]">
            {{ session('success') }}
        </div>

    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        {{-- Concern --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                <div>

                    <p class="text-sm text-gray-500">
                        {{ $residentConcern->category }}
                    </p>

                    <h1 class="mt-1 text-2xl font-bold text-[#1B4332]">
                        {{ $residentConcern->subject }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-500">
                        Submitted by
                        <span class="font-semibold">
                            {{ $residentConcern->resident?->name ?? 'Unknown' }}
                        </span>
                    </p>

                </div>


                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'in_review' => 'bg-blue-100 text-blue-800',
                        'resolved' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                    ];
                @endphp

                <span
                    class="inline-flex rounded-full px-4 py-2 text-sm font-semibold
                    {{ $statusClasses[$residentConcern->status] ?? 'bg-gray-100 text-gray-700' }}"
                >
                    {{ ucwords(str_replace('_', ' ', $residentConcern->status)) }}
                </span>

            </div>


            <div class="mt-6 pt-6 border-t border-gray-200">

                <h2 class="font-semibold text-gray-700">
                    Description
                </h2>

                <p class="mt-2 text-gray-700 whitespace-pre-line">
                    {{ $residentConcern->description }}
                </p>

            </div>


            @if ($residentConcern->photo_path)

                <div class="mt-6">

                    <h2 class="font-semibold text-gray-700 mb-3">
                        Supporting Photo
                    </h2>

                    <img
                        src="{{ asset('storage/' . $residentConcern->photo_path) }}"
                        alt="Resident concern photo"
                        class="max-w-full sm:max-w-xl rounded-xl border border-gray-200"
                    >

                </div>

            @endif

        </div>


        {{-- Resident --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

            <h2 class="text-lg font-bold text-[#1B4332]">
                Resident Information
            </h2>


            <div class="mt-5 space-y-4">

                <div>

                    <p class="text-xs text-gray-500">
                        Full Name
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ $residentConcern->resident?->name ?? '—' }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-gray-500">
                        Email
                    </p>

                    <p class="font-semibold text-gray-800 break-all">
                        {{ $residentConcern->resident?->email ?? '—' }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-gray-500">
                        Mobile
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ $residentConcern->resident?->mobile_number ?? '—' }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-gray-500">
                        Submitted
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ $residentConcern->created_at->format('M d, Y h:i A') }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Update --}}
    <div class="mt-6 bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h2 class="text-xl font-bold text-[#1B4332]">
            Manage Concern
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Update the concern status and provide a response to the resident.
        </p>


        <form
            method="POST"
            action="{{ route('admin.resident-concerns.update', $residentConcern) }}"
            class="mt-6"
        >

            @csrf
            @method('PUT')


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- Status --}}
                <div>

                    <label
                        for="status"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3
                               bg-white
                               focus:border-[#2D6A4F]
                               focus:ring-2
                               focus:ring-[#B7E4C7]
                               focus:outline-none"
                    >

                        <option
                            value="pending"
                            @selected($residentConcern->status === 'pending')
                        >
                            Pending
                        </option>

                        <option
                            value="in_review"
                            @selected($residentConcern->status === 'in_review')
                        >
                            In Review
                        </option>

                        <option
                            value="resolved"
                            @selected($residentConcern->status === 'resolved')
                        >
                            Resolved
                        </option>

                        <option
                            value="rejected"
                            @selected($residentConcern->status === 'rejected')
                        >
                            Rejected
                        </option>

                    </select>

                </div>


                {{-- Admin --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Handled By
                    </label>

                    <div
                        class="w-full rounded-xl
                               border border-gray-200
                               bg-gray-50
                               px-4 py-3
                               text-gray-700"
                    >
                        {{ auth()->user()->name }}
                    </div>

                </div>


            </div>


            {{-- Response --}}
            <div class="mt-5">

                <label
                    for="admin_response"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    LGU Response
                </label>

                <textarea
                    id="admin_response"
                    name="admin_response"
                    rows="6"
                    maxlength="5000"
                    placeholder="Write your response or resolution..."
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3
                           resize-y
                           focus:border-[#2D6A4F]
                           focus:ring-2
                           focus:ring-[#B7E4C7]
                           focus:outline-none"
                >{{ old('admin_response', $residentConcern->admin_response) }}</textarea>

            </div>


            <div class="mt-6 flex justify-end">

                <button
                    type="submit"
                    class="rounded-xl
                           bg-[#2D6A4F]
                           px-6 py-3
                           font-semibold
                           text-white
                           hover:bg-[#1B4332]
                           transition"
                >
                    Update Concern
                </button>

            </div>

        </form>

    </div>


</x-admin-layout>