<x-admin-layout>

    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="text-sm font-semibold text-[#2D6A4F]">
                    EcoTrack Collection Management
                </p>

                <h1 class="mt-1 text-3xl font-bold text-[#1B4332]">
                    Garbage Collectors
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Manage garbage collector accounts and their access to EcoTrack.
                </p>
            </div>

            <a
                href="{{ route('admin.garbage-collectors.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1B4332] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2D6A4F]"
            >
                <span class="text-lg">+</span>
                Add Garbage Collector
            </a>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div
                class="rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4 text-sm font-medium text-[#1B4332]"
            >
                {{ session('success') }}
            </div>

        @endif


        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div
                class="rounded-xl border border-red-200 bg-red-50 px-5 py-4"
            >
                <p class="font-semibold text-red-700">
                    Please check the following:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- COLLECTOR TABLE --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-6 py-5">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-[#1B4332]">
                            Collector Accounts
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $collectors->count() }}
                            {{ $collectors->count() === 1 ? 'collector' : 'collectors' }}
                            registered
                        </p>
                    </div>

                </div>

            </div>


            @if ($collectors->count())

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-100">

                        <thead class="bg-[#F5F7F6]">

                            <tr>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Collector
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Email
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Mobile
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Status
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @foreach ($collectors as $collector)

                                <tr class="transition hover:bg-[#F5F7F6]">

                                    {{-- NAME --}}
                                    <td class="whitespace-nowrap px-6 py-5">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-full bg-[#D8F3DC] font-bold text-[#1B4332]"
                                            >
                                                {{ strtoupper(substr($collector->name, 0, 1)) }}
                                            </div>

                                            <div>

                                                <p class="font-semibold text-[#1B4332]">
                                                    {{ $collector->name }}
                                                </p>

                                                <p class="text-xs text-gray-400">
                                                    Collector ID #{{ $collector->id }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- EMAIL --}}
                                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                        {{ $collector->email }}
                                    </td>


                                    {{-- MOBILE --}}
                                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                        {{ $collector->mobile_number ?? '—' }}
                                    </td>


                                    {{-- STATUS --}}
                                    <td class="whitespace-nowrap px-6 py-5">

                                        @if ($collector->status === 'approved')

                                            <span
                                                class="inline-flex items-center rounded-full bg-[#D8F3DC] px-3 py-1 text-xs font-semibold text-[#1B4332]"
                                            >
                                                <span class="mr-1.5 h-2 w-2 rounded-full bg-[#2D6A4F]"></span>
                                                Active
                                            </span>

                                        @elseif ($collector->status === 'pending')

                                            <span
                                                class="inline-flex items-center rounded-full bg-[#FFF3CD] px-3 py-1 text-xs font-semibold text-[#856404]"
                                            >
                                                <span class="mr-1.5 h-2 w-2 rounded-full bg-[#E9C46A]"></span>
                                                Pending
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-[#D64045]"
                                            >
                                                <span class="mr-1.5 h-2 w-2 rounded-full bg-[#D64045]"></span>
                                                Inactive
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ACTIONS --}}
                                    <td class="whitespace-nowrap px-6 py-5">

                                        <div class="flex items-center justify-end gap-2">

                                            <a
                                                href="{{ route('admin.garbage-collectors.edit', $collector) }}"
                                                class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-[#B7E4C7] hover:bg-[#D8F3DC] hover:text-[#1B4332]"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="{{ route('admin.garbage-collectors.destroy', $collector) }}"
                                                onsubmit="return confirm('Delete this garbage collector account?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-[#D64045] transition hover:bg-red-50"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- EMPTY STATE --}}
                <div class="px-6 py-16 text-center">

                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#D8F3DC]"
                    >

                        <svg
                            class="h-8 w-8 text-[#2D6A4F]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 11h14M7 11V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v4M5 11v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7M9 15h.01M15 15h.01"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-4 text-lg font-bold text-[#1B4332]">
                        No Garbage Collectors Found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Create a garbage collector account to assign collectors to collection schedules.
                    </p>

                    <a
                        href="{{ route('admin.garbage-collectors.create') }}"
                        class="mt-6 inline-flex items-center rounded-xl bg-[#1B4332] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2D6A4F]"
                    >
                        Add Garbage Collector
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-admin-layout>