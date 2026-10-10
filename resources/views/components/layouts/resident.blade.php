@php
    $siteSettings = \App\Models\SiteSetting::first();
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ $siteSettings?->site_name ?? 'EcoTrack Resident' }}
    </title>

    {{-- Dynamic Favicon --}}
    <link
        rel="icon"
        type="image/png"
        href="{{ $siteSettings?->logo_path
            ? asset('storage/' . $siteSettings->logo_path)
            : asset('images/ecotrack.logo-removebg-preview.png') }}"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen">

        {{-- FIXED SIDEBAR --}}
        <aside
            class="fixed left-0 top-0 z-40 h-screen w-64
                   bg-[#1B4332] text-white hidden md:flex md:flex-col"
        >

            {{-- LOGO --}}
            <div class="px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                        <img
                            src="{{ $siteSettings?->logo_path
                                ? asset('storage/' . $siteSettings->logo_path)
                                : asset('images/ecotrack.logo-removebg-preview.png') }}"
                            alt="{{ $siteSettings?->site_name ?? 'EcoTrack Logo' }}"
                            class="w-12 h-12 object-contain"
                        >
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-xl font-bold truncate">
                            {{ $siteSettings?->site_name ?? 'EcoTrack' }}
                        </h1>

                        <p class="text-sm text-green-100">
                            Resident Portal
                        </p>
                    </div>

                </div>
            </div>

            {{-- NAVIGATION --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                {{-- DASHBOARD --}}
                <a
                    href="{{ route('resident.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                           hover:bg-white/10 transition
                           {{ request()->routeIs('resident.dashboard') ? 'bg-white/15' : '' }}"
                >
                    <i
                        data-lucide="layout-dashboard"
                        class="w-5 h-5 flex-shrink-0"
                        stroke-width="2"
                    ></i>

                    <span>Dashboard</span>
                </a>

                {{-- COLLECTION SCHEDULE --}}
                <a
                    href="{{ route('resident.schedule') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                           hover:bg-white/10 transition
                           {{ request()->routeIs('resident.schedule') ? 'bg-white/15' : '' }}"
                >
                    <i
                        data-lucide="calendar-days"
                        class="w-5 h-5 flex-shrink-0"
                        stroke-width="2"
                    ></i>

                    <span>Collection Schedule</span>
                </a>

                {{-- ANNOUNCEMENTS --}}
                <a
                    href="{{ route('resident.announcements') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                           hover:bg-white/10 transition
                           {{ request()->routeIs('resident.announcements*') ? 'bg-white/15' : '' }}"
                >
                    <i
                        data-lucide="megaphone"
                        class="w-5 h-5 flex-shrink-0"
                        stroke-width="2"
                    ></i>

                    <span class="flex-1">Announcements</span>

                    @if (($unreadAnnouncementCount ?? 0) > 0)
                        <span
                            class="w-2.5 h-2.5 rounded-full bg-red-500
                                   ring-2 ring-[#1B4332] flex-shrink-0"
                            aria-label="Unread announcements"
                            title="You have unread announcements"
                        ></span>
                    @endif
                </a>

                {{-- REPORT CONCERN --}}
                <a
                    href="{{ route('resident.concerns.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                           hover:bg-white/10 transition
                           {{ request()->routeIs('resident.concerns.*') ? 'bg-white/15' : '' }}"
                >
                    <i
                        data-lucide="message-square-warning"
                        class="w-5 h-5 flex-shrink-0"
                        stroke-width="2"
                    ></i>

                    <span class="flex-1">Report Concern</span>

                    @if (($unreadConcernCount ?? 0) > 0)
                        <span
                            class="w-2.5 h-2.5 rounded-full bg-red-500
                                   ring-2 ring-[#1B4332] flex-shrink-0"
                            aria-label="Unread concern updates"
                            title="You have unread concern updates"
                        ></span>
                    @endif
                </a>

                {{-- MY PROFILE --}}
                <a
                    href="{{ route('resident.profile') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                           hover:bg-white/10 transition
                           {{ request()->routeIs('resident.profile*') ? 'bg-white/15' : '' }}"
                >
                    <i
                        data-lucide="user-round"
                        class="w-5 h-5 flex-shrink-0"
                        stroke-width="2"
                    ></i>

                    <span>My Profile</span>
                </a>

            </nav>
        </aside>

        {{-- MAIN AREA --}}
        <div class="min-h-screen md:ml-64">

            {{-- TOP BAR --}}
            <header class="bg-white border-b border-gray-200">
                <div class="px-6 py-5 flex items-center justify-between gap-6">

                    {{-- PAGE TITLE --}}
                    <div>
                        <p class="text-sm text-gray-500">
                            {{ $siteSettings?->site_name ?? 'EcoTrack' }}
                            Resident Portal
                        </p>

                        <h2 class="text-xl font-bold text-[#1B4332]">
                            Barangay Garbage Collection Management
                        </h2>
                    </div>

                    {{-- UPPER RIGHT PROFILE --}}
                    <div
                        x-data="{ open: false }"
                        @click.outside="open = false"
                        class="relative"
                    >

                        {{-- PROFILE BUTTON --}}
                        <button
                            type="button"
                            @click="open = !open"
                            class="flex items-center gap-3 rounded-xl px-3 py-2
                                   hover:bg-[#F5F7F6] transition focus:outline-none
                                   focus:ring-2 focus:ring-[#B7E4C7]"
                        >
                            {{-- USER NAME --}}
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $user->name }}
                                </p>

                                <p class="text-xs text-gray-500">Resident</p>
                            </div>

                            {{-- PROFILE PHOTO --}}
                            @if ($user->profile_photo)
                                <img
                                    src="{{ asset('storage/' . $user->profile_photo) }}"
                                    alt="{{ $user->name }}"
                                    class="w-11 h-11 rounded-full object-cover
                                           border-2 border-[#D8F3DC]"
                                >
                            @else
                                <div
                                    class="w-11 h-11 rounded-full bg-[#2D6A4F]
                                           text-white flex items-center justify-center
                                           font-bold border-2 border-[#D8F3DC]"
                                >
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif

                            {{-- DROPDOWN ARROW --}}
                            <i
                                data-lucide="chevron-down"
                                class="w-4 h-4 text-gray-500 transition-transform"
                                :class="{ 'rotate-180': open }"
                                stroke-width="2"
                            ></i>
                        </button>

                        {{-- PROFILE DROPDOWN --}}
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-3 w-80 rounded-2xl border
                                   border-gray-200 bg-white shadow-xl overflow-hidden z-50"
                            style="display: none;"
                        >

                            {{-- PROFILE HEADER --}}
                            <div class="px-5 py-5 bg-[#D8F3DC]">
                                <div class="flex items-center gap-4">

                                    @if ($user->profile_photo)
                                        <img
                                            src="{{ asset('storage/' . $user->profile_photo) }}"
                                            alt="{{ $user->name }}"
                                            class="w-16 h-16 rounded-full object-cover
                                                   border-4 border-white shadow-sm"
                                        >
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-full bg-[#2D6A4F]
                                                   text-white flex items-center justify-center
                                                   text-2xl font-bold border-4 border-white shadow-sm"
                                        >
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <p class="font-bold text-lg text-[#1B4332] truncate">
                                            {{ $user->name }}
                                        </p>

                                        <p class="text-sm text-[#2D6A4F] truncate">
                                            {{ $user->email }}
                                        </p>

                                        <p class="text-xs text-[#40916C] mt-1">
                                            EcoTrack Resident
                                        </p>
                                    </div>

                                </div>
                            </div>

                            {{-- DROPDOWN MENU --}}
                            <div class="p-3">

                                {{-- EDIT PROFILE --}}
                                <a
                                    href="{{ route('resident.profile') }}"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                                           text-gray-700 hover:bg-[#D8F3DC]
                                           hover:text-[#1B4332] transition"
                                >
                                    <div
                                        class="w-9 h-9 rounded-lg bg-[#F5F7F6]
                                               flex items-center justify-center"
                                    >
                                        <i
                                            data-lucide="user-pen"
                                            class="w-5 h-5 text-[#2D6A4F]"
                                            stroke-width="2"
                                        ></i>
                                    </div>

                                    <div>
                                        <p class="text-sm font-semibold">Edit Profile</p>
                                        <p class="text-xs text-gray-500">
                                            Update your profile information
                                        </p>
                                    </div>
                                </a>

                                <div class="my-2 border-t border-gray-100"></div>

                                {{-- LOGOUT --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3
                                               rounded-xl text-[#2D6A4F] hover:bg-[#D8F3DC]
                                               transition text-left"
                                    >
                                        <div
                                            class="w-9 h-9 rounded-lg bg-[#F5F7F6]
                                                   flex items-center justify-center"
                                        >
                                            <i
                                                data-lucide="log-out"
                                                class="w-5 h-5 text-[#2D6A4F]"
                                                stroke-width="2"
                                            ></i>
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold">Logout</p>
                                            <p class="text-xs text-gray-500">
                                                Sign out of your account
                                            </p>
                                        </div>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

    {{-- INITIALIZE LUCIDE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>

</body>
</html>
