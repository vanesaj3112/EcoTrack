<x-admin-layout>

    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-sm font-semibold text-[#2D6A4F]">
                    EcoTrack Collection Management
                </p>

                <h1 class="mt-1 text-3xl font-bold text-[#1B4332]">
                    Edit Garbage Collector
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Update the garbage collector account information.
                </p>

            </div>


            <a
                href="{{ route('admin.garbage-collectors.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:border-[#B7E4C7] hover:bg-[#D8F3DC] hover:text-[#1B4332]"
            >
                ← Back to Collectors
            </a>

        </div>


        {{-- ERRORS --}}
        @if ($errors->any())

            <div
                class="rounded-xl border border-red-200 bg-red-50 px-5 py-4"
            >

                <p class="font-semibold text-red-700">
                    Please check the following:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM --}}
        <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
        >

            {{-- FORM HEADER --}}
            <div class="border-b border-gray-100 px-6 py-5">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-[#D8F3DC] text-xl font-bold text-[#1B4332]"
                    >
                        {{ strtoupper(substr($collector->name, 0, 1)) }}
                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-[#1B4332]">
                            {{ $collector->name }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            Collector ID #{{ $collector->id }}
                        </p>

                    </div>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('admin.garbage-collectors.update', $collector) }}"
                class="p-6"
            >

                @csrf
                @method('PUT')


                <div class="grid gap-6 md:grid-cols-2">


                    {{-- NAME --}}
                    <div>

                        <label
                            for="name"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Full Name
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $collector->name) }}"
                            required
                            class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                        >

                        @error('name')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- EMAIL --}}
                    <div>

                        <label
                            for="email"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Email Address
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $collector->email) }}"
                            required
                            class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                        >

                        @error('email')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- MOBILE --}}
                    <div>

                        <label
                            for="mobile_number"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Mobile Number
                        </label>

                        <input
                            id="mobile_number"
                            name="mobile_number"
                            type="text"
                            value="{{ old('mobile_number', $collector->mobile_number) }}"
                            required
                            class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                        >

                        @error('mobile_number')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- STATUS --}}
                    <div>

                        <label
                            for="status"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Account Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                        >

                            <option
                                value="approved"
                                {{ old('status', $collector->status) === 'approved' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="pending"
                                {{ old('status', $collector->status) === 'pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                        </select>

                        @error('status')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- NEW PASSWORD --}}
                    <div>

                        <label
                            for="password"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            New Password
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                            placeholder="Leave blank to keep current password"
                        >

                        @error('password')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- CONFIRM PASSWORD --}}
                    <div>

                        <label
                            for="password_confirmation"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Confirm New Password
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-[#2D6A4F] focus:ring-[#2D6A4F]"
                            placeholder="Repeat new password"
                        >

                    </div>

                </div>


                {{-- ROLE --}}
                <div
                    class="mt-6 rounded-xl border border-[#B7E4C7] bg-[#D8F3DC] px-5 py-4"
                >

                    <p class="text-sm font-semibold text-[#1B4332]">
                        Account Role
                    </p>

                    <p class="mt-1 text-xs text-[#2D6A4F]">
                        Garbage Collector
                    </p>

                </div>


                {{-- ACTIONS --}}
                <div
                    class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end"
                >

                    <a
                        href="{{ route('admin.garbage-collectors.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-[#1B4332] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2D6A4F]"
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>