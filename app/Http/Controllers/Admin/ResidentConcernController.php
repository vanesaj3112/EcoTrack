<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\ResidentConcern;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResidentConcernController extends Controller
{
    public function index(): View
    {
        AdminNotification::where('admin_id', auth()->id())
            ->where('type', 'new_resident_report')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $concerns = ResidentConcern::with([
            'resident',
            'handler',
        ])
            ->latest()
            ->get();

        return view(
            'admin.resident-concerns.index',
            compact('concerns')
        );
    }

    public function show(ResidentConcern $residentConcern): View
    {
        $residentConcern->load([
            'resident',
            'handler',
        ]);

        return view(
            'admin.resident-concerns.show',
            compact('residentConcern')
        );
    }

    public function update(
        Request $request,
        ResidentConcern $residentConcern
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,in_review,resolved,rejected',
            ],
            'admin_response' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $oldStatus = $residentConcern->status;
        $oldResponse = $residentConcern->admin_response;

        $newStatus = $validated['status'];
        $newResponse = $validated['admin_response'] ?? null;

        $hasResidentUpdate =
            $oldStatus !== $newStatus
            || (string) ($oldResponse ?? '')
                !== (string) ($newResponse ?? '');

        $residentConcern->status = $newStatus;
        $residentConcern->admin_response = $newResponse;
        $residentConcern->handled_by = auth()->id();

        if ($newStatus === 'resolved') {
            $residentConcern->resolved_at =
                $residentConcern->resolved_at ?? now();
        } else {
            $residentConcern->resolved_at = null;
        }

        if ($hasResidentUpdate) {
            $residentConcern->resident_update_at = now();
            $residentConcern->resident_update_read_at = null;
        }

        $residentConcern->save();

        $changes = [];

        if ($oldStatus !== $residentConcern->status) {
            $changes[] = 'Status: '
                . $oldStatus
                . ' → '
                . $residentConcern->status;
        }

        if (
            (string) ($oldResponse ?? '')
            !== (string) ($residentConcern->admin_response ?? '')
        ) {
            $changes[] = 'Admin Response: Updated';
        }

        if (!empty($changes)) {
            AuditLogger::log(
                'CONCERN_UPDATED',
                'Updated resident concern #'
                . $residentConcern->id
                . '. '
                . implode('; ', $changes)
            );
        }

        return redirect()
            ->route('admin.resident-concerns.show', $residentConcern)
            ->with(
                'success',
                'Resident concern updated successfully.'
            );
    }

    public function destroy(
        ResidentConcern $residentConcern
    ): RedirectResponse {
        $concernId = $residentConcern->id;
        $subject = $residentConcern->subject;

        if ($residentConcern->photo_path) {
            Storage::disk('public')->delete(
                $residentConcern->photo_path
            );
        }

        $residentConcern->delete();

        AuditLogger::log(
            'CONCERN_DELETED',
            'Deleted resident concern #'
            . $concernId
            . ': '
            . $subject
            . '.'
        );

        return redirect()
            ->route('admin.resident-concerns.index')
            ->with(
                'success',
                'Resident concern deleted successfully.'
            );
    }
}
