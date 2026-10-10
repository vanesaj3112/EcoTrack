<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Barangay;
use App\Models\AdminNotification;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Residents List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Mark New Resident Notifications as Read
        |--------------------------------------------------------------------------
        |
        | Opening the Residents page means the admin has seen
        | the new resident notifications.
        |
        */

        AdminNotification::where(
            'admin_id',
            auth()->id()
        )
            ->where(
                'type',
                'new_resident'
            )
            ->where(
                'is_read',
                false
            )
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        /*
        |--------------------------------------------------------------------------
        | Resident Statistics
        |--------------------------------------------------------------------------
        */

        $residentQuery = User::where(
            'role',
            'resident'
        );

        $totalResidents = (clone $residentQuery)
            ->count();

        $pendingResidents = (clone $residentQuery)
            ->where(
                'status',
                'pending'
            )
            ->count();

        $approvedResidents = (clone $residentQuery)
            ->where(
                'status',
                'approved'
            )
            ->count();

        $rejectedResidents = (clone $residentQuery)
            ->where(
                'status',
                'rejected'
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Residents Query
        |--------------------------------------------------------------------------
        */

        $query = User::with('barangay')
            ->where(
                'role',
                'resident'
            );

        /*
        |--------------------------------------------------------------------------
        | Search Resident
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )

                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'zone',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhereHas(
                        'barangay',
                        function ($barangayQuery) use ($search) {

                            $barangayQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status')
            && in_array(
                $request->status,
                [
                    'pending',
                    'approved',
                    'rejected',
                ]
            )
        ) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Get Residents
        |--------------------------------------------------------------------------
        */

        $residents = $query
            ->orderBy(
                'created_at',
                'desc'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.residents.index',
            compact(
                'residents',
                'totalResidents',
                'pendingResidents',
                'approvedResidents',
                'rejectedResidents'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create Resident Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $barangays = Barangay::orderBy(
            'name'
        )->get();

        return view(
            'admin.residents.create',
            compact('barangays')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store Resident
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'mobile_number' => [
                'required',
                'string',
                'max:20',
            ],

            'brgy_id' => [
                'required',
                'exists:barangays,id',
            ],

            'zone' => [
                'required',
                'string',
                'max:100',
            ],

            'address' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:pending,approved',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Resident
        |--------------------------------------------------------------------------
        */

        $resident = User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'mobile_number' =>
                $validated['mobile_number'],

            'role' => 'resident',

            'brgy_id' =>
                $validated['brgy_id'],

            'zone' =>
                $validated['zone'],

            'address' =>
                $validated['address'],

            'status' =>
                $validated['status'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        AuditLogger::log(

            'RESIDENT_CREATED',

            'Created resident account for '
            . $resident->name
            . ' ('
            . $resident->email
            . ').'

        );

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()

            ->route(
                'admin.residents.index'
            )

            ->with(
                'success',
                'Resident account created successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Show Resident
    |--------------------------------------------------------------------------
    */

    public function show(User $resident)
    {
        abort_unless(
            $resident->role === 'resident',
            404
        );

        $resident->load(
            'barangay'
        );

        return view(
            'admin.residents.show',
            compact('resident')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Resident Documents
    |--------------------------------------------------------------------------
    */

    public function document(
        User $resident,
        string $type
    ) {
        abort_unless(
            $resident->role === 'resident',
            404
        );

        $path = match ($type) {

            'verification' =>
                $resident->verification_document,

            'residency' =>
                $resident->residency_document,

            default =>
                null,

        };

        abort_unless(
            $path && Storage::exists($path),
            404
        );

        return Storage::response(
            $path
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Resident
    |--------------------------------------------------------------------------
    */

    public function edit(User $resident)
    {
        abort_unless(
            $resident->role === 'resident',
            404
        );

        $barangays = Barangay::orderBy(
            'name'
        )->get();

        return view(
            'admin.residents.edit',
            compact(
                'resident',
                'barangays'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Resident
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $resident
    ) {
        abort_unless(
            $resident->role === 'resident',
            404
        );

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $resident->id,
            ],

            'mobile_number' => [
                'required',
                'string',
                'max:20',
            ],

            'brgy_id' => [
                'required',
                'exists:barangays,id',
            ],

            'zone' => [
                'required',
                'string',
                'max:100',
            ],

            'address' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:pending,approved,rejected',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Detect Changes
        |--------------------------------------------------------------------------
        */

        $changes = [];

        foreach (
            $validated as $field => $newValue
        ) {

            $oldValue =
                $resident->{$field};

            if (
                (string) $oldValue
                !==
                (string) $newValue
            ) {

                $fieldName = match ($field) {

                    'name' =>
                        'Full Name',

                    'email' =>
                        'Email Address',

                    'mobile_number' =>
                        'Mobile Number',

                    'brgy_id' =>
                        'Barangay',

                    'zone' =>
                        'Zone',

                    'address' =>
                        'Complete Address',

                    'status' =>
                        'Account Status',

                    default =>
                        ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $field
                            )
                        ),

                };

                /*
                |--------------------------------------------------------------------------
                | Barangay ID → Barangay Name
                |--------------------------------------------------------------------------
                */

                if ($field === 'brgy_id') {

                    $oldBarangay =
                        Barangay::find(
                            $oldValue
                        );

                    $newBarangay =
                        Barangay::find(
                            $newValue
                        );

                    $oldDisplay =
                        $oldBarangay?->name
                        ?? 'None';

                    $newDisplay =
                        $newBarangay?->name
                        ?? 'None';

                } else {

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
        | Update Resident
        |--------------------------------------------------------------------------
        */

        $resident->update(
            $validated
        );

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        if (!empty($changes)) {

            AuditLogger::log(

                'RESIDENT_UPDATED',

                'Updated resident '
                . $resident->name
                . ' ('
                . $resident->email
                . '). '
                . 'Changes: '
                . implode(
                    '; ',
                    $changes
                )

            );
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()

            ->route(
                'admin.residents.show',
                $resident
            )

            ->with(
                'success',
                'Resident information updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Approve Resident
    |--------------------------------------------------------------------------
    */

    public function approve(User $resident)
    {
        abort_unless(
            $resident->role === 'resident',
            404
        );

        $resident->update([

            'status' =>
                'approved',

            'verified_at' =>
                now(),

            'verified_by' =>
                auth()->id(),

            'rejection_reason' =>
                null,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        AuditLogger::log(

            'RESIDENT_APPROVED',

            'Approved resident account for '
            . $resident->name
            . ' ('
            . $resident->email
            . ').'

        );

        return redirect()

            ->route(
                'admin.residents.show',
                $resident
            )

            ->with(
                'success',
                'Resident account approved successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Reject Resident
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        User $resident
    ) {
        abort_unless(
            $resident->role === 'resident',
            404
        );

        $validated = $request->validate([

            'rejection_reason' => [
                'required',
                'string',
                'max:500',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Resident
        |--------------------------------------------------------------------------
        */

        $resident->update([

            'status' =>
                'rejected',

            'verified_at' =>
                null,

            'verified_by' =>
                auth()->id(),

            'rejection_reason' =>
                $validated['rejection_reason'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        AuditLogger::log(

            'RESIDENT_REJECTED',

            'Rejected resident account for '
            . $resident->name
            . ' ('
            . $resident->email
            . '). Reason: '
            . $validated['rejection_reason']

        );

        return redirect()

            ->route(
                'admin.residents.show',
                $resident
            )

            ->with(
                'success',
                'Resident account rejected successfully.'
            );
    }
}