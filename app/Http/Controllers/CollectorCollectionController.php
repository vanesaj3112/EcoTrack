<?php

namespace App\Http\Controllers;

use App\Models\CollectionInstance;
use App\Models\CollectionSchedule;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CollectorCollectionController extends Controller
{
    public function start(
        Request $request,
        CollectionSchedule $collectionSchedule
    ): RedirectResponse {
        $collector = auth()->user();

        abort_unless(
            $collectionSchedule->collector_id === $collector->id,
            403
        );

        $instance = CollectionInstance::firstOrCreate(
            [
                'collection_schedule_id' => $collectionSchedule->id,
                'collection_date' => today(),
            ],
            [
                'collector_id' => $collector->id,
                'status' => 'scheduled',
            ]
        );

        $instance->update([
            'collector_id' => $collector->id,
            'status' => 'in_progress',
            'started_at' => now(),
            'completed_at' => null,
        ]);

        AuditLogger::log(
            'COLLECTION_STARTED',
            'Started collection for '
            . ($collectionSchedule->barangay?->name ?? 'Unknown Barangay')
            . ' Zone '
            . $collectionSchedule->zone
            . '.'
        );

        return redirect()
            ->route('collector.dashboard')
            ->with(
                'success',
                'Collection started successfully.'
            );
    }


    public function complete(
        Request $request,
        CollectionSchedule $collectionSchedule
    ): RedirectResponse {
        $collector = auth()->user();

        abort_unless(
            $collectionSchedule->collector_id === $collector->id,
            403
        );

        $instance = CollectionInstance::firstOrCreate(
            [
                'collection_schedule_id' => $collectionSchedule->id,
                'collection_date' => today(),
            ],
            [
                'collector_id' => $collector->id,
                'status' => 'scheduled',
            ]
        );

        $instance->update([
            'collector_id' => $collector->id,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        AuditLogger::log(
            'COLLECTION_COMPLETED',
            'Completed collection for '
            . ($collectionSchedule->barangay?->name ?? 'Unknown Barangay')
            . ' Zone '
            . $collectionSchedule->zone
            . '.'
        );

        return redirect()
            ->route('collector.dashboard')
            ->with(
                'success',
                'Collection marked as completed.'
            );
    }


    public function cancel(
        Request $request,
        CollectionSchedule $collectionSchedule
    ): RedirectResponse {
        $collector = auth()->user();

        abort_unless(
            $collectionSchedule->collector_id === $collector->id,
            403
        );

        $instance = CollectionInstance::firstOrCreate(
            [
                'collection_schedule_id' => $collectionSchedule->id,
                'collection_date' => today(),
            ],
            [
                'collector_id' => $collector->id,
                'status' => 'scheduled',
            ]
        );

        $instance->update([
            'collector_id' => $collector->id,
            'status' => 'cancelled',
            'completed_at' => null,
        ]);

        AuditLogger::log(
            'COLLECTION_CANCELLED',
            'Cancelled collection for '
            . ($collectionSchedule->barangay?->name ?? 'Unknown Barangay')
            . ' Zone '
            . $collectionSchedule->zone
            . '.'
        );

        return redirect()
            ->route('collector.dashboard')
            ->with(
                'success',
                'Collection cancelled for today.'
            );
    }
}