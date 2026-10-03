<x-admin-layout>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-eco-dark">
            Dashboard
        </h2>

        <p class="text-gray-500">
            Welcome to EcoTrack LGU Administration.
        </p>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Total Residents --}}
        <a
            href="{{ route('admin.residents.index') }}"
            class="bg-white p-6 rounded-lg shadow-sm
                   hover:shadow-md hover:-translate-y-1
                   transition duration-200
                   border border-transparent hover:border-eco-green"
        >
            <p class="text-sm text-gray-500">
                Total Residents
            </p>

            <p class="text-3xl font-bold text-eco-dark mt-2">
                {{ $totalResidents }}
            </p>

            <p class="text-xs text-eco-green mt-3">
                View residents →
            </p>
        </a>


        {{-- Pending Verification --}}
        <a
            href="{{ route('admin.residents.index', ['status' => 'pending']) }}"
            class="bg-white p-6 rounded-lg shadow-sm
                   hover:shadow-md hover:-translate-y-1
                   transition duration-200
                   border border-transparent hover:border-eco-green"
        >
            <p class="text-sm text-gray-500">
                Pending Verification
            </p>

            <p class="text-3xl font-bold text-eco-green mt-2">
                {{ $pendingVerification }}
            </p>

            <p class="text-xs text-eco-green mt-3">
                Review pending residents →
            </p>
        </a>


        {{-- Collection Schedules --}}
        <a
            href="{{ route('admin.collection-schedules.index') }}"
            class="bg-white p-6 rounded-lg shadow-sm
                   hover:shadow-md hover:-translate-y-1
                   transition duration-200
                   border border-transparent hover:border-eco-green"
        >
            <p class="text-sm text-gray-500">
                Collection Schedules
            </p>

            <p class="text-3xl font-bold text-eco-dark mt-2">
                {{ $collectionSchedules }}
            </p>

            <p class="text-xs text-eco-green mt-3">
                Manage schedules →
            </p>
        </a>


        {{-- Announcements --}}
        <a
            href="{{ route('admin.announcements.index') }}"
            class="bg-white p-6 rounded-lg shadow-sm
                   hover:shadow-md hover:-translate-y-1
                   transition duration-200
                   border border-transparent hover:border-eco-green"
        >
            <p class="text-sm text-gray-500">
                Announcements
            </p>

            <p class="text-3xl font-bold text-eco-dark mt-2">
                {{ $announcements }}
            </p>

            <p class="text-xs text-eco-green mt-3">
                Manage announcements →
            </p>
        </a>


        {{-- Barangays --}}
        <a
            href="{{ route('admin.barangays.index') }}"
            class="bg-white p-6 rounded-lg shadow-sm
                   hover:shadow-md hover:-translate-y-1
                   transition duration-200
                   border border-transparent hover:border-eco-green"
        >
            <p class="text-sm text-gray-500">
                Barangays
            </p>

            <p class="text-3xl font-bold text-eco-dark mt-2">
                —
            </p>

            <p class="text-xs text-eco-green mt-3">
                Manage barangays →
            </p>
        </a>

    </div>


    {{-- Quick Access --}}
    <div class="mt-8">

        <h3 class="text-lg font-semibold text-eco-dark mb-4">
            Quick Access
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- SMS --}}
            <a
                href="{{ route('admin.sms.index') }}"
                class="bg-white p-5 rounded-lg shadow-sm
                       border border-gray-100
                       hover:shadow-md hover:-translate-y-1
                       hover:border-eco-green
                       transition"
            >
                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-lg bg-eco-light
                                flex items-center justify-center">

                        <span class="text-eco-dark text-lg">
                            SMS
                        </span>

                    </div>

                    <div>
                        <p class="font-semibold text-gray-800">
                            SMS Notifications
                        </p>

                        <p class="text-sm text-gray-500">
                            Manage SMS messages
                        </p>
                    </div>

                </div>
            </a>


            {{-- Audit Logs --}}
            <a
                href="{{ route('admin.audit-logs.index') }}"
                class="bg-white p-5 rounded-lg shadow-sm
                       border border-gray-100
                       hover:shadow-md hover:-translate-y-1
                       hover:border-eco-green
                       transition"
            >
                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-lg bg-eco-light
                                flex items-center justify-center">

                        <span class="text-eco-dark text-lg">
                            LOG
                        </span>

                    </div>

                    <div>
                        <p class="font-semibold text-gray-800">
                            Audit Logs
                        </p>

                        <p class="text-sm text-gray-500">
                            View system activity
                        </p>
                    </div>

                </div>
            </a>


            {{-- Profile --}}
            <a
                href="{{ route('profile.edit') }}"
                class="bg-white p-5 rounded-lg shadow-sm
                       border border-gray-100
                       hover:shadow-md hover:-translate-y-1
                       hover:border-eco-green
                       transition"
            >
                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-lg bg-eco-light
                                flex items-center justify-center">

                        <span class="text-eco-dark text-lg">
                            ⚙
                        </span>

                    </div>

                    <div>
                        <p class="font-semibold text-gray-800">
                            Settings / Profile
                        </p>

                        <p class="text-sm text-gray-500">
                            Manage your account
                        </p>
                    </div>

                </div>
            </a>

        </div>

    </div>

</x-admin-layout>