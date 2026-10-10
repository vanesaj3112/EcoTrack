<?php

namespace App\Http\Controllers;

use App\Models\ResidentConcern;
use App\Models\AuditLogger;
use App\Services\AuditLogger as AuditLoggerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResidentConcernController extends Controller
{
    public function index(): View
    {
        // Mark concern updates as read when the resident opens this page.
        ResidentConcern::where('resident_id', auth()->id())
            ->whereNotNull('resident_update_at')
            ->where(function ($query) {
                $query->whereNull('resident_update_read_at')
                    ->orWhereColumn(
                        'resident_update_at',
                        '>',
                        'resident_update_read_at'
                    );
            })
            ->update([
                'resident_update_read_at' => now(),
            ]);

        $concerns = ResidentConcern::where(
            'resident_id',
            auth()->id()
        )
            ->latest()
            ->get();

        return view(
            'resident.concerns.index',
            compact('concerns')
        );
    }

    public function create(): View
    {
        return view('resident.concerns.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => [
                'required',
                'in:Missed Garbage Collection,Garbage Not Collected,Overflowing Garbage,Illegal Dumping,Collection Schedule Problem,Collector Concern,Other',
            ],

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
                'max:5000',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request
                ->file('photo')
                ->store('resident-concerns', 'public');
        }

        $concern = ResidentConcern::create([
            'resident_id' => auth()->id(),
            'category' => $validated['category'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'photo_path' => $photoPath,
            'status' => 'pending',
        ]);

        // Notify LGU admins about the new concern.
        $admins = \App\Models\User::where(
            'role',
            'lgu_admin'
        )->get();

        foreach ($admins as $admin) {
            \App\Models\AdminNotification::create([
                'admin_id' => $admin->id,
                'type' => 'new_resident_report',
                'reference_id' => $concern->id,
                'title' => 'New Resident Report',
                'message' => auth()->user()->name
                    . ' submitted a new resident report: '
                    . $concern->subject,
                'is_read' => false,
            ]);
        }

        AuditLoggerService::log(
            'CONCERN_SUBMITTED',
            'Resident submitted a concern: '
            . $concern->subject
            . ' (Category: '
            . $concern->category
            . ').'
        );

        return redirect()
            ->route('resident.concerns.index')
            ->with(
                'success',
                'Your concern has been submitted successfully.'
            );
    }

    public function show(ResidentConcern $concern): View
    {
        abort_unless(
            $concern->resident_id === auth()->id(),
            403
        );

        // Mark this concern's update as read when opened directly.
        if ($concern->resident_update_at !== null) {
            $concern->resident_update_read_at = now();
            $concern->save();
        }

        return view(
            'resident.concerns.show',
            compact('concern')
        );
    }
}
