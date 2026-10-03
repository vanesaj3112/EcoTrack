<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-[#1B4332]">
            Account Verification Pending
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            Your EcoTrack account is currently waiting for LGU verification.
        </p>
    </div>

    <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-5">

        <p class="text-sm text-gray-700">
            Thank you for registering with EcoTrack.
        </p>

        <p class="mt-2 text-sm text-gray-700">
            An LGU administrator will review your registration details
            and submitted verification documents.
        </p>

        <p class="mt-2 text-sm text-gray-700">
            You will be able to access the Resident Dashboard
            after your account has been approved.
        </p>

    </div>

    <div class="mt-6 text-center">

        <a
            href="{{ route('login') }}"
            class="inline-flex items-center justify-center
                   rounded-lg
                   bg-[#2D6A4F]
                   px-5 py-2.5
                   text-sm font-medium
                   text-white
                   hover:bg-[#1B4332]
                   transition"
        >
            Back to Login
        </a>

    </div>

</x-guest-layout>