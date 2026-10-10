<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GarbageCollectorController extends Controller
{
    /**
     * Display all garbage collectors.
     */
    public function index()
    {
        $collectors = User::where('role', 'garbage_collector')
            ->orderBy('name')
            ->get();

        return view(
            'admin.garbage-collectors.index',
            compact('collectors')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.garbage-collectors.create');
    }

    /**
     * Store a new garbage collector account.
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

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'status' => [
                'required',
                'in:approved,pending',
            ],
        ]);

        $collector = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'password' => Hash::make($validated['password']),
            'role' => 'garbage_collector',
            'status' => $validated['status'],
        ]);

        AuditLogger::log(
            'COLLECTOR_CREATED',
            'Created garbage collector account for '
            . $collector->name
            . ' ('
            . $collector->email
            . ').'
        );

        return redirect()
            ->route('admin.garbage-collectors.index')
            ->with(
                'success',
                'Garbage collector account created successfully.'
            );
    }

    /**
     * Show edit form.
     */
    public function edit(User $collector)
    {
        abort_unless(
            $collector->role === 'garbage_collector',
            404
        );

        return view(
            'admin.garbage-collectors.edit',
            compact('collector')
        );
    }

    /**
     * Update garbage collector.
     */
    public function update(
        Request $request,
        User $collector
    ) {
        abort_unless(
            $collector->role === 'garbage_collector',
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
                'unique:users,email,' . $collector->id,
            ],

            'mobile_number' => [
                'required',
                'string',
                'max:20',
            ],

            'status' => [
                'required',
                'in:approved,pending',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $changes = [];

        foreach (
            [
                'name',
                'email',
                'mobile_number',
                'status',
            ] as $field
        ) {
            $oldValue = $collector->{$field};
            $newValue = $validated[$field];

            if ((string) $oldValue !== (string) $newValue) {
                $fieldName = match ($field) {
                    'name' => 'Full Name',
                    'email' => 'Email Address',
                    'mobile_number' => 'Mobile Number',
                    'status' => 'Account Status',
                    default => ucfirst($field),
                };

                $changes[] =
                    $fieldName
                    . ': '
                    . ($oldValue ?? 'None')
                    . ' → '
                    . ($newValue ?? 'None');
            }
        }

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] =
                Hash::make($validated['password']);

            $changes[] = 'Password: Updated';
        }

        $collector->update($updateData);

        if (!empty($changes)) {
            AuditLogger::log(
                'COLLECTOR_UPDATED',
                'Updated garbage collector '
                . $collector->name
                . ' ('
                . $collector->email
                . '). Changes: '
                . implode('; ', $changes)
            );
        }

        return redirect()
            ->route(
                'admin.garbage-collectors.index'
            )
            ->with(
                'success',
                'Garbage collector updated successfully.'
            );
    }

    /**
     * Delete garbage collector.
     */
    public function destroy(User $collector)
    {
        abort_unless(
            $collector->role === 'garbage_collector',
            404
        );

        $collectorName = $collector->name;
        $collectorEmail = $collector->email;

        $collector->delete();

        AuditLogger::log(
            'COLLECTOR_DELETED',
            'Deleted garbage collector account for '
            . $collectorName
            . ' ('
            . $collectorEmail
            . ').'
        );

        return redirect()
            ->route(
                'admin.garbage-collectors.index'
            )
            ->with(
                'success',
                'Garbage collector account deleted successfully.'
            );
    }
}