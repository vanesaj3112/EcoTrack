<x-admin-layout>

    <div class="mb-8">

        <h1 class="text-2xl font-bold text-gray-800">
            SMS Notifications
        </h1>

        <p class="mt-1 text-gray-500">
            Manage SMS notifications sent to EcoTrack residents.
        </p>

    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                SMS Notification Center
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Send and monitor garbage collection notifications.
            </p>

        </div>

        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="border border-gray-100 rounded-xl p-5">
                    <p class="text-sm text-gray-500">
                        Total Messages
                    </p>

                    <p class="text-3xl font-bold text-[#1B4332] mt-2">
                        0
                    </p>
                </div>

                <div class="border border-gray-100 rounded-xl p-5">
                    <p class="text-sm text-gray-500">
                        Sent
                    </p>

                    <p class="text-3xl font-bold text-[#2D6A4F] mt-2">
                        0
                    </p>
                </div>

                <div class="border border-gray-100 rounded-xl p-5">
                    <p class="text-sm text-gray-500">
                        Failed
                    </p>

                    <p class="text-3xl font-bold text-red-600 mt-2">
                        0
                    </p>
                </div>

            </div>

            <div class="mt-8 py-12 text-center">

                <div class="mx-auto w-16 h-16 rounded-full
                            bg-[#D8F3DC]
                            flex items-center justify-center">

                    <span class="text-2xl">📱</span>

                </div>

                <h3 class="mt-5 text-lg font-semibold text-gray-800">
                    No SMS notifications yet
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    SMS activity will appear here once notifications are sent.
                </p>

            </div>

        </div>

    </div>

</x-admin-layout>