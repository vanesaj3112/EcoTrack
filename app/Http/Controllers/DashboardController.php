<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CollectionSchedule;
use App\Models\CollectionInstance;
use App\Models\Announcement;
use App\Models\Barangay;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(): RedirectResponse|View
    {
        $user = auth()->user();

        // Redirect users to their role-specific dashboards.
        if ($user && $user->role === 'garbage_collector') {
            return redirect()->route('collector.dashboard');
        }

        if ($user && $user->role === 'resident') {
            return redirect()->route('resident.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalResidents = User::where('role', 'resident')->count();

        $pendingVerification = User::where('role', 'resident')
            ->where('status', 'pending')
            ->count();

        $approvedResidents = User::where('role', 'resident')
            ->where('status', 'approved')
            ->count();

        $rejectedResidents = User::where('role', 'resident')
            ->where('status', 'rejected')
            ->count();

        $activeCollectors = User::where('role', 'garbage_collector')
            ->where('status', 'approved')
            ->count();

        $collectionSchedules = CollectionSchedule::count();

        $announcements = Announcement::count();

        $totalBarangays = Barangay::count();

        /*
        |--------------------------------------------------------------------------
        | MONTHLY COLLECTION PERFORMANCE
        |--------------------------------------------------------------------------
        | Current month and previous five months.
        */

        $monthlyCollectionTrends = collect();

        $firstMonth = Carbon::now()->startOfMonth()->subMonths(5);
        $today = Carbon::today();

        $monthlyTotals = CollectionInstance::query()
            ->selectRaw(
                'YEAR(collection_date) as collection_year,
                 MONTH(collection_date) as collection_month,
                 COUNT(*) as total,
                 SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completed,
                 SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as cancelled',
                ['completed', 'cancelled']
            )
            ->where('collection_date', '>=', $firstMonth->toDateString())
            ->where('collection_date', '<=', $today->toDateString())
            ->groupByRaw('YEAR(collection_date), MONTH(collection_date)')
            ->get()
            ->keyBy(function ($item) {
                return sprintf(
                    '%04d-%02d',
                    $item->collection_year,
                    $item->collection_month
                );
            });

        for ($i = 0; $i < 6; $i++) {
            $month = $firstMonth->copy()->addMonths($i);
            $data = $monthlyTotals->get($month->format('Y-m'));

            $monthlyCollectionTrends->push([
                'month' => $month->format('M Y'),
                'total' => (int) ($data->total ?? 0),
                'completed' => (int) ($data->completed ?? 0),
                'cancelled' => (int) ($data->cancelled ?? 0),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | WEEKLY COLLECTION ANALYTICS
        |--------------------------------------------------------------------------
        | Monday through Sunday of the current week.
        */

        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $weeklyCollectionAnalytics = $this->getBarangayCollectionAnalytics(
            $weekStart,
            $weekEnd
        );

        /*
        |--------------------------------------------------------------------------
        | OVERALL COLLECTION ANALYTICS
        |--------------------------------------------------------------------------
        | All collection instances, regardless of date.
        */

        $overallCollectionAnalytics = $this->getBarangayCollectionAnalytics();

        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalResidents',
            'pendingVerification',
            'approvedResidents',
            'rejectedResidents',
            'activeCollectors',
            'collectionSchedules',
            'announcements',
            'totalBarangays',
            'monthlyCollectionTrends',
            'weeklyCollectionAnalytics',
            'overallCollectionAnalytics'
        ));
    }

    /**
     * Get completed and cancelled collection counts for every barangay.
     *
     * If dates are supplied, only collection instances within that date
     * range are included. Otherwise, all dates are included.
     */
    private function getBarangayCollectionAnalytics(
        ?Carbon $startDate = null,
        ?Carbon $endDate = null
    ) {
        $query = Barangay::query()
            ->leftJoin(
                'collection_schedules',
                'barangays.id',
                '=',
                'collection_schedules.brgy_id'
            )
            ->leftJoin(
                'collection_instances',
                'collection_schedules.id',
                '=',
                'collection_instances.collection_schedule_id'
            );

        if ($startDate && $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('collection_instances.collection_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]);
            });
        }

        $barangayRows = $query
            ->selectRaw(
                'barangays.id,
                 barangays.name as barangay_name,
                 COALESCE(SUM(
                    CASE
                        WHEN collection_instances.status = ? THEN 1
                        ELSE 0
                    END
                 ), 0) as completed,
                 COALESCE(SUM(
                    CASE
                        WHEN collection_instances.status = ? THEN 1
                        ELSE 0
                    END
                 ), 0) as cancelled',
                ['completed', 'cancelled']
            )
            ->groupBy('barangays.id', 'barangays.name')
            ->orderBy('barangays.name')
            ->get();

        $totalCompleted = (int) $barangayRows->sum('completed');
        $totalCancelled = (int) $barangayRows->sum('cancelled');

        $barangays = $barangayRows->map(function ($row) {
            $completed = (int) $row->completed;
            $cancelled = (int) $row->cancelled;
            $finalized = $completed + $cancelled;

            return [
                'barangay_name' => $row->barangay_name,
                'completed' => $completed,
                'cancelled' => $cancelled,
                'completion_rate' => $finalized > 0
                    ? round(($completed / $finalized) * 100, 2)
                    : 0,
            ];
        });

        $totalFinalized = $totalCompleted + $totalCancelled;

        return [
            'barangays' => $barangays,
            'total_completed' => $totalCompleted,
            'total_cancelled' => $totalCancelled,
            'total_completion_rate' => $totalFinalized > 0
                ? round(($totalCompleted / $totalFinalized) * 100, 2)
                : 0,
        ];
    }
}
