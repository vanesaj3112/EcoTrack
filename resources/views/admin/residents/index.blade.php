<x-admin-layout>

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-eco-dark">
                Residents
            </h2>

            <p class="text-gray-500 mt-1">
                Manage registered EcoTrack residents.
            </p>
        </div>

        {{-- Add Resident --}}
        <a
            href="{{ route('admin.residents.create') }}"
            class="w-full md:w-auto inline-flex items-center justify-center
                   gap-2 px-5 py-2.5 rounded-lg
                   bg-eco-dark text-white font-medium
                   hover:bg-eco-green transition shadow-sm"
        >
            <span class="text-lg">+</span>
            Add Resident
        </a>

    </div>


    {{-- Resident Statistics --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-6">

        {{-- Total --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">
                Total Residents
            </p>

            <p class="text-3xl font-bold text-eco-dark mt-2">
                {{ $residents->count() }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Registered residents
            </p>
        </div>


        {{-- Pending --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">
                Pending Verification
            </p>

            <p class="text-3xl font-bold text-eco-green mt-2">
                {{ $residents->where('status', 'pending')->count() }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Waiting for review
            </p>
        </div>


        {{-- Approved --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">
                Approved
            </p>

            <p class="text-3xl font-bold text-eco-green mt-2">
                {{ $residents->where('status', 'approved')->count() }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Verified residents
            </p>
        </div>


        {{-- Rejected --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">
                Rejected
            </p>

            <p class="text-3xl font-bold text-eco-dark mt-2">
                {{ $residents->where('status', 'rejected')->count() }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Rejected applications
            </p>
        </div>

    </div>


    {{-- Residents Management --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header + Search --}}
        <div class="px-4 sm:px-6 py-5 border-b border-gray-100">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <div>
                    <h3 class="text-lg font-semibold text-eco-dark">
                        Registered Residents
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Manage residents registered in the EcoTrack system.
                    </p>
                </div>


                {{-- Search / Filter --}}
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                    <input
                        type="text"
                        placeholder="Search resident..."
                        class="w-full sm:w-64 rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                    >

                    <select
                        class="w-full sm:w-40 rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                    >
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>

                </div>

            </div>

        </div>


        {{-- Residents --}}
        @if ($residents->count() > 0)

            {{-- ========================= --}}
            {{-- DESKTOP TABLE --}}
            {{-- ========================= --}}
            <div class="hidden md:block overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-gray-50 border-b">

                        <tr>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Resident
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Email
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Barangay
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Zone
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Status
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach ($residents as $resident)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- Resident --}}
                                <td class="px-6 py-4">

                                    <div class="font-medium text-gray-800">
                                        {{ $resident->name }}
                                    </div>

                                </td>


                                {{-- Email --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $resident->email }}
                                </td>


                                {{-- Barangay --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $resident->barangay?->name ?? '—' }}
                                </td>


                                {{-- Zone --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $resident->zone ?? '—' }}
                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($resident->status === 'approved')

                                        <span class="inline-flex px-3 py-1 rounded-full
                                                     text-xs font-semibold
                                                     bg-eco-light text-eco-dark">
                                            Approved
                                        </span>

                                    @elseif ($resident->status === 'rejected')

                                        <span class="inline-flex px-3 py-1 rounded-full
                                                     text-xs font-semibold
                                                     bg-gray-100 text-gray-700">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="inline-flex px-3 py-1 rounded-full
                                                     text-xs font-semibold
                                                     bg-eco-light text-eco-green">
                                            Pending
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('admin.residents.show', $resident) }}"
                                            class="px-4 py-2 rounded-lg
                                                   text-sm font-medium
                                                   bg-gray-100 text-gray-700
                                                   hover:bg-gray-200
                                                   transition"
                                        >
                                            View
                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('admin.residents.edit', $resident) }}"
                                            class="px-4 py-2 rounded-lg
                                                   text-sm font-medium
                                                   bg-eco-light text-eco-dark
                                                   hover:bg-eco-green
                                                   hover:text-white
                                                   transition"
                                        >
                                            Edit
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ========================= --}}
            {{-- MOBILE CARDS --}}
            {{-- ========================= --}}
            <div class="md:hidden divide-y divide-gray-100">

                @foreach ($residents as $resident)

                    <div class="p-4 sm:p-5">

                        {{-- Resident Name --}}
                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <h4 class="font-semibold text-gray-800 truncate">
                                    {{ $resident->name }}
                                </h4>

                                <p class="text-sm text-gray-500 break-all mt-1">
                                    {{ $resident->email }}
                                </p>

                            </div>


                            {{-- Status --}}
                            <div class="shrink-0">

                                @if ($resident->status === 'approved')

                                    <span class="inline-flex px-2.5 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-eco-light text-eco-dark">
                                        Approved
                                    </span>

                                @elseif ($resident->status === 'rejected')

                                    <span class="inline-flex px-2.5 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-gray-100 text-gray-700">
                                        Rejected
                                    </span>

                                @else

                                    <span class="inline-flex px-2.5 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-eco-light text-eco-green">
                                        Pending
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Resident Details --}}
                        <div class="grid grid-cols-2 gap-4 mt-4">

                            <div>

                                <p class="text-xs text-gray-400 uppercase tracking-wide">
                                    Barangay
                                </p>

                                <p class="text-sm text-gray-700 mt-1">
                                    {{ $resident->barangay?->name ?? '—' }}
                                </p>

                            </div>


                            <div>

                                <p class="text-xs text-gray-400 uppercase tracking-wide">
                                    Zone
                                </p>

                                <p class="text-sm text-gray-700 mt-1">
                                    {{ $resident->zone ?? '—' }}
                                </p>

                            </div>

                        </div>


                        {{-- Mobile Actions --}}
                        <div class="grid grid-cols-2 gap-2 mt-5">

                            {{-- View --}}
                            <a
                                href="{{ route('admin.residents.show', $resident) }}"
                                class="w-full px-4 py-2.5 rounded-lg
                                       text-sm font-medium
                                       bg-gray-100 text-gray-700
                                       hover:bg-gray-200
                                       transition text-center"
                            >
                                View
                            </a>


                            {{-- Edit --}}
                            <a
                                href="{{ route('admin.residents.edit', $resident) }}"
                                class="w-full px-4 py-2.5 rounded-lg
                                       text-sm font-medium
                                       bg-eco-light text-eco-dark
                                       hover:bg-eco-green
                                       hover:text-white
                                       transition text-center"
                            >
                                Edit
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>


        @else

            {{-- Empty State --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto w-16 h-16 rounded-full
                            bg-eco-light
                            flex items-center justify-center">

                    <span class="text-2xl">
                        👥
                    </span>

                </div>

                <h3 class="mt-4 text-lg font-semibold text-gray-800">
                    No registered residents yet
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Residents who register for EcoTrack will appear here.
                </p>

            </div>

        @endif

    </div>

</x-admin-layout>