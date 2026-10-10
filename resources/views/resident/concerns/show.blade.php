<x-layouts.resident>

    <div class="mb-6">

        <a
            href="{{ route('resident.concerns.index') }}"
            class="text-sm font-semibold text-[#2D6A4F] hover:text-[#1B4332]"
        >
            ← Back to My Concerns
        </a>

    </div>


    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

            <div>

                <p class="text-sm text-gray-500">
                    {{ $concern->category }}
                </p>

                <h1 class="mt-1 text-2xl font-bold text-[#1B4332]">
                    {{ $concern->subject }}
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Submitted {{ $concern->created_at->format('M d, Y h:i A') }}
                </p>

            </div>


            @php
                $statusClasses = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'in_review' => 'bg-blue-100 text-blue-800',
                    'resolved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                ];
            @endphp

            <span
                class="inline-flex rounded-full px-4 py-2 text-sm font-semibold
                {{ $statusClasses[$concern->status] ?? 'bg-gray-100 text-gray-700' }}"
            >
                {{ ucwords(str_replace('_', ' ', $concern->status)) }}
            </span>

        </div>


        <div class="mt-6 pt-6 border-t border-gray-200">

            <h2 class="font-semibold text-gray-700">
                Description
            </h2>

            <p class="mt-2 text-gray-700 whitespace-pre-line">
                {{ $concern->description }}
            </p>

        </div>


        @if ($concern->photo_path)

            <div class="mt-6">

                <h2 class="font-semibold text-gray-700 mb-3">
                    Supporting Photo
                </h2>

                <img
                    src="{{ asset('storage/' . $concern->photo_path) }}"
                    alt="Concern photo"
                    class="max-w-full sm:max-w-lg rounded-xl border border-gray-200"
                >

            </div>

        @endif


        @if ($concern->admin_response)

            <div class="mt-6 rounded-xl bg-[#D8F3DC] border border-[#B7E4C7] p-5">

                <h2 class="font-semibold text-[#1B4332]">
                    LGU Response
                </h2>

                <p class="mt-2 text-gray-700 whitespace-pre-line">
                    {{ $concern->admin_response }}
                </p>

            </div>

        @endif


    </div>

</x-layouts.resident>