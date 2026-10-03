<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EcoTrack - LGU Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-eco-dark text-white hidden md:flex flex-col">

            {{-- Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-white/10">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-eco-dark font-bold text-xl">
                            E
                        </span>
                    </div>

                    <div>
                        <div class="font-bold text-lg text-white">
                            EcoTrack
                        </div>

                        <div class="text-xs text-white/70">
                            LGU Management
                        </div>
                    </div>

                </a>

            </div>


            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-2">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   bg-white text-eco-dark font-medium">

                    <span></span>
                    <span>Dashboard</span>

                </a>


                {{-- Residents --}}
                <a href="{{ route('admin.residents.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-white/80 hover:bg-white/10 hover:text-white transition">

                    <span></span>
                    <span>Residents</span>

                </a>


                {{-- Collection Schedules --}}
                <a href="{{ route('admin.collection-schedules.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-white/80 hover:bg-white/10 hover:text-white transition">

                    <span></span>
                    <span>Collection Schedules</span>

                </a>


                {{-- Announcements --}}
                <a href="{{ route('admin.announcements.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-white/80 hover:bg-white/10 hover:text-white transition">

                    <span></span>
                    <span>Announcements</span>

                </a>


                {{-- SMS Notifications --}}
                <a href="{{ route('admin.sms.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-white/80 hover:bg-white/10 hover:text-white transition">

                    <span></span>
                    <span>SMS Notifications</span>

                </a>


                {{-- Audit Logs --}}
                <a href="{{ route('admin.audit-logs.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-white/80 hover:bg-white/10 hover:text-white transition">

                    <span></span>
                    <span>Audit Logs</span>

                </a>

            </nav>


            {{-- Bottom Navigation --}}
            <div class="border-t border-white/10 p-4">

                {{-- Settings --}}
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-white/80 hover:bg-white/10 hover:text-white transition">

                    <span></span>
                    <span>Settings</span>

                </a>


                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg
                        text-white/80 hover:bg-white/10 hover:text-white transition">

                        <span></span>
                        <span>Logout</span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- Main Area --}}
        <div class="flex-1 flex flex-col min-w-0 bg-gray-50">

            {{-- Header --}}
            <header class="h-16 bg-white border-b border-gray-200
                           flex items-center justify-between px-6">

                <div>
                    <h1 class="font-semibold text-lg text-eco-dark">
                        LGU Administration
                    </h1>

                    <p class="text-xs text-gray-500">
                        Barangay Garbage Collection Management
                    </p>
                </div>


                {{-- Admin --}}
                <div class="flex items-center gap-3">

                    <div class="text-right">

                        <p class="text-sm font-medium text-gray-800">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-xs text-gray-500">
                            LGU Administrator
                        </p>

                    </div>

                    <div class="w-10 h-10 rounded-full bg-eco-light
                                flex items-center justify-center">

                        <span class="text-eco-dark font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>

                    </div>

                </div>

            </header>


            {{-- Page Content --}}
            <main class="flex-1 p-6">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>
</html>