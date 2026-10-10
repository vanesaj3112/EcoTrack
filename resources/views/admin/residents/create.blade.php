<x-admin-layout>

    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Add Resident
                </h1>

                <p class="mt-1 text-gray-500">
                    Create a new resident account.
                </p>
            </div>

            <a
                href="{{ route('admin.residents.index') }}"
                class="inline-flex items-center px-4 py-2
                       rounded-lg border border-gray-300
                       text-sm font-medium text-gray-700
                       hover:bg-gray-50"
            >
                ← Back to Residents
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
            <p class="font-semibold text-red-700 mb-2">
                Please fix the following errors:
            </p>

            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">
                Resident Information
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Enter the resident's basic account and address information.
            </p>
        </div>

        <form
            method="POST"
            action="{{ route('admin.residents.store') }}"
            class="p-6"
        >
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Name --}}
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Full Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                        placeholder="Enter full name"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Email Address
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                        placeholder="resident@example.com"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Mobile --}}
                <div>
                    <label
                        for="mobile_number"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Mobile Number
                    </label>

                    <input
                        id="mobile_number"
                        type="text"
                        name="mobile_number"
                        value="{{ old('mobile_number') }}"
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                        placeholder="09XXXXXXXXX"
                    >

                    @error('mobile_number')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Barangay --}}
                <div>
                    <label
                        for="brgy_id"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Barangay
                    </label>

                    <select
                        id="brgy_id"
                        name="brgy_id"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                    >
                        <option value="">Select Barangay</option>

                        @foreach ($barangays as $barangay)
                            <option
                                value="{{ $barangay->id }}"
                                {{ old('brgy_id') == $barangay->id ? 'selected' : '' }}
                            >
                                {{ $barangay->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('brgy_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Zone --}}
                <div>
                    <label
                        for="zone"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Zone
                    </label>

                    <input
                        id="zone"
                        type="text"
                        name="zone"
                        value="{{ old('zone') }}"
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                        placeholder="Example: Zone 1"
                    >

                    @error('zone')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Address --}}
                <div>
                    <label
                        for="address"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Address
                    </label>

                    <input
                        id="address"
                        type="text"
                        name="address"
                        value="{{ old('address') }}"
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                        placeholder="House number / street"
                    >

                    @error('address')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Account Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                    >
                        <option
                            value="approved"
                            {{ old('status', 'approved') === 'approved' ? 'selected' : '' }}
                        >
                            Approved
                        </option>

                        <option
                            value="pending"
                            {{ old('status') === 'pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                        placeholder="Enter password"
                    >

                    @error('password')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Confirm Password
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green
                               focus:ring-eco-green"
                        placeholder="Confirm password"
                    >
                </div>

            </div>

            <div class="mt-8 flex items-center justify-end gap-3">

                <a
                    href="{{ route('admin.residents.index') }}"
                    class="px-5 py-2.5 rounded-lg border border-gray-300
                           text-sm font-medium text-gray-700
                           hover:bg-gray-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg
                           bg-[#2D6A4F] text-white
                           text-sm font-semibold
                           hover:bg-[#1B4332]
                           transition"
                >
                    Add Resident
                </button>

            </div>

        </form>

    </div>

</x-admin-layout>