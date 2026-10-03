<x-admin-layout>

    <div class="mb-8">

        <h1 class="text-2xl font-bold text-gray-800">
            Audit Logs
        </h1>

        <p class="mt-1 text-gray-500">
            Monitor important activities performed in the EcoTrack system.
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                System Activity Logs
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Recorded system activities will appear here.
            </p>

        </div>


        @if ($logs->count())

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>

                            <th class="px-6 py-4 text-left font-semibold text-gray-600">
                                User
                            </th>

                            <th class="px-6 py-4 text-left font-semibold text-gray-600">
                                Action
                            </th>

                            <th class="px-6 py-4 text-left font-semibold text-gray-600">
                                Description
                            </th>

                            <th class="px-6 py-4 text-left font-semibold text-gray-600">
                                IP Address
                            </th>

                            <th class="px-6 py-4 text-left font-semibold text-gray-600">
                                Date & Time
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach ($logs as $log)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4">

                                    <div class="font-medium text-gray-800">
                                        {{ $log->user->name ?? 'Unknown User' }}
                                    </div>

                                    @if ($log->user)
                                        <div class="text-xs text-gray-500">
                                            {{ $log->user->email }}
                                        </div>
                                    @endif

                                </td>


                                <td class="px-6 py-4">

                                    <span class="inline-flex px-2.5 py-1 rounded-full
                                                 bg-[#D8F3DC]
                                                 text-[#1B4332]
                                                 text-xs font-semibold">
                                        {{ $log->action }}
                                    </span>

                                </td>


                                <td class="px-6 py-4 text-gray-600">

                                    {{ $log->description ?? '—' }}

                                </td>


                                <td class="px-6 py-4 text-gray-500">

                                    {{ $log->ip_address ?? '—' }}

                                </td>


                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">

                                    {{ $log->created_at?->format('M d, Y h:i A') }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="py-14 text-center">

                <div class="mx-auto w-16 h-16 rounded-full
                            bg-[#D8F3DC]
                            flex items-center justify-center">

                    <span class="text-2xl">📋</span>

                </div>

                <h3 class="mt-5 text-lg font-semibold text-gray-800">
                    No audit logs yet
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    System activity will appear here once actions are recorded.
                </p>

            </div>

        @endif

    </div>

</x-admin-layout>
