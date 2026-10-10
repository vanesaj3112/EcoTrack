<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@php
    $siteSettings = \App\Models\SiteSetting::first();
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ $siteSettings?->site_name ?? 'EcoTrack Collector' }}
    </title>

    {{-- Dynamic Favicon --}}
    <link
        rel="icon"
        type="image/png"
        href="{{ $siteSettings?->logo_path
            ? asset('storage/' . $siteSettings->logo_path)
            : asset('images/ecotrack.logo-removebg-preview.png') }}"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F5F7F6] text-gray-800">

    {{-- COLLECTOR NAVIGATION --}}
    <nav class="border-b border-[#D8F3DC] bg-white">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex min-h-16 items-center justify-between gap-4">

                {{-- LOGO / BRAND --}}
                <a
                    href="{{ route('collector.dashboard') }}"
                    class="flex items-center gap-3"
                >

                    <img
                        src="{{ $siteSettings?->logo_path
                            ? asset('storage/' . $siteSettings->logo_path)
                            : asset('images/ecotrack.logo-removebg-preview.png') }}"
                        alt="{{ $siteSettings?->site_name ?? 'EcoTrack' }}"
                        class="h-10 w-auto"
                    >

                    <div class="hidden sm:block">
                        <p class="font-bold text-[#1B4332]">
                            {{ $siteSettings?->site_name ?? 'EcoTrack' }}
                        </p>

                        <p class="text-xs text-gray-500">
                            Garbage Collector
                        </p>
                    </div>

                </a>


                {{-- RIGHT SIDE --}}
                <div class="flex items-center gap-3">

                    <span
                        class="hidden rounded-full bg-[#D8F3DC] px-3 py-1.5 text-xs font-semibold text-[#1B4332] sm:inline-block"
                    >
                        Collector
                    </span>

                    <span class="text-sm font-semibold text-[#1B4332]">
                        {{ auth()->user()->name }}
                    </span>

                    {{-- LOGOUT --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="rounded-lg px-3 py-2 text-sm font-semibold text-[#2D6A4F] transition hover:bg-[#D8F3DC]"
                        >
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </nav>


    {{-- PAGE HEADER --}}
    @isset($header)

        <header class="bg-white">

            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $header }}
            </div>

        </header>

    @endisset


    {{-- PAGE CONTENT --}}
    <main>
        {{ $slot }}
    </main>

</body>

</html>