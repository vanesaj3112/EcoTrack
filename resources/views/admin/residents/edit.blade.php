<x-admin-layout>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-eco-dark">
                Edit Resident
            </h2>

            <p class="text-gray-500 mt-1">
                Update resident registration information.
            </p>
        </div>

        <a
            href="{{ route('admin.residents.show', $resident) }}"
            class="w-full sm:w-auto inline-flex items-center justify-center
                   px-4 py-2.5 rounded-lg
                   bg-gray-100 text-gray-700
                   hover:bg-gray-200 transition"
        >
            ← Back to Details
        </a>

    </div>


    {{-- Edit Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <form
            method="POST"
            action="{{ route('admin.residents.update', $resident) }}"
        >

            @csrf
            @method('PUT')


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Full Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $resident->name) }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green focus:ring-eco-green"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $resident->email) }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green focus:ring-eco-green"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Mobile --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mobile Number
                    </label>

                    <input
                        type="text"
                        name="mobile_number"
                        value="{{ old('mobile_number', $resident->mobile_number) }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green focus:ring-eco-green"
                    >

                    @error('mobile_number')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Zone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Zone
                    </label>

                    <input
                        type="text"
                        name="zone"
                        value="{{ old('zone', $resident->zone) }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green focus:ring-eco-green"
                    >

                    @error('zone')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Barangay --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Barangay
                    </label>

                    <select
                        name="brgy_id"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green focus:ring-eco-green"
                    >
                        @foreach (\App\Models\Barangay::orderBy('name')->get() as $barangay)

                            <option
                                value="{{ $barangay->id }}"
                                @selected(
                                    old('brgy_id', $resident->brgy_id) == $barangay->id
                                )
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


                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Account Status
                    </label>

                    <select
                        name="status"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green focus:ring-eco-green"
                    >
                        <option
                            value="pending"
                            @selected(old('status', $resident->status) === 'pending')
                        >
                            Pending
                        </option>

                        <option
                            value="approved"
                            @selected(old('status', $resident->status) === 'approved')
                        >
                            Approved
                        </option>

                        <option
                            value="rejected"
                            @selected(old('status', $resident->status) === 'rejected')
                        >
                            Rejected
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Complete Address
                    </label>

                    <textarea
                        name="address"
                        rows="4"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-eco-green focus:ring-eco-green"
                    >{{ old('address', $resident->address) }}</textarea>

                    @error('address')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- Actions --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:justify-end">

                <a
                    href="{{ route('admin.residents.show', $resident) }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center
                           px-5 py-2.5 rounded-lg
                           bg-gray-100 text-gray-700
                           hover:bg-gray-200 transition"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center
                           px-5 py-2.5 rounded-lg
                           bg-eco-green text-white
                           font-medium
                           hover:bg-eco-dark transition"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</x-admin-layout>s