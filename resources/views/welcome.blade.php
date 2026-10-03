<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/ecotrack.logo-removebg-preview.png') }}">

    <title>EcoTrack</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --eco-dark: #1B4332;
            --eco-green: #2D6A4F;
            --eco-light: #D8F3DC;
            --eco-white: #FFFFFF;
            --eco-gray: #F5F7F6;
        }

        body {
            margin: 0;
            background: var(--eco-gray);
        }

        
        

        /* =========================================
   MOVING GARBAGE TRUCK
   BESIDE THE SIGN IN BUTTON
========================================= */

@keyframes driveTruck {
    0% {
        left: 0;
    }

    100% {
        left: calc(100% - var(--truck-size));
    }
}

.truck-lane {
    position: absolute;

    /* blank space beside the buttons */
    left: 48%;
    right: 5%;

    top: 58%;

    height: 150px;

    overflow: hidden;

    pointer-events: none;

    z-index: 40;
}

.moving-truck {
    --truck-size: 150px;

    position: absolute;

    left: 0;
    bottom: 0;

    width: var(--truck-size);
    height: var(--truck-size);

    animation: driveTruck 6s linear infinite;

    will-change: left;
}

.moving-truck img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

        /* =========================================
           HERO BACKGROUND
        ========================================== */

        .hero-bg {
            min-height: 100vh;

            background-image:
                linear-gradient(
                    rgba(27, 67, 50, 0.60),
                    rgba(27, 67, 50, 0.72)
                ),
                url('/images/abuyogbackground.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* =========================================
           HERO NAVIGATION
        ========================================== */

        .hero-nav {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;

            z-index: 50;
        }

        /* =========================================
           ROAD
        ========================================== */

        .road-line {
    position: absolute;

    left: 48%;
    right: 5%;

    top: calc(58% + 125px);

    height: 2px;

    background: rgba(216, 243, 220, 0.65);

    z-index: 30;
}

   .road-dashes {
    position: absolute;

    left: 48%;
    right: 5%;

    top: calc(58% + 140px);

    height: 2px;

    background:
        repeating-linear-gradient(
            to right,
            rgba(216, 243, 220, 0.75) 0,
            rgba(216, 243, 220, 0.75) 55px,
            transparent 55px,
            transparent 85px
        );

    z-index: 30;
}

        /* =========================================
           REDUCED MOTION
        ========================================== */

        @media (prefers-reduced-motion: reduce) {

            .moving-truck {
                animation: none;
                transform: translateX(0);
            }
        }

        /* =========================================
           MOBILE
        ========================================== */

        @media (max-width: 640px) {

            .hero-bg {
                background-position: center;
            }

            .hero-nav .h-24 {
                height: auto;
                min-height: 90px;

                padding-top: 15px;
                padding-bottom: 15px;
            }

            .brand-text {
                display: none;
            }

            /*
             * On mobile, truck lane becomes wider
             */
            .truck-lane {
                left: 5%;
                right: 5%;
                bottom: 65px;
                height: 110px;
            }

            .moving-truck {
                --truck-size: 105px;
            }

            .road-line {
                left: 5%;
                right: 5%;
                bottom: 61px;
            }

            .truck-lane {
    left: 8%;
    right: 8%;
    top: 68%;
    height: 110px;
}

.moving-truck {
    --truck-size: 105px;
}

.road-line {
    left: 8%;
    right: 8%;
    top: calc(68% + 90px);
}

.road-dashes {
    left: 8%;
    right: 8%;
    top: calc(68% + 105px);
}
        }
    </style>
</head>


<body class="min-h-screen text-gray-800">


    <!-- =========================================
         HERO
    ========================================== -->

    <section class="relative overflow-hidden hero-bg">


        <!-- =========================================
             HERO NAVIGATION
        ========================================== -->

        <nav class="hero-nav">

            <div class="max-w-7xl mx-auto px-6 lg:px-12">

                <div class="h-24 flex items-center justify-between">


                    <!-- ECOTRACK BRAND -->

                    <a
                        href="/"
                        class="flex items-center gap-3"
                    >

                        <img
                            src="{{ asset('images/ecotrack.logo-removebg-preview.png') }}"
                            alt="EcoTrack Logo"
                            class="w-14 h-14 object-contain"
                        >

                        <div class="brand-text">

                            <div
                                class="
                                    text-2xl
                                    font-extrabold
                                    text-white
                                "
                            >
                                EcoTrack
                            </div>

                            <div
                                class="
                                    text-sm
                                    text-white/80
                                "
                            >
                                Smart Waste Management
                            </div>

                        </div>

                    </a>


                    <!-- LOGIN / REGISTER -->

                    <div class="flex items-center gap-3">

                        @if (Route::has('login'))

                            @auth

                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="
                                        px-6
                                        py-3
                                        rounded-full
                                        border
                                        border-white
                                        text-white
                                        font-semibold
                                        text-sm
                                        hover:bg-white
                                        hover:text-eco-dark
                                        transition
                                    "
                                >
                                    Dashboard
                                </a>

                            @else

                                <!-- LOGIN -->

                                <a
                                    href="{{ route('login') }}"
                                    class="
                                        px-6
                                        py-3
                                        rounded-full
                                        border
                                        border-white
                                        text-white
                                        font-semibold
                                        text-sm
                                        hover:bg-white
                                        hover:text-eco-dark
                                        transition
                                    "
                                >
                                    Log in
                                </a>


                                <!-- REGISTER -->

                                @if (Route::has('register'))

                                    <a
                                        href="{{ route('register') }}"
                                        class="
                                            px-7
                                            py-3
                                            rounded-full
                                            bg-eco-green
                                            text-white
                                            font-semibold
                                            text-sm
                                            hover:bg-eco-light
                                            hover:text-eco-dark
                                            transition
                                        "
                                    >
                                        Register
                                    </a>

                                @endif

                            @endauth

                        @endif

                    </div>

                </div>

            </div>

        </nav>


        <!-- =========================================
             HERO CONTENT
        ========================================== -->

        <div
            class="
                relative
                z-10
                min-h-screen
                max-w-7xl
                mx-auto
                px-6
                lg:px-12
                flex
                items-center
            "
        >

            <div
                class="
                    pt-24
                    pb-40
                    w-full
                "
            >

                <!-- HERO LEFT CONTENT -->

                <div class="max-w-3xl">


                    <!-- BADGE -->

                    <div
                        class="
                            inline-flex
                            items-center
                            gap-3
                            px-5
                            py-2.5
                            rounded-full
                            bg-eco-green/40
                            border
                            border-white/20
                            backdrop-blur-sm
                            text-white
                            text-sm
                            font-semibold
                        "
                    >

                        <span
                            class="
                                w-3
                                h-3
                                rounded-full
                                bg-eco-light
                            "
                        ></span>

                        Cleaner Barangays. Smarter Collection.

                    </div>


                    <!-- MAIN HEADING -->

                    <h1
                        class="
                            mt-8
                            max-w-3xl
                            text-5xl
                            sm:text-6xl
                            lg:text-7xl
                            font-extrabold
                            leading-[1.05]
                            tracking-tight
                            text-white
                        "
                    >

                        A cleaner

                        <br>

                        community

                        <span class="text-eco-light">
                            starts
                        </span>

                        <br>

                        <span class="text-eco-light">
                            here.
                        </span>

                    </h1>


                    <!-- DESCRIPTION -->

                    <p
                        class="
                            mt-8
                            max-w-2xl
                            text-lg
                            lg:text-xl
                            leading-8
                            text-white/90
                        "
                    >

                        EcoTrack is a digital garbage collection
                        management system designed to help LGUs,
                        residents, and barangays work together
                        for a cleaner and greener community.

                    </p>


                    <!-- MAIN BUTTONS -->

                    <div
                        class="
                            mt-9
                            flex
                            flex-wrap
                            gap-4
                        "
                    >

                        <!-- GET STARTED -->

                        @if (Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    px-8
                                    py-4
                                    rounded-full
                                    bg-eco-light
                                    text-eco-dark
                                    font-bold
                                    text-lg
                                    shadow-lg
                                    hover:bg-white
                                    hover:-translate-y-1
                                    transition
                                "
                            >

                                Get Started

                                <span class="ml-3 text-xl">
                                    →
                                </span>

                            </a>

                        @endif


                        <!-- SIGN IN -->

                        @if (Route::has('login'))

                            <a
                                href="{{ route('login') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    px-8
                                    py-4
                                    rounded-full
                                    border-2
                                    border-white
                                    text-white
                                    font-bold
                                    text-lg
                                    hover:bg-white
                                    hover:text-eco-dark
                                    transition
                                "
                            >

                                Sign In

                            </a>

                        @endif

                    </div>


                    <!-- INFORMATION -->

                    <div
                        class="
                            mt-8
                            flex
                            flex-wrap
                            gap-x-7
                            gap-y-3
                            text-sm
                            text-white/80
                        "
                    >

                        <!-- LGU -->

                        <div
                            class="
                                flex
                                items-center
                                gap-2
                            "
                        >

                            <span
                                class="
                                    text-eco-light
                                    font-bold
                                "
                            >
                                ✓
                            </span>

                            LGU Managed

                        </div>


                        <!-- BARANGAY -->

                        <div
                            class="
                                flex
                                items-center
                                gap-2
                            "
                        >

                            <span
                                class="
                                    text-eco-light
                                    font-bold
                                "
                            >
                                ✓
                            </span>

                            Barangay Based

                        </div>


                        <!-- COMMUNITY -->

                        <div
                            class="
                                flex
                                items-center
                                gap-2
                            "
                        >

                            <span
                                class="
                                    text-eco-light
                                    font-bold
                                "
                            >
                                ✓
                            </span>

                            Community Focused

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =========================================
             MOVING TRUCK LANE
             
             THIS IS THE BLUE RECTANGLE AREA
             
             TRUCK MOVES LEFT → RIGHT
             ONLY INSIDE THIS AREA
        ========================================== -->

        <div class="truck-lane">

            <div class="moving-truck">

                <img
                    src="{{ asset('images/ecotrack.logo-removebg-preview.png') }}"
                    alt="EcoTrack Garbage Truck"
                >

            </div>

        </div>


        <!-- =========================================
             ROAD LINE UNDER TRUCK
        ========================================== -->

        <div class="road-line"></div>

        <div class="road-dashes"></div>


        <!-- =========================================
             DECORATIVE LEAVES
        ========================================== -->

        

        

        

    </section>


    <!-- =========================================
         FEATURES
    ========================================== -->

    <section class="bg-eco-gray py-20">

        <div
            class="
                max-w-7xl
                mx-auto
                px-6
                lg:px-8
            "
        >

            <!-- SECTION HEADER -->

            <div
                class="
                    text-center
                    max-w-2xl
                    mx-auto
                "
            >

                <p
                    class="
                        text-sm
                        font-bold
                        uppercase
                        tracking-wider
                        text-eco-green
                    "
                >
                    EcoTrack Features
                </p>


                <h2
                    class="
                        mt-3
                        text-3xl
                        sm:text-4xl
                        font-bold
                        text-eco-dark
                    "
                >
                    Better waste management,
                    made simple.
                </h2>


                <p
                    class="
                        mt-4
                        text-gray-600
                    "
                >
                    One platform for residents,
                    barangays, and LGU administrators.
                </p>

            </div>


            <!-- FEATURE CARDS -->

            <div
                class="
                    mt-12
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    lg:grid-cols-4
                    gap-6
                "
            >

                <!-- COLLECTION -->

                <div
                    class="
                        bg-white
                        rounded-2xl
                        p-6
                        border
                        border-gray-100
                        hover:-translate-y-1
                        hover:shadow-lg
                        transition
                    "
                >

                    <div
                        class="
                            w-12
                            h-12
                            rounded-xl
                            bg-eco-light
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >
                        🚛
                    </div>


                    <h3
                        class="
                            mt-5
                            text-lg
                            font-bold
                            text-eco-dark
                        "
                    >
                        Collection Schedules
                    </h3>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-6
                            text-gray-600
                        "
                    >
                        Manage and monitor garbage
                        collection schedules by
                        barangay and zone.
                    </p>

                </div>


                <!-- BARANGAY -->

                <div
                    class="
                        bg-white
                        rounded-2xl
                        p-6
                        border
                        border-gray-100
                        hover:-translate-y-1
                        hover:shadow-lg
                        transition
                    "
                >

                    <div
                        class="
                            w-12
                            h-12
                            rounded-xl
                            bg-eco-light
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >
                        🏘️
                    </div>


                    <h3
                        class="
                            mt-5
                            text-lg
                            font-bold
                            text-eco-dark
                        "
                    >
                        Barangay Management
                    </h3>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-6
                            text-gray-600
                        "
                    >
                        Organize residents and
                        collection activities
                        according to barangay and zone.
                    </p>

                </div>


                <!-- ANNOUNCEMENTS -->

                <div
                    class="
                        bg-white
                        rounded-2xl
                        p-6
                        border
                        border-gray-100
                        hover:-translate-y-1
                        hover:shadow-lg
                        transition
                    "
                >

                    <div
                        class="
                            w-12
                            h-12
                            rounded-xl
                            bg-eco-light
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >
                        📢
                    </div>


                    <h3
                        class="
                            mt-5
                            text-lg
                            font-bold
                            text-eco-dark
                        "
                    >
                        Announcements
                    </h3>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-6
                            text-gray-600
                        "
                    >
                        Keep residents informed
                        about garbage collection
                        and community updates.
                    </p>

                </div>


                <!-- SMS -->

                <div
                    class="
                        bg-white
                        rounded-2xl
                        p-6
                        border
                        border-gray-100
                        hover:-translate-y-1
                        hover:shadow-lg
                        transition
                    "
                >

                    <div
                        class="
                            w-12
                            h-12
                            rounded-xl
                            bg-eco-light
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >
                        📱
                    </div>


                    <h3
                        class="
                            mt-5
                            text-lg
                            font-bold
                            text-eco-dark
                        "
                    >
                        SMS Notifications
                    </h3>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-6
                            text-gray-600
                        "
                    >
                        Help residents stay updated
                        with timely collection
                        notifications.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         CALL TO ACTION
    ========================================== -->

    <section class="bg-white py-20">

        <div class="max-w-5xl mx-auto px-6">

            <div
                class="
                    relative
                    overflow-hidden
                    rounded-3xl
                    bg-eco-dark
                    px-8
                    py-12
                    sm:px-12
                    text-center
                "
            >

                <div
                    class="
                        absolute
                        -top-20
                        -right-20
                        w-64
                        h-64
                        rounded-full
                        bg-eco-green
                        opacity-50
                    "
                ></div>


                <div
                    class="
                        absolute
                        -bottom-24
                        -left-20
                        w-64
                        h-64
                        rounded-full
                        bg-eco-green
                        opacity-40
                    "
                ></div>


                <div class="relative">

                    <img
                        src="{{ asset('images/ecotrack.logo-removebg-preview.png') }}"
                        alt="EcoTrack Logo"
                        class="
                            mx-auto
                            w-20
                            h-20
                            object-contain
                            mb-5
                        "
                    >


                    <h2
                        class="
                            text-3xl
                            sm:text-4xl
                            font-bold
                            text-white
                        "
                    >
                        Ready to make your barangay cleaner?
                    </h2>


                    <p
                        class="
                            mt-4
                            max-w-2xl
                            mx-auto
                            text-eco-light
                        "
                    >
                        Join EcoTrack and help build a more
                        organized, cleaner, and greener community.
                    </p>


                    @if (Route::has('register'))

                        <a
                            href="{{ route('register') }}"
                            class="
                                inline-flex
                                mt-8
                                px-7
                                py-3.5
                                rounded-xl
                                bg-white
                                text-eco-dark
                                font-bold
                                hover:bg-eco-light
                                transition
                            "
                        >
                            Register as Resident
                        </a>

                    @endif

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         FOOTER
    ========================================== -->

    <footer class="bg-eco-dark">

        <div
            class="
                max-w-7xl
                mx-auto
                px-6
                lg:px-8
                py-8
            "
        >

            <div
                class="
                    flex
                    flex-col
                    sm:flex-row
                    items-center
                    justify-between
                    gap-4
                "
            >

                <!-- FOOTER BRAND -->

                <div
                    class="
                        flex
                        items-center
                        gap-3
                    "
                >

                    <img
                        src="{{ asset('images/ecotrack.logo-removebg-preview.png') }}"
                        alt="EcoTrack Logo"
                        class="
                            w-10
                            h-10
                            object-contain
                        "
                    >


                    <div>

                        <p
                            class="
                                font-bold
                                text-white
                            "
                        >
                            EcoTrack
                        </p>

                        <p
                            class="
                                text-xs
                                text-eco-light
                            "
                        >
                            Smart Waste Management
                        </p>

                    </div>

                </div>


                <!-- COPYRIGHT -->

                <p
                    class="
                        text-sm
                        text-eco-light
                    "
                >
                    © {{ date('Y') }} EcoTrack.
                    All rights reserved.
                </p>

            </div>

        </div>

    </footer>


</body>

</html>