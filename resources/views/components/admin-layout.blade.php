@php

    $siteSettings = \App\Models\SiteSetting::first();

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Admin Notifications
    |--------------------------------------------------------------------------
    */

    $hasNewResidentNotification =
    \App\Models\AdminNotification::where(
        'admin_id',
        auth()->id()
    )
    ->where(
        'type',
        'new_resident'
    )
    ->where(
        'is_read',
        false
    )
    ->exists();

$hasNewResidentReportNotification =
    \App\Models\AdminNotification::where(
        'admin_id',
        auth()->id()
    )
    ->where(
        'type',
        'new_resident_report'
    )
    ->where(
        'is_read',
        false
    )
    ->exists();

@endphp

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        {{ $siteSettings?->site_name ?? 'EcoTrack' }} Admin
    </title>

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
    <script
        src="https://unpkg.com/lucide@latest"
        defer
    ></script>

</head>

<body class="bg-[#F5F7F2] min-h-screen">

    {{-- ===================================================== --}}
    {{-- FIXED SIDEBAR --}}
    {{-- ===================================================== --}}

    <aside
        class="fixed left-0 top-0
               h-screen w-64
               bg-[#1B4332]
               text-white
               flex flex-col
               overflow-y-auto
               z-50"
    >

        {{-- ================================================= --}}
        {{-- LOGO --}}
        {{-- ================================================= --}}

        <div class="px-6 py-6 border-b border-white/10">

            <div class="flex items-center gap-3">

                <div class="w-12 h-12 flex items-center justify-center">

                    <img
                        src="{{ $siteSettings?->logo_path
                            ? asset('storage/' . $siteSettings->logo_path)
                            : asset('images/ecotrack.logo-removebg-preview.png') }}"
                        alt="{{ $siteSettings?->site_name ?? 'EcoTrack' }} Logo"
                        class="w-12 h-12 object-contain"
                    >

                </div>

                <div>

                    <h1 class="font-bold text-xl">
                        {{ $siteSettings?->site_name ?? 'EcoTrack' }}
                    </h1>

                    <p class="text-xs text-[#B7E4C7]">
                        LGU Administration
                    </p>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- NAVIGATION --}}
        {{-- ================================================= --}}

        <nav class="flex-1 px-4 py-6 space-y-2">

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('dashboard')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="layout-dashboard"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Dashboard
                </span>

            </a>


            {{-- Barangays --}}
            <a
                href="{{ route('admin.barangays.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.barangays.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="map-pin"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Barangays
                </span>

            </a>


            {{-- Residents --}}
            <a
                href="{{ route('admin.residents.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.residents.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="users"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Residents
                </span>

                {{-- NEW RESIDENT RED DOT --}}
                @if ($hasNewResidentNotification)

                    <span
                        class="ml-auto w-2.5 h-2.5
                               rounded-full
                               bg-red-500
                               shrink-0"
                        title="New resident registration"
                    ></span>

                @endif

            </a>


            {{-- Collection Schedules --}}
            <a
                href="{{ route('admin.collection-schedules.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.collection-schedules.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="calendar-days"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Collection Schedules
                </span>

            </a>


            {{-- Garbage Collectors --}}
            <a
                href="{{ route('admin.garbage-collectors.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.garbage-collectors.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="truck"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Garbage Collectors
                </span>

            </a>


            {{-- Resident Reports --}}
            <a
                href="{{ route('admin.resident-concerns.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.resident-concerns.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="message-square-warning"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Resident Reports
                </span>

                @if ($hasNewResidentReportNotification)

    <span
        class="ml-auto w-2.5 h-2.5
               rounded-full
               bg-red-500
               shrink-0"
        title="New resident report"
    ></span>

@endif

            </a>


            {{-- Announcements --}}
            <a
                href="{{ route('admin.announcements.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.announcements.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="megaphone"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Announcements
                </span>

            </a>


            {{-- SMS Notifications --}}
            <a
                href="{{ route('admin.sms.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.sms.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="message-square-text"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    SMS Notifications
                </span>

            </a>


            {{-- Audit Logs --}}
            <a
                href="{{ route('admin.audit-logs.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.audit-logs.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="clipboard-list"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Audit Logs
                </span>

            </a>


            {{-- Site Settings --}}
            <a
                href="{{ route('admin.settings.edit') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition
                       {{ request()->routeIs('admin.settings.*')
                            ? 'bg-white/15 text-white'
                            : 'hover:bg-white/10 text-white' }}"
            >

                <i
                    data-lucide="settings"
                    class="w-5 h-5 shrink-0"
                    stroke-width="2"
                ></i>

                <span class="font-medium">
                    Site Settings
                </span>

            </a>

        </nav>

    </aside>


    {{-- ===================================================== --}}
    {{-- MAIN AREA --}}
    {{-- ===================================================== --}}

    <div class="ml-64 min-h-screen min-w-0">


        {{-- ================================================= --}}
        {{-- TOP BAR --}}
        {{-- ================================================= --}}

        <header
            class="bg-white
                   border-b border-gray-200
                   px-8 py-4
                   sticky top-0
                   z-40"
        >

            <div class="flex items-center justify-between gap-6">


                {{-- PAGE TITLE --}}

                <div>

                    <p class="text-sm text-gray-500">
                        LGU Administration
                    </p>

                    <h2 class="text-xl font-bold text-[#1B4332]">
                        Barangay Garbage Collection Management
                    </h2>

                </div>


                {{-- ================================================= --}}
                {{-- PROFILE --}}
                {{-- ================================================= --}}

                <div
                    x-data="{ open: false }"
                    @click.outside="open = false"
                    class="relative"
                >


                    {{-- PROFILE BUTTON --}}

                    <button
                        type="button"
                        @click="open = !open"
                        class="flex items-center gap-3
                               rounded-xl
                               px-3 py-2
                               hover:bg-[#F5F7F6]
                               transition
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#B7E4C7]"
                    >


                        {{-- USER NAME --}}

                        <div class="text-right hidden sm:block">

                            <p class="text-sm font-semibold text-gray-800">
                                {{ $user->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                Administrator
                            </p>

                        </div>


                        {{-- PROFILE PHOTO --}}

                        @if ($user->profile_photo)

                            <img
                                src="{{ asset('storage/' . $user->profile_photo) }}"
                                alt="{{ $user->name }}"
                                class="w-11 h-11 rounded-full
                                       object-cover
                                       border-2 border-[#D8F3DC]"
                            >

                        @else

                            <div
                                class="w-11 h-11 rounded-full
                                       bg-[#2D6A4F]
                                       text-white
                                       flex items-center justify-center
                                       font-bold
                                       border-2 border-[#D8F3DC]"
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


                    {{-- ================================================= --}}
                    {{-- PROFILE DROPDOWN --}}
                    {{-- ================================================= --}}

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-80
                               rounded-2xl
                               border border-gray-200
                               bg-white
                               shadow-xl
                               overflow-hidden
                               z-50"
                        style="display: none;"
                    >


                        {{-- PROFILE HEADER --}}

                        <div class="px-5 py-5 bg-[#D8F3DC]">

                            <div class="flex items-center gap-4">


                                {{-- LARGE PROFILE PHOTO --}}

                                @if ($user->profile_photo)

                                    <img
                                        src="{{ asset('storage/' . $user->profile_photo) }}"
                                        alt="{{ $user->name }}"
                                        class="w-16 h-16 rounded-full
                                               object-cover
                                               border-4 border-white
                                               shadow-sm"
                                    >

                                @else

                                    <div
                                        class="w-16 h-16 rounded-full
                                               bg-[#2D6A4F]
                                               text-white
                                               flex items-center justify-center
                                               text-2xl
                                               font-bold
                                               border-4 border-white
                                               shadow-sm"
                                    >

                                        {{ strtoupper(substr($user->name, 0, 1)) }}

                                    </div>

                                @endif


                                <div class="min-w-0">

                                    <p
                                        class="font-bold text-lg
                                               text-[#1B4332]
                                               truncate"
                                    >

                                        {{ $user->name }}

                                    </p>

                                    <p
                                        class="text-sm
                                               text-[#2D6A4F]
                                               truncate"
                                    >

                                        {{ $user->email }}

                                    </p>

                                    <p class="text-xs text-[#40916C] mt-1">
                                        LGU Administrator
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- MENU --}}

                        <div class="p-3">


                            {{-- EDIT PROFILE --}}

                            <a
                                href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3
                                       px-4 py-3
                                       rounded-xl
                                       text-gray-700
                                       hover:bg-[#D8F3DC]
                                       hover:text-[#1B4332]
                                       transition"
                            >

                                <div
                                    class="w-9 h-9 rounded-lg
                                           bg-[#F5F7F6]
                                           flex items-center justify-center"
                                >

                                    <i
                                        data-lucide="user-pen"
                                        class="w-5 h-5 text-[#2D6A4F]"
                                        stroke-width="2"
                                    ></i>

                                </div>


                                <div>

                                    <p class="text-sm font-semibold">
                                        Edit Profile
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Update your profile information
                                    </p>

                                </div>

                            </a>


                            {{-- DIVIDER --}}

                            <div class="my-2 border-t border-gray-100"></div>


                            {{-- LOGOUT --}}

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full flex items-center gap-3
                                           px-4 py-3
                                           rounded-xl
                                           text-[#2D6A4F]
                                           hover:bg-[#D8F3DC]
                                           transition
                                           text-left"
                                >

                                    <div
                                        class="w-9 h-9 rounded-lg
                                               bg-[#F5F7F6]
                                               flex items-center justify-center"
                                    >

                                        <i
                                            data-lucide="log-out"
                                            class="w-5 h-5 text-[#2D6A4F]"
                                            stroke-width="2"
                                        ></i>

                                    </div>


                                    <div>

                                        <p class="text-sm font-semibold">
                                            Logout
                                        </p>

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


        {{-- ================================================= --}}
        {{-- PAGE CONTENT --}}
        {{-- ================================================= --}}

        <main class="p-8">

            {{ $slot }}

        </main>

    </div>


    {{-- ===================================================== --}}
    {{-- INITIALIZE LUCIDE --}}
    {{-- ===================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                if (window.lucide) {

                    lucide.createIcons();

                }

            }
        );

    </script>


</body>

</html>