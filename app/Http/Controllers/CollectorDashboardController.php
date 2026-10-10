<?php

namespace App\Http\Controllers;

use App\Models\CollectionRequest;
use App\Models\CollectionSchedule;
use Illuminate\View\View;

class CollectorDashboardController extends Controller
{
    public function index(): View
    {
        $collector = auth()->user();

        $today = now('Asia/Manila')->format('l');
        $todayDate = now('Asia/Manila')->toDateString();

        // 1. Today's Collection
        // Show regular schedules only.
        $schedules = CollectionSchedule::with('barangay')
            ->where('collector_id', $collector->id)
            ->where('status', 'scheduled')
            ->whereNull('collection_request_id')
            ->where(function ($query) use ($today, $todayDate) {
                $query->where(function ($recurring) use ($today) {
                    $recurring->whereNull('collection_date')
                        ->where('day_of_week', $today);
                })->orWhereDate('collection_date', $todayDate);
            })
            ->orderBy('start_time')
            ->get();

        // 2. Incoming Collection Schedule
        // Show future regular schedules only.
        $dayOrder = [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
            'Sunday' => 7,
        ];

        $todayNumber = $dayOrder[$today];

        $incomingSchedules = CollectionSchedule::with('barangay')
            ->where('collector_id', $collector->id)
            ->where('status', 'scheduled')
            ->whereNull('collection_request_id')
            ->where(function ($query) use ($todayDate) {
                $query->whereNull('collection_date')
                    ->orWhereDate('collection_date', '>', $todayDate);
            })
            ->get()
            ->filter(function ($schedule) use ($todayDate) {
                return $schedule->collection_date
                    ? $schedule->collection_date->toDateString() > $todayDate
                    : true;
            })
            ->sortBy(function ($schedule) use (
                $dayOrder,
                $todayNumber
            ) {
                if ($schedule->collection_date) {
                    return [
                        0,
                        $schedule->collection_date->toDateString(),
                        $schedule->start_time,
                    ];
                }

                $scheduleDay = $dayOrder[$schedule->day_of_week] ?? 7;

                $daysUntil = $scheduleDay - $todayNumber;

                if ($daysUntil <= 0) {
                    $daysUntil += 7;
                }

                return [
                    1,
                    $daysUntil,
                    $schedule->start_time,
                ];
            })
            ->values();

        // 3. Incoming Collection Requests (Pending)
        $incomingRequests = CollectionRequest::with([
            'resident',
            'barangay',
        ])
            ->where('assigned_collector_id', $collector->id)
            ->where('status', 'pending')
            ->orderBy('requested_date')
            ->orderBy('preferred_start_time')
            ->get();

        // 4. Accepted Collection Requests
        // Keep accepted requests in their own section.
        $acceptedRequests = CollectionRequest::with([
            'resident',
            'barangay',
        ])
            ->where('assigned_collector_id', $collector->id)
            ->where('status', 'approved')
            ->orderBy('requested_date')
            ->orderBy('preferred_start_time')
            ->get();

        return view('collector.dashboard', compact(
            'schedules',
            'incomingSchedules',
            'incomingRequests',
            'acceptedRequests'
        ));
    }
}