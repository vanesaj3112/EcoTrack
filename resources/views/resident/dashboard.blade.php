<x-layouts.resident>

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-2xl font-bold text-eco-dark">
            Resident Dashboard
        </h1>

        <p class="mt-1 text-gray-500">
            Welcome, {{ auth()->user()->name }}.
        </p>

    </div>


    {{-- Dashboard Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Account Status --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-100 p-6">

            <p class="text-sm text-gray-500">
                Account Status
            </p>

            @if (auth()->user()->status === 'approved')

                <p class="mt-2 text-xl font-bold text-eco-green">
                    Approved
                </p>

            @elseif (auth()->user()->status === 'rejected')

                <p class="mt-2 text-xl font-bold text-red-600">
                    Rejected
                </p>

            @else

                <p class="mt-2 text-xl font-bold text-yellow-600">
                    Pending
                </p>

            @endif

        </div>


        {{-- Barangay --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-100 p-6">

            <p class="text-sm text-gray-500">
                My Barangay
            </p>

            <p class="mt-2 text-xl font-bold text-eco-dark">
                {{ auth()->user()->barangay?->name ?? 'Not assigned' }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Zone: {{ auth()->user()->zone ?? 'Not assigned' }}
            </p>

        </div>


        {{-- Collection Schedule --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-100 p-6">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-lg bg-eco-light
                            flex items-center justify-center">
                    📅
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Collection Schedule
                    </p>

                    <p class="mt-1 text-lg font-semibold text-gray-800">
                        No schedule yet
                    </p>
                </div>

            </div>

        </div>


        {{-- Announcements --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-100 p-6">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-lg bg-eco-light
                            flex items-center justify-center">
                    📢
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

    </div>

</x-layouts.resident>