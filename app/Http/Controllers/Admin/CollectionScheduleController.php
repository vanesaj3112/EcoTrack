<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\CollectionSchedule;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class CollectionScheduleController extends Controller
{
    public function index()
    {
        $barangays = Barangay::withCount('users')
            ->orderBy('name')
            ->get();

        return view(
            'admin.collection-schedules.index',
            compact('barangays')
        );
    }

    public function show(Barangay $barangay)
    {
        $schedules = CollectionSchedule::with([
            'barangay',
            'collector',
        ])
            ->where('brgy_id', $barangay->id)
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
            ->orderBy('zone')
            ->orderBy('start_time')
            ->get();

        $collectors = User::where('role', 'garbage_collector')
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        return view(
            'admin.collection-schedules.show',
            compact(
                'barangay',
                'schedules',
                'collectors'
            )
        );
    }

    public function store(Request $request, Barangay $barangay)
    {
        $validated = $request->validate([
            'zone' => [
                'required',
                'string',
                'max:100',
            ],

            'day_of_week' => [
                'required',
                'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'collector_id' => [
                'nullable',
                'exists:users,id',
            ],

            'status' => [
                'required',
                'in:scheduled,cancelled',
            ],
        ]);

        CollectionSchedule::create([
            'brgy_id' => $barangay->id,
            'zone' => $validated['zone'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'collector_id' => $validated['collector_id'],
            'status' => $validated['status'],
            'created_by' => auth()->id(),
        ]);

        AuditLogger::log(
            'SCHEDULE_CREATED',
            'Created collection schedule for '
            . $barangay->name
            . ' Zone '
            . $validated['zone']
            . ' on '
            . $validated['day_of_week']
            . '.'
        );

        return redirect()
            ->route(
                'admin.collection-schedules.show',
                $barangay
            )
            ->with(
                'success',
                'Collection schedule created successfully.'
            );
    }

    public function update(
        Request $request,
        Barangay $barangay,
        CollectionSchedule $collectionSchedule
    ) {
        abort_unless(
            $collectionSchedule->brgy_id === $barangay->id,
            404
        );

        $validated = $request->validate([
            'zone' => [
                'required',
                'string',
                'max:100',
            ],

            'day_of_week' => [
                'required',
                'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'collector_id' => [
                'nullable',
                'exists:users,id',
            ],

            'status' => [
                'required',
                'in:scheduled,cancelled',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Detect Changes Before Updating
        |--------------------------------------------------------------------------
        */

        $changes = [];

        foreach ($validated as $field => $newValue) {

            $oldValue = $collectionSchedule->{$field};

            if ((string) $oldValue !== (string) $newValue) {

                $fieldName = match ($field) {

                    'zone' => 'Zone',

                    'day_of_week' => 'Day',

                    'start_time' => 'Start Time',

                    'end_time' => 'End Time',

                    'collector_id' => 'Collector',

                    'status' => 'Status',

                    default => ucfirst(
                        str_replace('_', ' ', $field)
                    ),
                };

                /*
                |--------------------------------------------------------------------------
                | Collector
                |--------------------------------------------------------------------------
                */

                if ($field === 'collector_id') {

                    $oldCollector = $collectionSchedule->collector;

                    $newCollector = $newValue
                        ? User::find($newValue)
                        : null;

                    $oldDisplay =
                        $oldCollector?->name ?? 'Unassigned';

                    $newDisplay =
                        $newCollector?->name ?? 'Unassigned';
                }

                /*
                |--------------------------------------------------------------------------
                | Time
                |--------------------------------------------------------------------------
                */

                elseif (
                    $field === 'start_time'
                    || $field === 'end_time'
                ) {

                    $oldDisplay = $oldValue
                        ? date(
                            'g:i A',
                            strtotime($oldValue)
                        )
                        : 'None';

                    $newDisplay = $newValue
                        ? date(
                            'g:i A',
                            strtotime($newValue)
                        )
                        : 'None';
                }

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                elseif ($field === 'status') {

                    $oldDisplay = $oldValue === 'scheduled'
                        ? 'Active'
                        : 'Cancelled';

                    $newDisplay = $newValue === 'scheduled'
                        ? 'Active'
                        : 'Cancelled';
                }

                /*
                |--------------------------------------------------------------------------
                | Other Fields
                |--------------------------------------------------------------------------
                */

                else {

                    $oldDisplay =
                        $oldValue ?? 'None';

                    $newDisplay =
                        $newValue ?? 'None';
                }

                $changes[] =
                    $fieldName
                    . ': '
                    . $oldDisplay
                    . ' → '
                    . $newDisplay;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update Schedule
        |--------------------------------------------------------------------------
        */

        $collectionSchedule->update([
            'zone' => $validated['zone'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'collector_id' => $validated['collector_id'],
            'status' => $validated['status'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        if (!empty($changes)) {

            AuditLogger::log(
                'SCHEDULE_UPDATED',
                'Updated collection schedule for '
                . $barangay->name
                . '. Changes: '
                . implode('; ', $changes)
            );
        }

        return redirect()
            ->route(
                'admin.collection-schedules.show',
                $barangay
            )
            ->with(
                'success',
                'Collection schedule updated successfully.'
            );
    }

    public function destroy(
        Barangay $barangay,
        CollectionSchedule $collectionSchedule
    ) {
        abort_unless(
            $collectionSchedule->brgy_id === $barangay->id,
            404
        );

        $collectionSchedule->delete();

        AuditLogger::log(
            'SCHEDULE_DELETED',
            'Deleted collection schedule for '
            . $barangay->name
            . ' Zone '
            . $collectionSchedule->zone
            . ' on '
            . $collectionSchedule->day_of_week
            . '.'
        );

        return redirect()
            ->route(
                'admin.collection-schedules.show',
                $barangay
            )
            ->with(
                'success',
                'Collection schedule deleted successfully.'
            );
    }
}