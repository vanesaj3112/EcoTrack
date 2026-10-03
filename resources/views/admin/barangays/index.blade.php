<x-admin-layout>

    {{-- Page Header --}}
    <div class="mb-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Barangays
                </h1>

                <p class="mt-1 text-gray-500">
                    Manage barangays registered in EcoTrack.
                </p>
            </div>

        </div>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-5 py-4 text-red-700">

            <ul class="list-disc list-inside text-sm">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- Add Barangay --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">

        <div class="mb-4">

            <h2 class="text-lg font-semibold text-gray-800">
                Add Barangay
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Add a new barangay to the EcoTrack system.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('admin.barangays.store') }}"
            class="flex flex-col sm:flex-row gap-3"
        >

            @csrf

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter barangay name"
                required
                class="flex-1 rounded-lg border-gray-300
                       focus:border-[#2D6A4F]
                       focus:ring-[#2D6A4F]"
            >

            <button
                type="submit"
                class="px-5 py-2.5 rounded-lg
                       bg-[#2D6A4F]
                       text-white font-medium
                       hover:bg-[#1B4332]
                       transition"
            >
                + Add Barangay
            </button>

        </form>

    </div>


    {{-- Registered Barangays --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800">
                        Registered Barangays
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Barangays available in the EcoTrack system.
                    </p>

                </div>

                <div class="text-sm text-gray-500">
                    Total:
                    <span class="font-semibold text-[#1B4332]">
                        {{ $barangays->count() }}
                    </span>
                </div>

            </div>

        </div>


        @if ($barangays->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-gray-50 border-b">

                        <tr>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                #
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Barangay Name
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Added
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach ($barangays as $barangay)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $loop->iteration }}
                                </td>


                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="w-10 h-10 rounded-lg
                                                    bg-[#D8F3DC]
                                                    flex items-center justify-center">

                                            <span>
                                                🏘️
                                            </span>

                                        </div>

                                        <div>

                                            <p class="font-semibold text-gray-800">
                                                {{ $barangay->name }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                Barangay ID: {{ $barangay->id }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $barangay->created_at?->format('M d, Y') ?? '—' }}
                                </td>


                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        {{-- Edit --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.barangays.update', $barangay) }}"
                                            class="flex gap-2"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ $barangay->name }}"
                                                required
                                                class="w-40 rounded-lg border-gray-300
                                                       text-sm
                                                       focus:border-[#2D6A4F]
                                                       focus:ring-[#2D6A4F]"
                                            >

                                            <button
                                                type="submit"
                                                class="px-3 py-1.5 rounded-lg
                                                       text-sm font-medium
                                                       bg-[#D8F3DC]
                                                       text-[#1B4332]
                                                       hover:bg-[#B7E4C7]
                                                       transition"
                                            >
                                                Save
                                            </button>

                                        </form>


                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.barangays.destroy', $barangay) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this barangay?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-3 py-1.5 rounded-lg
                                                       text-sm font-medium
                                                       bg-red-50 text-red-600
                                                       hover:bg-red-100
                                                       transition"
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

            <div class="px-6 py-16 text-center">

                <div class="mx-auto w-16 h-16 rounded-full
                            bg-[#D8F3DC]
                            flex items-center justify-center">

                    <span class="text-2xl">
                        🏘️
                    </span>

                </div>

                <h3 class="mt-5 text-lg font-semibold text-gray-800">
                    No barangays yet
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Add a barangay using the form above.
                </p>

            </div>

        @endif

    </div>

</x-admin-layout>