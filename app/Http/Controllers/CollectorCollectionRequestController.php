<?php

namespace App\Http\Controllers;

use App\Models\CollectionInstance;
use App\Models\CollectionRequest;
use App\Models\CollectionSchedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CollectorCollectionRequestController extends Controller
{
    public function accept(
        CollectionRequest $collectionRequest
    ): RedirectResponse {
        $collector = auth()->user();

        abort_unless(
            (int) $collectionRequest->assigned_collector_id ===
                (int) $collector->id,
            403
        );

        DB::transaction(function () use (
            $collectionRequest,
            $collector
        ) {
            $requestRecord = CollectionRequest::whereKey(
                $collectionRequest->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            // Only pending requests can be accepted.
            if ($requestRecord->status !== 'pending') {
                throw ValidationException::withMessages([
                    'request' => 'This request is no longer pending.',
                ]);
            }

            $date = Carbon::parse(
                $requestRecord->requested_date
            );

            $day = $date->format('l');
            $start = $requestRecord->preferred_start_time;
            $end = $requestRecord->preferred_end_time;

            // Check for overlapping scheduled collections.
            $scheduleConflict = CollectionSchedule::query()
                ->where('collector_id', $collector->id)
                ->where('status', 'scheduled')
                ->where(function ($query) use ($date, $day) {
                    $query
                        ->whereDate(
                            'collection_date',
                            $date->toDateString()
                        )
                        ->orWhere(function ($recurring) use ($day) {
                            $recurring
                                ->whereNull('collection_date')
                                ->where('day_of_week', $day);
                        });
                })
                ->where('start_time', '<', $end)
                ->where('end_time', '>', $start)
                ->exists();

            // Check for overlapping pending or accepted requests
            // assigned to this collector on the same date.
            $requestConflict = CollectionRequest::query()
                ->where('id', '!=', $requestRecord->id)
                ->where(
                    'assigned_collector_id',
                    $collector->id
                )
                ->whereDate(
                    'requested_date',
                    $date->toDateString()
                )
                ->whereIn('status', ['pending', 'approved'])
                ->where('preferred_start_time', '<', $end)
                ->where('preferred_end_time', '>', $start)
                ->exists();

            if ($scheduleConflict || $requestConflict) {
                throw ValidationException::withMessages([
                    'request' =>
                        'This time conflicts with another schedule or request. The request was not accepted.',
                ]);
            }

           
// Create a one-time collection schedule linked to the resident request.
$schedule = CollectionSchedule::create([
    'collection_request_id' => $requestRecord->id,
    'brgy_id' => $requestRecord->brgy_id,
    'zone' => $requestRecord->zone,
    'day_of_week' => $day,
    'collection_date' => $date->toDateString(),
    'start_time' => $start,
    'end_time' => $end,
    'collector_id' => $collector->id,
    'status' => 'scheduled',
    'created_by' => $collector->id,
]);

            // Create the collection instance for that date.
            CollectionInstance::create([
                'collection_schedule_id' => $schedule->id,
                'collection_date' => $date->toDateString(),
                'collector_id' => $collector->id,
                'status' => 'scheduled',
            ]);

            // Mark the request as accepted.
            $requestRecord->update([
                'status' => 'approved',
                'reviewed_by' => $collector->id,
                'reviewed_at' => now('Asia/Manila'),
            ]);
        });

        return back()->with(
            'success',
            'Collection request accepted and added to your schedule.'
        );
    }

    public function reject(
        CollectionRequest $collectionRequest
    ): RedirectResponse {
        $collector = auth()->user();

        abort_unless(
            (int) $collectionRequest->assigned_collector_id ===
                (int) $collector->id,
            403
        );

        DB::transaction(function () use (
            $collectionRequest,
            $collector
        ) {
            $requestRecord = CollectionRequest::whereKey(
                $collectionRequest->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            if ($requestRecord->status !== 'pending') {
                throw ValidationException::withMessages([
                    'request' =>
                        'Only pending requests can be rejected.',
                ]);
            }

            $requestRecord->update([
                'status' => 'rejected',
                'reviewed_by' => $collector->id,
                'reviewed_at' => now('Asia/Manila'),
            ]);
        });

        return back()->with(
            'success',
            'Collection request rejected.'
        );
    }
}
