<x-layouts.resident>

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#1B4332]">
            My Profile
        </h1>

        <p class="mt-1 text-gray-500">
            View your EcoTrack resident account information.
        </p>
    </div>


    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">

            <div
                class="w-16 h-16 rounded-full
                       bg-[#2D6A4F] text-white
                       flex items-center justify-center
                       text-2xl font-bold"
            >
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div>
                <h2 class="text-xl font-bold text-[#1B4332]">
                    {{ auth()->user()->name }}
                </h2>

                <p class="text-sm text-gray-500">
                    EcoTrack Resident
                </p>
            </div>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">

            <div>
                <p class="text-sm text-gray-500">
                    Full Name
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Email Address
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ auth()->user()->email }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Mobile Number
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ auth()->user()->mobile_number ?? '—' }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Barangay
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ auth()->user()->barangay?->name ?? '—' }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Zone
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ auth()->user()->zone ?? '—' }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Account Status
                </p>

                <p class="mt-1 font-semibold text-[#2D6A4F]">
                    {{ ucfirst(auth()->user()->status ?? '—') }}
                </p>
            </div>


            <div class="md:col-span-2">

                <p class="text-sm text-gray-500">
                    Complete Address
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ auth()->user()->address ?? '—' }}
                </p>

            </div>

        </div>

    </div>

</x-layouts.resident>