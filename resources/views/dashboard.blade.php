<x-admin-layout>
    {{-- HEADER --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-eco-dark">Dashboard</h2>
        <p class="mt-1 text-sm text-gray-500">
            Welcome to EcoTrack LGU Administration.
        </p>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

        <a href="{{ route('admin.residents.index') }}"
           class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition hover:border-eco-green">
            <p class="text-sm text-gray-500">Total Residents</p>
            <p class="mt-2 text-3xl font-bold text-eco-dark">{{ $totalResidents }}</p>
        </a>

        <a href="{{ route('admin.barangays.index') }}"
           class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition hover:border-eco-green">
            <p class="text-sm text-gray-500">Total Barangays</p>
            <p class="mt-2 text-3xl font-bold text-eco-dark">{{ $totalBarangays }}</p>
        </a>

        <a href="{{ route('admin.announcements.index') }}"
           class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition hover:border-eco-green">
            <p class="text-sm text-gray-500">Total Announcements</p>
            <p class="mt-2 text-3xl font-bold text-eco-dark">{{ $announcements }}</p>
        </a>

        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Active Collectors</p>
            <p class="mt-2 text-3xl font-bold text-eco-green">{{ $activeCollectors }}</p>
        </div>

        <a href="{{ route('admin.collection-schedules.index') }}"
           class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition hover:border-eco-green">
            <p class="text-sm text-gray-500">All Collection Schedules</p>
            <p class="mt-2 text-3xl font-bold text-eco-dark">{{ $collectionSchedules }}</p>
        </a>

    </div>

    {{-- RESIDENT VERIFICATION STATUS --}}
    <section class="mt-8 rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-bold text-eco-dark">
                Resident Verification Status
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Current status of resident accounts.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <a href="{{ route('admin.residents.index', ['status' => 'approved']) }}"
               class="rounded-lg bg-eco-light p-4 transition hover:shadow-sm">
                <p class="text-sm text-eco-green">Approved</p>
                <p class="mt-2 text-2xl font-bold text-eco-green">
                    {{ $approvedResidents }}
                </p>
            </a>

            <a href="{{ route('admin.residents.index', ['status' => 'pending']) }}"
               class="rounded-lg bg-yellow-50 p-4 transition hover:shadow-sm">
                <p class="text-sm text-yellow-700">Pending</p>
                <p class="mt-2 text-2xl font-bold text-yellow-700">
                    {{ $pendingVerification }}
                </p>
            </a>

            <a href="{{ route('admin.residents.index', ['status' => 'rejected']) }}"
               class="rounded-lg bg-red-50 p-4 transition hover:shadow-sm">
                <p class="text-sm text-red-600">Rejected</p>
                <p class="mt-2 text-2xl font-bold text-red-600">
                    {{ $rejectedResidents }}
                </p>
            </a>

        </div>
    </section>

    {{-- MONTHLY COLLECTION PERFORMANCE --}}
    <section class="mt-8 rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-bold text-eco-dark">
                Monthly Collection Performance
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Collection totals for the current month and previous five months.
            </p>
        </div>

        {{-- MONTHLY BAR CHART --}}
        <div class="mb-6 rounded-lg border border-gray-100 bg-gray-50 p-4">
            <h4 class="mb-3 font-semibold text-gray-700">
                Monthly Completed vs Cancelled
            </h4>
            <div class="relative h-72 sm:h-80">
                <canvas id="monthlyCollectionChart"></canvas>
            </div>
        </div>

        {{-- MONTHLY TABLE --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Month</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Total Collections</th>
                        <th class="px-4 py-3 text-right font-semibold text-green-700">Completed</th>
                        <th class="px-4 py-3 text-right font-semibold text-red-600">Cancelled</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Completion Rate</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($monthlyCollectionTrends as $month)
                        @php
                            $finalized = $month['completed'] + $month['cancelled'];
                            $rate = $finalized > 0
                                ? ($month['completed'] / $finalized) * 100
                                : 0;
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-eco-dark">
                                {{ $month['month'] }}
                            </td>
                            <td class="px-4 py-3 text-right text-gray-700">
                                {{ $month['total'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-green-700">
                                {{ $month['completed'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-red-600">
                                {{ $month['cancelled'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-eco-dark">
                                {{ number_format($rate, 2) }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                No monthly collection data available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- WEEKLY COLLECTION ANALYTICS --}}
    <section class="mt-8 rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-bold text-eco-dark">
                Weekly Collection Analytics
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Per-barangay performance for the current week (Monday to Sunday).
            </p>
        </div>

        {{-- WEEKLY BAR CHART --}}
        <div class="mb-6 rounded-lg border border-gray-100 bg-gray-50 p-4">
            <h4 class="mb-3 font-semibold text-gray-700">
                Weekly Collections by Barangay
            </h4>

            <div class="relative"
                 style="height: {{ max(280, $weeklyCollectionAnalytics['barangays']->count() * 55) }}px;">
                <canvas id="weeklyCollectionChart"></canvas>
            </div>
        </div>

        {{-- WEEKLY TABLE --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Barangay</th>
                        <th class="px-4 py-3 text-right font-semibold text-green-700">Completed</th>
                        <th class="px-4 py-3 text-right font-semibold text-red-600">Cancelled</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Completion Rate</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($weeklyCollectionAnalytics['barangays'] as $barangay)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-eco-dark">
                                {{ $barangay['barangay_name'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-green-700">
                                {{ $barangay['completed'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-red-600">
                                {{ $barangay['cancelled'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-eco-dark">
                                {{ number_format($barangay['completion_rate'], 2) }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                No barangays found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot class="bg-eco-light">
                    <tr>
                        <td class="px-4 py-3 font-bold text-eco-dark">ALL BARANGAYS</td>
                        <td class="px-4 py-3 text-right font-bold text-green-700">
                            {{ $weeklyCollectionAnalytics['total_completed'] }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-red-600">
                            {{ $weeklyCollectionAnalytics['total_cancelled'] }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-eco-dark">
                            {{ number_format($weeklyCollectionAnalytics['total_completion_rate'], 2) }}%
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    {{-- OVERALL COLLECTION ANALYTICS --}}
    <section class="mt-8 rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-bold text-eco-dark">
                Overall Collection Analytics
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                All recorded collection instances across all barangays.
            </p>
        </div>

        {{-- OVERALL BAR CHART --}}
        <div class="mb-6 rounded-lg border border-gray-100 bg-gray-50 p-4">
            <h4 class="mb-3 font-semibold text-gray-700">
                All-Time Collections by Barangay
            </h4>

            <div class="relative"
                 style="height: {{ max(280, $overallCollectionAnalytics['barangays']->count() * 55) }}px;">
                <canvas id="overallCollectionChart"></canvas>
            </div>
        </div>

        {{-- OVERALL TABLE --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Barangay</th>
                        <th class="px-4 py-3 text-right font-semibold text-green-700">Completed</th>
                        <th class="px-4 py-3 text-right font-semibold text-red-600">Cancelled</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Completion Rate</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($overallCollectionAnalytics['barangays'] as $barangay)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-eco-dark">
                                {{ $barangay['barangay_name'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-green-700">
                                {{ $barangay['completed'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-red-600">
                                {{ $barangay['cancelled'] }}
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-eco-dark">
                                {{ number_format($barangay['completion_rate'], 2) }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                No barangays found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot class="bg-eco-light">
                    <tr>
                        <td class="px-4 py-3 font-bold text-eco-dark">ALL BARANGAYS</td>
                        <td class="px-4 py-3 text-right font-bold text-green-700">
                            {{ $overallCollectionAnalytics['total_completed'] }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-red-600">
                            {{ $overallCollectionAnalytics['total_cancelled'] }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-eco-dark">
                            {{ number_format($overallCollectionAnalytics['total_completion_rate'], 2) }}%
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    {{-- CHART.JS LIBRARY --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- CHART INITIALIZATION --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const monthlyData = @json($monthlyCollectionTrends->values());

            const weeklyData = @json(
                $weeklyCollectionAnalytics['barangays']->values()
            );

            const overallData = @json(
                $overallCollectionAnalytics['barangays']->values()
            );

            const green = '#16a34a';
            const darkGreen = '#14532d';
            const red = '#dc2626';

            function createBarChart(
                canvasId,
                labels,
                completed,
                cancelled,
                horizontal = false
            ) {
                const canvas = document.getElementById(canvasId);

                if (!canvas || typeof Chart === 'undefined') {
                    return;
                }

                new Chart(canvas, {
                    type: 'bar',

                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Completed',
                                data: completed,
                                backgroundColor: green,
                                borderRadius: 4,
                                maxBarThickness: 32
                            },
                            {
                                label: 'Cancelled',
                                data: cancelled,
                                backgroundColor: red,
                                borderRadius: 4,
                                maxBarThickness: 32
                            }
                        ]
                    },

                    options: {
                        indexAxis: horizontal ? 'y' : 'x',
                        responsive: true,
                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                enabled: true
                            }
                        },

                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: horizontal
                                    ? { autoSkip: false }
                                    : { precision: 0 }
                            }
                        }
                    }
                });
            }

            // MONTHLY COLLECTION PERFORMANCE
            createBarChart(
                'monthlyCollectionChart',
                monthlyData.map(item => item.month),
                monthlyData.map(item => Number(item.completed)),
                monthlyData.map(item => Number(item.cancelled))
            );

            // WEEKLY COLLECTION ANALYTICS
            createBarChart(
                'weeklyCollectionChart',
                weeklyData.map(item => item.barangay_name),
                weeklyData.map(item => Number(item.completed)),
                weeklyData.map(item => Number(item.cancelled)),
                true
            );

            // OVERALL COLLECTION ANALYTICS
            createBarChart(
                'overallCollectionChart',
                overallData.map(item => item.barangay_name),
                overallData.map(item => Number(item.completed)),
                overallData.map(item => Number(item.cancelled)),
                true
            );
        });
    </script>
</x-admin-layout>
