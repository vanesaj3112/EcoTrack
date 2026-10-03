<x-guest-layout>

    <div
        class="min-h-screen flex items-center justify-center px-4 py-10 relative overflow-hidden"
        style="
            background-image:
                linear-gradient(
                    rgba(27, 67, 50, 0.45),
                    rgba(27, 67, 50, 0.45)
                ),
                url('{{ asset('images/abuyogbackground.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        "
    >

        <div class="w-full max-w-md relative z-10">

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


            {{-- Heading --}}
            <div class="text-center mb-8">

                <h1 class="text-3xl font-extrabold text-white drop-shadow-lg">
                    Welcome Back
                </h1>

                <p class="mt-2 text-sm text-white/90 drop-shadow">
                    Sign in to your EcoTrack account
                </p>

            </div>


            {{-- Login Card --}}
            <div
                class="bg-white/95 backdrop-blur-sm
                       rounded-2xl
                       shadow-2xl
                       border border-white/40
                       p-7 sm:p-8"
            >

                {{-- Session Status --}}
                <x-auth-session-status
                    class="mb-5"
                    :status="session('status')"
                />


                {{-- Validation Summary --}}
                @if ($errors->any())

                    <div class="mb-5 rounded-lg bg-red-50 border border-red-200 px-4 py-3">

                        <p class="text-sm font-semibold text-red-700">
                            Please check your login details.
                        </p>

                    </div>

                @endif


                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf


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
                            autofocus
                            autocomplete="username"
                            placeholder="Enter your email"
                        />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />

                    </div>


                    {{-- Password --}}
                    <div class="mt-5">

                        <div class="flex items-center justify-between">

                            <x-input-label
                                for="password"
                                :value="__('Password')"
                                class="text-gray-700 font-semibold"
                            />

                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm text-[#2D6A4F]
                                           hover:text-[#1B4332]
                                           font-semibold
                                           transition"
                                >
                                    Forgot password?
                                </a>

                            @endif

                        </div>


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
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />

                    </div>


                    {{-- Remember Me --}}
                    <div class="mt-5">

                        <label
                            for="remember_me"
                            class="inline-flex items-center cursor-pointer"
                        >

                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="rounded
                                       border-gray-300
                                       text-[#2D6A4F]
                                       shadow-sm
                                       focus:ring-[#2D6A4F]"
                            >

                            <span class="ms-2 text-sm text-gray-600">
                                Remember me
                            </span>

                        </label>

                    </div>


                    {{-- Login Button --}}
                    <div class="mt-7">

                        <x-primary-button
                            class="w-full
                                   justify-center
                                   py-3.5
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
                            {{ __('Sign In to EcoTrack') }}
                        </x-primary-button>

                    </div>

                </form>


                {{-- Registration Link --}}
                @if (Route::has('register'))

                    <div
                        class="mt-7
                               pt-6
                               border-t
                               border-gray-200
                               text-center"
                    >

                        <p class="text-sm text-gray-500">
                            Don't have an EcoTrack account?
                        </p>

                        <a
                            href="{{ route('register') }}"
                            class="inline-block mt-2
                                   text-[#2D6A4F]
                                   hover:text-[#1B4332]
                                   font-semibold
                                   transition"
                        >
                            Create an account →
                        </a>

                    </div>

                @endif

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