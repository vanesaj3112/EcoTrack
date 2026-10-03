<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EcoTrack Resident</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-[#1B4332] text-white hidden md:flex md:flex-col">

            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-white/10">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 flex items-center justify-center">
                    <img
                 src="{{ asset('images/ecotrack.logo-removebg-preview.png') }}"
                 alt="EcoTrack Logo"
                 class="w-12 h-12 object-contain"
                        >
                    </div>

                    <div>
                        <h1 class="text-xl font-bold">
                            EcoTrack
                        </h1>

                        <p class="text-sm text-green-100">
                            Resident Portal
                        </p>
                    </div>

                </div>

            </div>

            
            {{-- Navigation --}}
<nav class="flex-1 px-4 py-6 space-y-2">

    {{-- Dashboard --}}
    <a
        href="{{ route('resident.dashboard') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               hover:bg-white/10 transition"
    >
        
        <span>Dashboard</span>
    </a>


    {{-- Collection Schedule --}}
    <a
        href="{{ route('resident.schedule') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               hover:bg-white/10 transition"
    >
        
        <span>Collection Schedule</span>
    </a>


    {{-- Announcements --}}
    <a
        href="{{ route('resident.announcements') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               hover:bg-white/10 transition"
    >
        
        <span>Announcements</span>
    </a>


    {{-- My Profile --}}
    <a
        href="{{ route('resident.profile') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               hover:bg-white/10 transition"
    >
        
        <span>My Profile</span>
    </a>

</nav>

            {{-- Logout --}}
            <div class="px-4 py-5 border-t border-white/10">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3
                               px-4 py-3 rounded-lg
                               hover:bg-white/10 transition
                               text-left"
                    >
                        
                        <span>Logout</span>
                    </button>

                </form>

            </div>

        </aside>

        {{-- Main Content --}}
        <div class="flex-1 min-w-0">

            {{-- Header --}}
            <header class="bg-white border-b border-gray-200">

                <div class="px-6 py-5 flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            EcoTrack Resident Portal
                        </p>

                        <h2 class="text-xl font-bold text-[#1B4332]">
                            Barangay Garbage Collection Management
                        </h2>
                    </div>

                    <div class="flex items-center gap-3">

                        <div class="hidden sm:block text-right">

                            <p class="font-semibold text-gray-800">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Resident
                            </p>

                        </div>

                        <div
                            class="w-11 h-11 rounded-full
                                   bg-[#2D6A4F] text-white
                                   flex items-center justify-center
                                   font-bold"
                        >
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </header>

            {{-- Page Content --}}
            <main class="p-6">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>

</html>