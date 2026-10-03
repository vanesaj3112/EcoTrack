<x-guest-layout>

    <div
        class="min-h-screen flex items-center justify-center px-4 py-10 relative overflow-hidden"
        style="
            background-image:
                linear-gradient(
                    rgba(27, 67, 50, 0.55),
                    rgba(27, 67, 50, 0.55)
                ),
                url('{{ asset('images/abuyogbackground.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        "
    >

        <div class="w-full max-w-3xl relative z-10">

            {{-- EcoTrack Logo --}}
            <div class="flex justify-center mb-5">

                <div class="w-20 h-20 flex items-center justify-center">

                    <img
                        src="{{ asset('images/ecotrack.logo-removebg-preview.png') }}"
                        alt="EcoTrack Logo"
                        class="w-20 h-20 object-contain drop-shadow-2xl"
                    >

                </div>

            </div>


            {{-- Header --}}
            <div class="text-center mb-7">

                <h1 class="text-3xl sm:text-4xl font-extrabold text-white drop-shadow-lg">
                    Create Your EcoTrack Account
                </h1>

                <p class="mt-2 text-sm sm:text-base text-white/90 drop-shadow">
                    Register as a resident to access EcoTrack services
                </p>

            </div>


            {{-- Registration Card --}}
            <div
                class="bg-white/95 backdrop-blur-sm
                       rounded-2xl
                       shadow-2xl
                       border border-white/40
                       p-6 sm:p-8"
            >

                {{-- Validation Summary --}}
                @if ($errors->any())

                    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-4">

                        <p class="text-sm font-semibold text-red-700">
                            Please check the following errors:
                        </p>

                        <ul class="mt-2 text-sm text-red-600 list-disc list-inside">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('register') }}"
                    enctype="multipart/form-data"
                >

                    @csrf


                    {{-- ============================= --}}
                    {{-- PERSONAL INFORMATION --}}
                    {{-- ============================= --}}

                    <div class="flex items-center gap-3 mb-5">

                        <div
                            class="w-10 h-10 rounded-xl
                                   bg-[#D8F3DC]
                                   flex items-center justify-center
                                   text-[#1B4332]
                                   font-bold"
                        >
                            1
                        </div>

                        <div>

                            <h2 class="text-lg font-bold text-[#1B4332]">
                                Personal Information
                            </h2>

                            <p class="text-xs text-gray-500">
                                Enter your basic resident information
                            </p>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Full Name --}}
                        <div>

                            <x-input-label
                                for="name"
                                :value="__('Full Name')"
                                class="text-gray-700 font-semibold"
                            />

                            <x-text-input
                                id="name"
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Enter your full name"
                            />

                            <x-input-error
                                :messages="$errors->get('name')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Email --}}
                        <div>

                            <x-input-label
                                for="email"
                                :value="__('Email Address')"
                                class="text-gray-700 font-semibold"
                            />

                            <x-text-input
                                id="email"
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autocomplete="username"
                                placeholder="Enter your email"
                            />

                            <x-input-error
                                :messages="$errors->get('email')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Mobile Number --}}
                        <div>

                            <x-input-label
                                for="mobile_number"
                                :value="__('Mobile Number')"
                                class="text-gray-700 font-semibold"
                            />

                            <x-text-input
                                id="mobile_number"
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                                type="text"
                                name="mobile_number"
                                :value="old('mobile_number')"
                                required
                                autocomplete="tel"
                                placeholder="09XXXXXXXXX"
                            />

                            <x-input-error
                                :messages="$errors->get('mobile_number')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Barangay --}}
                        <div>

                            <x-input-label
                                for="brgy_id"
                                :value="__('Barangay')"
                                class="text-gray-700 font-semibold"
                            />

                            <select
                                id="brgy_id"
                                name="brgy_id"
                                required
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                            >

                                <option value="">
                                    Select your barangay
                                </option>

                                @foreach (\App\Models\Barangay::orderBy('name')->get() as $barangay)

                                    <option
                                        value="{{ $barangay->id }}"
                                        @selected(old('brgy_id') == $barangay->id)
                                    >
                                        {{ $barangay->name }}
                                    </option>

                                @endforeach

                            </select>

                            <x-input-error
                                :messages="$errors->get('brgy_id')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Zone --}}
                        <div>

                            <x-input-label
                                for="zone"
                                :value="__('Zone')"
                                class="text-gray-700 font-semibold"
                            />

                            <x-text-input
                                id="zone"
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                                type="text"
                                name="zone"
                                :value="old('zone')"
                                required
                                placeholder="Example: Zone 1"
                            />

                            <x-input-error
                                :messages="$errors->get('zone')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Complete Address --}}
                        <div class="md:col-span-2">

                            <x-input-label
                                for="address"
                                :value="__('Complete Address')"
                                class="text-gray-700 font-semibold"
                            />

                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                required
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                                placeholder="Enter your complete address"
                            >{{ old('address') }}</textarea>

                            <x-input-error
                                :messages="$errors->get('address')"
                                class="mt-2"
                            />

                        </div>

                    </div>


                    {{-- Divider --}}
                    <div class="border-t border-gray-200 my-8"></div>


                    {{-- ============================= --}}
                    {{-- VERIFICATION REQUIREMENTS --}}
                    {{-- ============================= --}}

                    <div class="flex items-center gap-3 mb-5">

                        <div
                            class="w-10 h-10 rounded-xl
                                   bg-[#D8F3DC]
                                   flex items-center justify-center
                                   text-[#1B4332]
                                   font-bold"
                        >
                            2
                        </div>

                        <div>

                            <h2 class="text-lg font-bold text-[#1B4332]">
                                Verification Requirements
                            </h2>

                            <p class="text-xs text-gray-500">
                                Documents required for LGU verification
                            </p>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Government ID --}}
                        <div>

                            <label
                                for="verification_document"
                                class="block text-sm font-semibold text-gray-700"
                            >
                                National ID / Government ID
                            </label>

                            <label
                                for="verification_document"
                                class="mt-2 flex flex-col items-center justify-center
                                       min-h-40
                                       w-full
                                       rounded-xl
                                       border-2 border-dashed
                                       border-gray-300
                                       bg-gray-50
                                       hover:bg-[#D8F3DC]/40
                                       hover:border-[#2D6A4F]
                                       transition
                                       cursor-pointer
                                       text-center
                                       px-4 py-5"
                            >

                                <div
                                    class="w-11 h-11 rounded-xl
                                           bg-[#D8F3DC]
                                           flex items-center justify-center
                                           text-xl"
                                >
                                    📄
                                </div>

                                <p class="mt-3 text-sm font-semibold text-gray-700">
                                    Upload valid ID
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    JPG, JPEG, PNG, or PDF
                                </p>

                                <p class="text-xs text-gray-400">
                                    Maximum size: 5MB
                                </p>

                                <input
                                    id="verification_document"
                                    type="file"
                                    name="verification_document"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    required
                                    class="hidden"
                                >

                            </label>

                            <x-input-error
                                :messages="$errors->get('verification_document')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Proof of Residency --}}
                        <div>

                            <label
                                for="residency_document"
                                class="block text-sm font-semibold text-gray-700"
                            >
                                Proof of Residency
                            </label>

                            <label
                                for="residency_document"
                                class="mt-2 flex flex-col items-center justify-center
                                       min-h-40
                                       w-full
                                       rounded-xl
                                       border-2 border-dashed
                                       border-gray-300
                                       bg-gray-50
                                       hover:bg-[#D8F3DC]/40
                                       hover:border-[#2D6A4F]
                                       transition
                                       cursor-pointer
                                       text-center
                                       px-4 py-5"
                            >

                                <div
                                    class="w-11 h-11 rounded-xl
                                           bg-[#D8F3DC]
                                           flex items-center justify-center
                                           text-xl"
                                >
                                    🏠
                                </div>

                                <p class="mt-3 text-sm font-semibold text-gray-700">
                                    Upload residency document
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Barangay Certificate, Clearance, or ID
                                </p>

                                <p class="text-xs text-gray-400">
                                    JPG, JPEG, PNG, or PDF • Max 5MB
                                </p>

                                <input
                                    id="residency_document"
                                    type="file"
                                    name="residency_document"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    required
                                    class="hidden"
                                >

                            </label>

                            <x-input-error
                                :messages="$errors->get('residency_document')"
                                class="mt-2"
                            />

                        </div>

                    </div>


                    {{-- Privacy Notice --}}
                    <div
                        class="mt-5
                               rounded-xl
                               bg-[#D8F3DC]/70
                               border border-[#B7E4C7]
                               px-4 py-4"
                    >

                        <div class="flex items-start gap-3">

                            <div
                                class="w-9 h-9 rounded-lg
                                       bg-white
                                       flex items-center justify-center
                                       flex-shrink-0"
                            >
                                🔒
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-[#1B4332]">
                                    Your information is protected
                                </p>

                                <p class="mt-1 text-xs leading-5 text-gray-600">
                                    Your uploaded documents will be used only for
                                    EcoTrack resident verification and will be
                                    accessible to authorized LGU administrators.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Divider --}}
                    <div class="border-t border-gray-200 my-8"></div>


                    {{-- ============================= --}}
                    {{-- ACCOUNT SECURITY --}}
                    {{-- ============================= --}}

                    <div class="flex items-center gap-3 mb-5">

                        <div
                            class="w-10 h-10 rounded-xl
                                   bg-[#D8F3DC]
                                   flex items-center justify-center
                                   text-[#1B4332]
                                   font-bold"
                        >
                            3
                        </div>

                        <div>

                            <h2 class="text-lg font-bold text-[#1B4332]">
                                Account Security
                            </h2>

                            <p class="text-xs text-gray-500">
                                Create a secure password
                            </p>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Password --}}
                        <div>

                            <x-input-label
                                for="password"
                                :value="__('Password')"
                                class="text-gray-700 font-semibold"
                            />

                            <x-text-input
                                id="password"
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Create a password"
                            />

                            <x-input-error
                                :messages="$errors->get('password')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Confirm Password --}}
                        <div>

                            <x-input-label
                                for="password_confirmation"
                                :value="__('Confirm Password')"
                                class="text-gray-700 font-semibold"
                            />

                            <x-text-input
                                id="password_confirmation"
                                class="block mt-2 w-full rounded-xl
                                       border-gray-300
                                       bg-gray-50
                                       focus:border-[#2D6A4F]
                                       focus:ring-[#2D6A4F]
                                       focus:bg-white
                                       transition"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm your password"
                            />

                            <x-input-error
                                :messages="$errors->get('password_confirmation')"
                                class="mt-2"
                            />

                        </div>

                    </div>


                    {{-- Account Notice --}}
                    <div
                        class="mt-6
                               rounded-xl
                               bg-[#E9F5EE]
                               border border-[#B7E4C7]
                               px-4 py-4"
                    >

                        <p class="text-sm text-[#1B4332]">

                            <span class="font-semibold">
                                Account Review:
                            </span>

                            Your account will be reviewed by the LGU administrator
                            before you can access EcoTrack.

                        </p>

                    </div>


                    {{-- Buttons --}}
                    <div
                        class="flex flex-col-reverse sm:flex-row
                               items-center
                               justify-between
                               gap-4
                               mt-7"
                    >

                        <a
                            href="{{ route('login') }}"
                            class="text-sm
                                   text-gray-600
                                   hover:text-[#1B4332]
                                   font-medium
                                   transition"
                        >
                            ← Already have an account?
                        </a>


                        <x-primary-button
                            class="w-full sm:w-auto
                                   justify-center
                                   px-7
                                   py-3
                                   rounded-xl
                                   bg-[#2D6A4F]
                                   hover:bg-[#1B4332]
                                   focus:bg-[#1B4332]
                                   active:bg-[#1B4332]
                                   text-white
                                   font-semibold
                                   shadow-md
                                   hover:shadow-lg
                                   transition"
                        >
                            {{ __('Create Resident Account') }}
                        </x-primary-button>

                    </div>

                </form>

            </div>


            {{-- Footer --}}
            <div class="text-center mt-6">

                <p class="text-xs text-white/80 drop-shadow">
                    EcoTrack LGU Garbage Collection Management System
                </p>

            </div>

        </div>

    </div>

</x-guest-layout>