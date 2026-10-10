<x-layouts.resident>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-[#1B4332]">
                Report Concerns
            </h1>

            <p class="mt-1 text-gray-500">
                Report garbage collection problems or other concerns to the LGU.
            </p>
        </div>

        <a
            href="{{ route('resident.concerns.create') }}"
            class="inline-flex items-center justify-center
                   rounded-xl
                   bg-[#2D6A4F]
                   px-5 py-3
                   font-semibold
                   text-white
                   hover:bg-[#1B4332]
                   transition"
        >
            + Report Concern
        </a>

    </div>


    @if (session('success'))
        <div class="mb-6 rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4 text-[#1B4332]">
            {{ session('success') }}
        </div>
    @endif


    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-[#F5F7F6] border-b border-gray-200">

                    <tr>
                        <th class="px-5 py-4 text-left font-semibold text-gray-600">
                            Subject
                        </th>

                        <th class="px-5 py-4 text-left font-semibold text-gray-600">
                            Category
                        </th>

                        <th class="px-5 py-4 text-left font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="px-5 py-4 text-left font-semibold text-gray-600">
                            Submitted
                        </th>

                        <th class="px-5 py-4 text-right font-semibold text-gray-600">
                            Action
                        </th>
                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($concerns as $concern)

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4">
                                <p class="font-semibold text-[#1B4332]">
                                    {{ $concern->subject }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-gray-600">
                                {{ $concern->category }}
                            </td>

                            <td class="px-5 py-4">

                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'in_review' => 'bg-blue-100 text-blue-800',
                                        'resolved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $statusClasses[$concern->status] ?? 'bg-gray-100 text-gray-700' }}"
                                >
                                    {{ ucwords(str_replace('_', ' ', $concern->status)) }}
                                </span>

                            </td>

                            <td class="px-5 py-4 text-gray-500">
                                {{ $concern->created_at->format('M d, Y h:i A') }}
                            </td>

                            <td class="px-5 py-4 text-right">

                                <a
                                    href="{{ route('resident.concerns.show', $concern) }}"
                                    class="font-semibold text-[#2D6A4F] hover:text-[#1B4332]"
                                >
                                    View
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-5 py-12 text-center text-gray-500"
                            >
                                No concerns reported yet.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.resident>