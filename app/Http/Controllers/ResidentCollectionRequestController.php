<?php

namespace App\Http\Controllers;

use App\Models\CollectionRequest;
use App\Models\CollectionSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ResidentCollectionRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $resident = auth()->user();

        if (!$resident->brgy_id || !$resident->zone) {
            return back()->withErrors([
                'request' => 'Your barangay and zone must be set before requesting a collection.',
            ])->withInput();
        }

        $validated = $request->validate([
            'assigned_collector_id' => ['required', 'integer', 'exists:users,id'],
            'requested_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_start_time' => ['required', 'date_format:H:i'],
            'preferred_end_time' => ['required', 'date_format:H:i', 'after:preferred_start_time'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $collector = User::whereKey($validated['assigned_collector_id'])
            ->where('role', 'garbage_collector')
            ->first();

        if (!$collector) {
            throw ValidationException::withMessages([
                'assigned_collector_id' => 'Please select a valid garbage collector.',
            ]);
        }

        $date = Carbon::parse($validated['requested_date']);
        $day = $date->format('l');

        // The selected collector must have a scheduled route on this date.
        $hasSchedule = CollectionSchedule::query()
            ->where('collector_id', $collector->id)
            ->where('status', 'scheduled')
            ->where(function ($query) use ($date, $day) {
                $query->whereDate('collection_date', $date->toDateString())
                    ->orWhere(function ($recurring) use ($day) {
                        $recurring->whereNull('collection_date')
                            ->where('day_of_week', $day);
                    });
            })
            ->exists();

        if (!$hasSchedule) {
            throw ValidationException::withMessages([
                'assigned_collector_id' => 'This collector does not have a scheduled collection on the selected date. Please choose another collector or date.',
            ]);
        }

        $requestStart = $validated['preferred_start_time'];
        $requestEnd = $validated['preferred_end_time'];

        // Check existing scheduled routes for time conflicts.
        $conflict = CollectionSchedule::query()
            ->where('collector_id', $collector->id)
            ->where('status', 'scheduled')
            ->where(function ($query) use ($date, $day) {
                $query->whereDate('collection_date', $date->toDateString())
                    ->orWhere(function ($recurring) use ($day) {
                        $recurring->whereNull('collection_date')
                            ->where('day_of_week', $day);
                    });
            })
            ->where('start_time', '<', $requestEnd)
            ->where('end_time', '>', $requestStart)
            ->exists();

        // Prevent duplicate overlapping pending/approved requests as well.
        $requestConflict = CollectionRequest::query()
            ->where('assigned_collector_id', $collector->id)
            ->whereDate('requested_date', $date->toDateString())
            ->whereIn('status', ['pending', 'approved'])
            ->where('preferred_start_time', '<', $requestEnd)
            ->where('preferred_end_time', '>', $requestStart)
            ->exists();

        if ($conflict || $requestConflict) {
            throw ValidationException::withMessages([
                'assigned_collector_id' => 'That collector has a schedule or request during this time. Please select another collector or time.',
            ]);
        }

        CollectionRequest::create([
            'resident_id' => $resident->id,
            'brgy_id' => $resident->brgy_id,
            'zone' => $resident->zone,
            'requested_date' => $validated['requested_date'],
            'preferred_start_time' => $requestStart,
            'preferred_end_time' => $requestEnd,
            'notes' => $validated['notes'] ?? null,
            'assigned_collector_id' => $collector->id,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('resident.schedule')
            ->with('success', 'Your request was sent directly to the selected collector.');
    }

    public function cancel(CollectionRequest $collectionRequest): RedirectResponse
    {
        abort_unless($collectionRequest->resident_id === auth()->id(), 403);

        if ($collectionRequest->status !== 'pending') {
            return back()->withErrors([
                'request' => 'Only pending requests can be cancelled.',
            ]);
        }

        $collectionRequest->update(['status' => 'cancelled']);

        return back()->with('success', 'Your collection request has been cancelled.');
    }
}
