<x-layouts.resident>

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#1B4332]">
            My Profile
        </h1>

        <p class="mt-1 text-gray-500">
            Manage your EcoTrack resident account information.
        </p>
    </div>


    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4 text-[#1B4332]">
            <div class="flex items-center gap-3">
                <span class="text-lg">✓</span>

                <p class="font-medium">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif


    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">
            <p class="font-semibold text-red-700 mb-2">
                Please fix the following:
            </p>

            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Profile Header --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6">

        <div class="flex flex-col sm:flex-row sm:items-center gap-4">

            {{-- Profile Photo --}}
            <div class="flex-shrink-0">

                @if ($resident->profile_photo)

                    <img
                        src="{{ asset('storage/' . $resident->profile_photo) }}"
                        alt="{{ $resident->name }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-[#D8F3DC]"
                    >

                @else

                    <div
                        class="w-20 h-20 rounded-full
                               bg-[#2D6A4F] text-white
                               flex items-center justify-center
                               text-3xl font-bold"
                    >
                        {{ strtoupper(substr($resident->name, 0, 1)) }}
                    </div>

                @endif

            </div>


            {{-- Profile Information --}}
            <div>

                <h2 class="text-2xl font-bold text-[#1B4332]">
                    {{ $resident->name }}
                </h2>

                <p class="text-sm text-gray-500">
                    EcoTrack Resident
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $resident->email }}
                </p>

            </div>

        </div>

    </div>


    {{-- Edit Profile Form --}}
    <form
        method="POST"
        action="{{ route('resident.profile.update') }}"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PATCH')


        {{-- Personal Information --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-[#1B4332]">
                    Personal Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Update your basic account information.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- Full Name --}}
                <div>

                    <label
                        for="name"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Full Name
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $resident->name) }}"
                        required
                        autocomplete="name"
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3
                               text-gray-800
                               focus:border-[#2D6A4F]
                               focus:ring-2
                               focus:ring-[#B7E4C7]
                               focus:outline-none"
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
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Email Address
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $resident->email) }}"
                        required
                        autocomplete="email"
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3
                               text-gray-800
                               focus:border-[#2D6A4F]
                               focus:ring-2
                               focus:ring-[#B7E4C7]
                               focus:outline-none"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Mobile Number --}}
                <div>

                    <label
                        for="mobile_number"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Mobile Number
                    </label>

                    <input
                        id="mobile_number"
                        name="mobile_number"
                        type="text"
                        value="{{ old('mobile_number', $resident->mobile_number) }}"
                        autocomplete="tel"
                        placeholder="09XXXXXXXXX"
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3
                               text-gray-800
                               focus:border-[#2D6A4F]
                               focus:ring-2
                               focus:ring-[#B7E4C7]
                               focus:outline-none"
                    >

                    @error('mobile_number')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Address --}}
                <div>

                    <label
                        for="address"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Complete Address
                    </label>

                    <input
                        id="address"
                        name="address"
                        type="text"
                        value="{{ old('address', $resident->address) }}"
                        autocomplete="street-address"
                        placeholder="House No., Street, Sitio/Purok"
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3
                               text-gray-800
                               focus:border-[#2D6A4F]
                               focus:ring-2
                               focus:ring-[#B7E4C7]
                               focus:outline-none"
                    >

                    @error('address')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


            </div>

        </div>


        {{-- Profile Photo --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-[#1B4332]">
                    Profile Photo
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Upload a new profile photo for your EcoTrack account.
                </p>

            </div>


            <div>

                <label
                    for="profile_photo"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Choose Photo
                </label>

                <input
                    id="profile_photo"
                    name="profile_photo"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full rounded-xl border border-gray-300
                           bg-white
                           px-4 py-3
                           text-sm text-gray-700
                           focus:border-[#2D6A4F]
                           focus:ring-2
                           focus:ring-[#B7E4C7]
                           focus:outline-none"
                >

                <p class="mt-2 text-xs text-gray-500">
                    JPG, JPEG, PNG, or WEBP. Maximum file size: 2MB.
                </p>

                @error('profile_photo')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>


        {{-- Account Information --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-[#1B4332]">
                    Account Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    These details are managed by the LGU.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- Barangay --}}
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Barangay
                    </label>

                    <div
                        class="w-full rounded-xl
                               border border-gray-200
                               bg-gray-50
                               px-4 py-3
                               text-gray-700"
                    >
                        {{ $resident->barangay?->name ?? '—' }}
                    </div>

                </div>


                {{-- Zone --}}
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Zone
                    </label>

                    <div
                        class="w-full rounded-xl
                               border border-gray-200
                               bg-gray-50
                               px-4 py-3
                               text-gray-700"
                    >
                        {{ $resident->zone ?? '—' }}
                    </div>

                </div>


                {{-- Account Status --}}
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Account Status
                    </label>

                    <div
                        class="w-full rounded-xl
                               border border-[#B7E4C7]
                               bg-[#D8F3DC]
                               px-4 py-3
                               font-semibold text-[#1B4332]"
                    >
                        {{ ucfirst($resident->status ?? '—') }}
                    </div>

                </div>


                {{-- Role --}}
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Account Type
                    </label>

                    <div
                        class="w-full rounded-xl
                               border border-gray-200
                               bg-gray-50
                               px-4 py-3
                               text-gray-700"
                    >
                        Resident
                    </div>

                </div>


            </div>

        </div>


        {{-- Change Password --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-[#1B4332]">
                    Change Password
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Leave these fields blank if you do not want to change your password.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- New Password --}}
                <div>

                    <label
                        for="password"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        New Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3
                               text-gray-800
                               focus:border-[#2D6A4F]
                               focus:ring-2
                               focus:ring-[#B7E4C7]
                               focus:outline-none"
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
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Confirm New Password
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3
                               text-gray-800
                               focus:border-[#2D6A4F]
                               focus:ring-2
                               focus:ring-[#B7E4C7]
                               focus:outline-none"
                    >

                </div>


            </div>

        </div>


        {{-- Save Button --}}
        <div class="flex justify-end">

            <button
                type="submit"
                class="inline-flex items-center justify-center
                       rounded-xl
                       bg-[#2D6A4F]
                       px-6 py-3
                       font-semibold
                       text-white
                       shadow-sm
                       hover:bg-[#1B4332]
                       transition
                       focus:outline-none
                       focus:ring-2
                       focus:ring-[#B7E4C7]
                       focus:ring-offset-2"
            >
                Save Changes
            </button>

        </div>

    </form>

</x-layouts.resident>