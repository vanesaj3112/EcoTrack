<x-admin-layout>

    {{-- Header --}}
    <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-eco-dark">
                Resident Details
            </h2>

            <p class="mt-1 text-gray-500">
                View and manage resident registration information.
            </p>
        </div>

        <a
            href="{{ route('admin.residents.index') }}"
            class="inline-flex items-center justify-center w-full px-4 py-2.5
                   text-gray-700 transition bg-gray-100 rounded-lg
                   sm:w-auto hover:bg-gray-200"
        >
            ← Back to Residents
        </a>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="mb-6 rounded-xl border border-[#D8F3DC] bg-[#D8F3DC] px-5 py-4">
            <p class="text-sm font-medium text-[#1B4332]">
                ✓ {{ session('success') }}
            </p>
        </div>

    @endif


    {{-- Resident Information --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Profile Summary --}}
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">

            <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold rounded-full bg-eco-light text-eco-dark">
                {{ strtoupper(substr($resident->name, 0, 1)) }}
            </div>

            <h3 class="mt-4 text-xl font-bold text-gray-800">
                {{ $resident->name }}
            </h3>

            <p class="mt-1 text-sm text-gray-500 break-all">
                {{ $resident->email }}
            </p>


            {{-- Account Status --}}
            <div class="mt-5">

                <p class="text-xs tracking-wide text-gray-400 uppercase">
                    Account Status
                </p>

                @if ($resident->status === 'approved')

                    <span class="inline-flex px-3 py-1 mt-2 text-xs font-semibold rounded-full bg-eco-light text-eco-dark">
                        🟢 Approved
                    </span>

                @elseif ($resident->status === 'rejected')

                    <span class="inline-flex px-3 py-1 mt-2 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                        🔴 Rejected
                    </span>

                @else

                    <span class="inline-flex px-3 py-1 mt-2 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                        🟡 Pending
                    </span>

                @endif

            </div>


            {{-- Rejection Reason --}}
            @if ($resident->status === 'rejected' && $resident->rejection_reason)

                <div class="p-4 mt-5 rounded-xl bg-red-50">

                    <p class="text-xs font-semibold tracking-wide text-red-600 uppercase">
                        Rejection Reason
                    </p>

                    <p class="mt-2 text-sm text-red-700">
                        {{ $resident->rejection_reason }}
                    </p>

                </div>

            @endif

        </div>


        {{-- Registration Information --}}
        <div class="p-6 bg-white border border-gray-100 shadow-sm lg:col-span-2 rounded-xl">

            <h3 class="mb-5 text-lg font-semibold text-eco-dark">
                Registration Information
            </h3>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-xs tracking-wide text-gray-400 uppercase">
                        Full Name
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ $resident->name }}
                    </p>
                </div>


                <div>
                    <p class="text-xs tracking-wide text-gray-400 uppercase">
                        Email Address
                    </p>

                    <p class="mt-1 text-gray-800 break-all">
                        {{ $resident->email }}
                    </p>
                </div>


                <div>
                    <p class="text-xs tracking-wide text-gray-400 uppercase">
                        Mobile Number
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->mobile_number ?? '—' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs tracking-wide text-gray-400 uppercase">
                        Barangay
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->barangay?->name ?? '—' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs tracking-wide text-gray-400 uppercase">
                        Zone
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->zone ?? '—' }}
                    </p>
                </div>


                <div class="sm:col-span-2">

                    <p class="text-xs tracking-wide text-gray-400 uppercase">
                        Complete Address
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->address ?? '—' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Verification Actions --}}
    @if ($resident->status === 'pending')

        <div class="p-6 mt-6 bg-white border border-gray-100 shadow-sm rounded-xl">

            <div class="mb-5">

                <h3 class="text-lg font-semibold text-eco-dark">
                    Verification Actions
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Review the submitted documents before approving or rejecting this resident account.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                {{-- Approve --}}
                <div class="p-5 border border-[#D8F3DC] bg-[#F5F7F6] rounded-xl">

                    <h4 class="font-semibold text-eco-dark">
                        Approve Resident
                    </h4>

                    <p class="mt-1 text-sm text-gray-500">
                        This will allow the resident to access the EcoTrack resident portal.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.residents.approve', $resident) }}"
                        class="mt-4"
                    >

                        @csrf

                        <button
                            type="submit"
                            onclick="return confirm('Approve this resident account?')"
                            class="inline-flex items-center justify-center w-full px-4 py-2.5
                                   font-semibold text-white transition rounded-lg
                                   bg-eco-green hover:bg-eco-dark"
                        >
                            ✓ Approve Resident
                        </button>

                    </form>

                </div>


                {{-- Reject --}}
                <div class="p-5 border border-red-100 bg-red-50 rounded-xl">

                    <h4 class="font-semibold text-red-700">
                        Reject Resident
                    </h4>

                    <p class="mt-1 text-sm text-red-600">
                        Provide a reason so the rejection is properly documented.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.residents.reject', $resident) }}"
                        class="mt-4"
                    >

                        @csrf

                        <textarea
                            name="rejection_reason"
                            rows="3"
                            required
                            maxlength="500"
                            placeholder="Enter rejection reason..."
                            class="w-full px-3 py-2 text-sm border border-red-200 rounded-lg
                                   focus:border-red-400 focus:ring-red-400"
                        ></textarea>

                        @error('rejection_reason')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                        <button
                            type="submit"
                            onclick="return confirm('Reject this resident account?')"
                            class="inline-flex items-center justify-center w-full px-4 py-2.5
                                   mt-3 font-semibold text-white transition
                                   bg-red-600 rounded-lg hover:bg-red-700"
                        >
                            ✕ Reject Resident
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @endif


    {{-- Verification Documents --}}
    <div class="p-6 mt-6 bg-white border border-gray-100 shadow-sm rounded-xl">

        <div>

            <h3 class="text-lg font-semibold text-eco-dark">
                Verification Documents
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Documents submitted during resident registration.
            </p>

        </div>


        <div class="grid grid-cols-1 gap-5 mt-5 md:grid-cols-2">

            {{-- Government ID --}}
            <div class="p-5 border border-gray-200 rounded-xl">

                <div class="flex items-start gap-3">

                    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-lg bg-eco-light text-eco-dark">
                        📄
                    </div>

                    <div class="min-w-0">

                        <p class="font-semibold text-gray-800">
                            National ID / Government ID
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Identity verification document
                        </p>

                    </div>

                </div>


                @if ($resident->verification_document)

                    <div class="mt-5">

                        <a
                            href="{{ route('admin.residents.document', [$resident, 'verification']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center w-full px-4 py-2.5
                                   text-sm font-medium text-white transition rounded-lg
                                   bg-eco-green hover:bg-eco-dark"
                        >
                            👁 View Document
                        </a>

                    </div>

                @else

                    <div class="px-4 py-3 mt-5 bg-gray-50 rounded-lg">

                        <p class="text-sm text-gray-400">
                            No document uploaded.
                        </p>

                    </div>

                @endif

            </div>


            {{-- Residency Document --}}
            <div class="p-5 border border-gray-200 rounded-xl">

                <div class="flex items-start gap-3">

                    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-lg bg-eco-light text-eco-dark">
                        🏠
                    </div>

                    <div class="min-w-0">

                        <p class="font-semibold text-gray-800">
                            Proof of Residency
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Barangay residency verification document
                        </p>

                    </div>

                </div>


                @if ($resident->residency_document)

                    <div class="mt-5">

                        <a
                            href="{{ route('admin.residents.document', [$resident, 'residency']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center w-full px-4 py-2.5
                                   text-sm font-medium text-white transition rounded-lg
                                   bg-eco-green hover:bg-eco-dark"
                        >
                            👁 View Document
                        </a>

                    </div>

                @else

                    <div class="px-4 py-3 mt-5 bg-gray-50 rounded-lg">

                        <p class="text-sm text-gray-400">
                            No document uploaded.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- Account Information --}}
    <div class="p-6 mt-6 bg-white border border-gray-100 shadow-sm rounded-xl">

        <h3 class="mb-5 text-lg font-semibold text-eco-dark">
            Account Information
        </h3>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div>

                <p class="text-xs tracking-wide text-gray-400 uppercase">
                    Registered
                </p>

                <p class="mt-1 text-gray-800">
                    {{ $resident->created_at?->format('M d, Y h:i A') ?? '—' }}
                </p>

            </div>


            <div>

                <p class="text-xs tracking-wide text-gray-400 uppercase">
                    Last Updated
                </p>

                <p class="mt-1 text-gray-800">
                    {{ $resident->updated_at?->format('M d, Y h:i A') ?? '—' }}
                </p>

            </div>


            @if ($resident->verified_at)

                <div>

                    <p class="text-xs tracking-wide text-gray-400 uppercase">
                        Verified At
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->verified_at->format('M d, Y h:i A') }}
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-admin-layout>