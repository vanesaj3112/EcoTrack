<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EcoTrack Admin</title>
    <link rel="icon" type="image/png"
    href="{{ asset('images/ecotrack.logo-removebg-preview.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F5F7F2] min-h-screen">

    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-[#1B4332] text-white flex flex-col">

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
                        <h1 class="font-bold text-xl">
                            EcoTrack
                        </h1>

                        <p class="text-xs text-[#B7E4C7]">
                            LGU Administration
                        </p>
                    </div>

                </div>

            </div>


            {{-- NAVIGATION --}}
            <nav class="flex-1 px-4 py-6 space-y-2">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                        Dashboard
                    </span>

                </a>

                <a href="{{ route('admin.barangays.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                            hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                            Barangays
                    </span>

                </a>


                {{-- Residents --}}
                <a href="{{ route('admin.residents.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                        Residents
                    </span>

                </a>


                {{-- Collection Schedules --}}
                <a href="{{ route('admin.collection-schedules.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                        Collection Schedules
                    </span>

                </a>


                {{-- Announcements --}}
                <a href="{{ route('admin.announcements.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                        Announcements
                    </span>

                </a>


                {{-- SMS Notifications --}}
                <a href="{{ route('admin.sms.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                        SMS Notifications
                    </span>

                </a>


                {{-- Audit Logs --}}
                <a href="{{ route('admin.audit-logs.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                        Audit Logs
                    </span>

                </a>

                {{-- Site Settings --}}
<a href="{{ route('admin.settings.edit') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg
          hover:bg-white/10 transition">
    <span></span>
    <span class="font-medium">Site Settings</span>
</a>

            </nav>


            {{-- BOTTOM MENU --}}
            <div class="px-4 py-4 border-t border-white/10 space-y-2">

                {{-- Settings --}}
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          hover:bg-white/10 transition">

                    <span></span>

                    <span class="font-medium">
                        Settings / Profile
                    </span>

                </a>


                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="w-full flex items-center gap-3
                                   px-4 py-3 rounded-lg
                                   hover:bg-red-500/20
                                   transition text-left">

                        <span></span>

                        <span class="font-medium">
                            Logout
                        </span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- MAIN CONTENT --}}
        <div class="flex-1 min-w-0">

            {{-- TOP BAR --}}
            <header class="bg-white border-b border-gray-200 px-8 py-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            LGU Administration
                        </p>

                        <h2 class="text-xl font-bold text-gray-800">
                            Barangay Garbage Collection Management
                        </h2>

                    </div>


                    {{-- User --}}
                    <div class="flex items-center gap-3">

                        <div class="text-right">

                            <p class="text-sm font-semibold text-gray-800">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                Administrator
                            </p>

                        </div>


                        <div class="w-10 h-10 rounded-full
                                    bg-[#2D6A4F]
                                    text-white
                                    flex items-center justify-center
                                    font-bold">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    </div>

                </div>

            </header>


            {{-- PAGE CONTENT --}}
            <main class="p-8">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>

</html>