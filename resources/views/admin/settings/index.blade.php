<x-admin-layout>
    <div class="p-6">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-eco-dark">
                Site Settings
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                Manage your EcoTrack site name and admin dashboard logo.
            </p>
        </div>

        @if (session('status') === 'settings-updated')
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                Site settings updated successfully.
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <form
                action="{{ route('admin.settings.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Site Name
                    </label>

                    <input
                        type="text"
                        name="site_name"
                        value="{{ old('site_name', $settings?->site_name ?? 'EcoTrack') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-eco-green focus:outline-none focus:ring-2 focus:ring-eco-light"
                        required
                    >
                </div>

                <div class="mb-6">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Admin Dashboard Logo
                    </label>

                    @if ($settings?->logo_path)
                        <div class="mb-4">
                            <p class="mb-2 text-xs font-medium uppercase tracking-wide text-gray-500">
                                Current Logo
                            </p>

                            <div class="inline-flex rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <img
                                    src="{{ asset('storage/' . $settings->logo_path) }}"
                                    alt="Current EcoTrack logo"
                                    class="h-20 w-auto object-contain"
                                >
                            </div>
                        </div>
                    @endif

                    <input
                        type="file"
                        name="logo"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-eco-green file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-eco-dark"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        JPG, JPEG, PNG, or WEBP. Maximum file size: 2MB.
                    </p>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="rounded-lg bg-eco-green px-6 py-3 text-sm font-semibold text-white transition hover:bg-eco-dark"
                    >
                        Save Settings
                    </button>
                </div>

            </form>

        </div>

    </div>
</x-admin-layout>