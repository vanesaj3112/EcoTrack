<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\CollectionSchedule;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $resident = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Current Week
        |--------------------------------------------------------------------------
        */

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);

        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);


        /*
        |--------------------------------------------------------------------------
        | Get Resident's Weekly Collection Schedules
        |--------------------------------------------------------------------------
        */

        $schedules = CollectionSchedule::with([
            'barangay',

            'instances' => function ($query) use (
                $startOfWeek,
                $endOfWeek
            ) {
                $query->whereBetween(
                    'collection_date',
                    [
                        $startOfWeek->toDateString(),
                        $endOfWeek->toDateString(),
                    ]
                );
            },
        ])

            ->where(
                'brgy_id',
                $resident->brgy_id
            )

            ->where(
                'zone',
                $resident->zone
            )

            ->where(
                'status',
                'scheduled'
            )

            ->whereIn(
                'day_of_week',
                [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday',
                ]
            )

            ->orderByRaw("
                FIELD(
                    day_of_week,
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday'
                )
            ")

            ->orderBy('start_time')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | Add Actual Calendar Date
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | Monday    → September 28
        | Tuesday   → September 29
        | Wednesday → September 30
        |
        */

        $schedules->each(
            function ($schedule) use ($startOfWeek) {

                $dayNumber = match (
                    $schedule->day_of_week
                ) {

                    'Monday' => 0,

                    'Tuesday' => 1,

                    'Wednesday' => 2,

                    'Thursday' => 3,

                    'Friday' => 4,

                    'Saturday' => 5,

                    'Sunday' => 6,

                    default => null,
                };


                $schedule->collection_day =
                    $dayNumber !== null

                    ? $startOfWeek
                        ->copy()
                        ->addDays($dayNumber)

                    : null;
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Today's Collection
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();


        $todaySchedule = $schedules
            ->first(
                function ($schedule) use ($today) {

                    return $schedule->collection_day
                        ?->isSameDay($today);

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Next Collection
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | greaterThan($today)
        |
        | means today's collection will NOT be shown
        | as the next collection.
        |
        | Example:
        |
        | Today     = Wednesday
        | Next      = Thursday
        |
        */

        $nextSchedule = $schedules

            ->filter(
                function ($schedule) use ($today) {

                    return $schedule->collection_day

                        && $schedule->collection_day
                            ->greaterThan($today);

                }
            )

            ->sortBy(
                function ($schedule) {

                    return $schedule->collection_day
                        ->format('Y-m-d')
                        . ' '
                        . $schedule->start_time;

                }
            )

            ->first();


        /*
        |--------------------------------------------------------------------------
        | Return Resident Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'resident.dashboard',
            compact(
                'schedules',
                'todaySchedule',
                'nextSchedule'
            )
        );
    }
}