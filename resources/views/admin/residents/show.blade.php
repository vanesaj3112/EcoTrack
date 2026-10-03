<x-admin-layout>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-eco-dark">
                Resident Details
            </h2>

            <p class="text-gray-500 mt-1">
                View resident registration information.
            </p>
        </div>

        <a
            href="{{ route('admin.residents.index') }}"
            class="w-full sm:w-auto inline-flex items-center justify-center
                   px-4 py-2.5 rounded-lg
                   bg-gray-100 text-gray-700
                   hover:bg-gray-200 transition"
        >
            ← Back to Residents
        </a>

    </div>


    {{-- Resident Information --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Profile Summary --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

            <div class="w-16 h-16 rounded-full bg-eco-light
                        flex items-center justify-center
                        text-2xl font-bold text-eco-dark">

                {{ strtoupper(substr($resident->name, 0, 1)) }}

            </div>

            <h3 class="mt-4 text-xl font-bold text-gray-800">
                {{ $resident->name }}
            </h3>

            <p class="text-sm text-gray-500 mt-1 break-all">
                {{ $resident->email }}
            </p>


            {{-- Account Status --}}
            <div class="mt-5">

                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    Account Status
                </p>

                @if ($resident->status === 'approved')

                    <span class="inline-flex mt-2 px-3 py-1 rounded-full
                                 text-xs font-semibold
                                 bg-eco-light text-eco-dark">
                        Approved
                    </span>

                @elseif ($resident->status === 'rejected')

                    <span class="inline-flex mt-2 px-3 py-1 rounded-full
                                 text-xs font-semibold
                                 bg-gray-100 text-gray-700">
                        Rejected
                    </span>

                @else

                    <span class="inline-flex mt-2 px-3 py-1 rounded-full
                                 text-xs font-semibold
                                 bg-eco-light text-eco-green">
                        Pending
                    </span>

                @endif

            </div>

        </div>


        {{-- Registration Information --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm
                    border border-gray-100 p-6">

            <h3 class="text-lg font-semibold text-eco-dark mb-5">
                Registration Information
            </h3>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Full Name --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">
                        Full Name
                    </p>

                    <p class="mt-1 text-gray-800 font-medium">
                        {{ $resident->name }}
                    </p>
                </div>


                {{-- Email --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">
                        Email Address
                    </p>

                    <p class="mt-1 text-gray-800 break-all">
                        {{ $resident->email }}
                    </p>
                </div>


                {{-- Mobile --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">
                        Mobile Number
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->mobile_number ?? '—' }}
                    </p>
                </div>


                {{-- Barangay --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">
                        Barangay
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->barangay?->name ?? '—' }}
                    </p>
                </div>


                {{-- Zone --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">
                        Zone
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->zone ?? '—' }}
                    </p>
                </div>


                {{-- Address --}}
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">
                        Complete Address
                    </p>

                    <p class="mt-1 text-gray-800">
                        {{ $resident->address ?? '—' }}
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- Verification Documents --}}
    <div class="mt-6 bg-white rounded-xl shadow-sm
                border border-gray-100 p-6">

        <div>
            <h3 class="text-lg font-semibold text-eco-dark">
                Verification Documents
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Documents submitted during resident registration.
            </p>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">


            {{-- Government ID --}}
            <div class="rounded-xl border border-gray-200 p-5">

                <div class="flex items-start gap-3">

                    <div class="w-10 h-10 rounded-lg bg-eco-light
                                flex items-center justify-center
                                text-eco-dark flex-shrink-0">
                        📄
                    </div>

                    <div class="min-w-0">

                        <p class="font-semibold text-gray-800">
                            National ID / Government ID
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
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
                            class="w-full inline-flex items-center justify-center
                                   px-4 py-2.5 rounded-lg
                                   bg-eco-green text-white
                                   text-sm font-medium
                                   hover:bg-eco-dark transition"
                        >
                            👁 View Document
                        </a>

                    </div>

                @else

                    <div class="mt-5 px-4 py-3 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-400">
                            No document uploaded.
                        </p>
                    </div>

                @endif

            </div>


            {{-- Residency Document --}}
            <div class="rounded-xl border border-gray-200 p-5">

                <div class="flex items-start gap-3">

                    <div class="w-10 h-10 rounded-lg bg-eco-light
                                flex items-center justify-center
                                text-eco-dark flex-shrink-0">
                        🏠
                    </div>

                    <div class="min-w-0">

                        <p class="font-semibold text-gray-800">
                            Proof of Residency
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
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
                            class="w-full inline-flex items-center justify-center
                                   px-4 py-2.5 rounded-lg
                                   bg-eco-green text-white
                                   text-sm font-medium
                                   hover:bg-eco-dark transition"
                        >
                            👁 View Document
                        </a>

                    </div>

                @else

                    <div class="mt-5 px-4 py-3 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-400">
                            No document uploaded.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- Account Information --}}
    <div class="mt-6 bg-white rounded-xl shadow-sm
                border border-gray-100 p-6">

        <h3 class="text-lg font-semibold text-eco-dark mb-5">
            Account Information
        </h3>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            {{-- Registered --}}
            <div>

                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    Registered
                </p>

                <p class="mt-1 text-gray-800">
                    {{ $resident->created_at?->format('M d, Y h:i A') ?? '—' }}
                </p>

            </div>


            {{-- Last Updated --}}
            <div>

                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    Last Updated
                </p>

                <p class="mt-1 text-gray-800">
                    {{ $resident->updated_at?->format('M d, Y h:i A') ?? '—' }}
                </p>

            </div>

        </div>

    </div>

</x-admin-layout>