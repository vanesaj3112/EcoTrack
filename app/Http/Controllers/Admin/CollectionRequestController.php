<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CollectionRequestController extends Controller
{
    public function index(): View
    {
        $requests = CollectionRequest::with([
            'resident',
            'barangay',
            'assignedCollector',
        ])
            ->orderByRaw("
                CASE status
                    WHEN 'pending' THEN 1
                    WHEN 'approved' THEN 2
                    WHEN 'rejected' THEN 3
                    WHEN 'cancelled' THEN 4
                    ELSE 5
                END
            ")
            ->orderBy('requested_date')
            ->orderBy('preferred_start_time')
            ->get();

        $collectors = User::where('role', 'garbage_collector')
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        return view(
            'admin.collection-requests.index',
            compact('requests', 'collectors')
        );
    }

    public function review(
        Request $request,
        CollectionRequest $collectionRequest
    ): RedirectResponse {
        $validated = $request->validate([
            'decision' => [
                'required',
                'in:approved,rejected',
            ],
            'assigned_collector_id' => [
                'nullable',
                'required_if:decision,approved',
                'exists:users,id',
            ],
            'admin_notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $collectorId = $validated['assigned_collector_id'] ?? null;

        if ($validated['decision'] === 'approved') {
            $collector = User::where('id', $collectorId)
                ->where('role', 'garbage_collector')
                ->where('status', 'approved')
                ->first();

            if (!$collector) {
                return back()->withErrors([
                    'assigned_collector_id' => 'Select an approved garbage collector.',
                ]);
            }
        }

        if ($collectionRequest->status !== 'pending') {
            return back()->withErrors([
                'request' => 'This request has already been reviewed.',
            ]);
        }

        DB::transaction(function () use (
            $collectionRequest,
            $validated,
            $collectorId
        ) {
            $lockedRequest = CollectionRequest::whereKey(
                $collectionRequest->id
            )->lockForUpdate()->firstOrFail();

            if ($lockedRequest->status !== 'pending') {
                abort(409, 'This request has already been reviewed.');
            }

            $lockedRequest->update([
                'status' => $validated['decision'],
                'assigned_collector_id' =>
                    $validated['decision'] === 'approved'
                        ? $collectorId
                        : null,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'admin_notes' => $validated['admin_notes'] ?? null,
            ]);
        });

        return back()->with(
            'success',
            'Collection request ' . $validated['decision'] . ' successfully.'
        );
    }
}
