<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Barangay;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('barangay')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        $barangays = Barangay::orderBy('name')->get();

        return view(
            'admin.announcements.index',
            compact(
                'announcements',
                'barangays'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
            ],

            'audience' => [
                'required',
                'in:all,barangay,zone',
            ],

            'brgy_id' => [
                'nullable',
                'exists:barangays,id',
            ],

            'zone' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        if ($validated['audience'] === 'all') {
            $validated['brgy_id'] = null;
            $validated['zone'] = null;
        }

        if ($validated['audience'] === 'barangay') {
            $validated['zone'] = null;

            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.',
                    ])
                    ->withInput();
            }
        }

        if ($validated['audience'] === 'zone') {
            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.',
                    ])
                    ->withInput();
            }

            if (!$validated['zone']) {
                return back()
                    ->withErrors([
                        'zone' => 'Please enter a zone.',
                    ])
                    ->withInput();
            }
        }

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'audience' => $validated['audience'],
            'brgy_id' => $validated['brgy_id'],
            'zone' => $validated['zone'],
            'published_at' => now(),
            'created_by' => auth()->id(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit: Announcement Published
        |--------------------------------------------------------------------------
        */

        $barangay = $validated['brgy_id']
            ? Barangay::find($validated['brgy_id'])
            : null;

        $audienceDescription = match ($validated['audience']) {
            'all' => 'All Residents',
            'barangay' => 'Barangay ' . ($barangay?->name ?? 'Unknown'),
            'zone' => 'Barangay '
                . ($barangay?->name ?? 'Unknown')
                . ', Zone '
                . $validated['zone'],
            default => 'Unknown',
        };

        AuditLogger::log(
            'ANNOUNCEMENT_PUBLISHED',
            'Published announcement "'
            . $announcement->title
            . '" for '
            . $audienceDescription
            . '.'
        );

        return redirect()
            ->route('admin.announcements.index')
            ->with(
                'success',
                'Announcement published successfully.'
            );
    }

    public function show(Announcement $announcement)
    {
        $announcement->load('barangay');

        return view(
            'admin.announcements.show',
            compact('announcement')
        );
    }

    public function edit(Announcement $announcement)
    {
        $barangays = Barangay::orderBy('name')->get();

        return view(
            'admin.announcements.edit',
            compact(
                'announcement',
                'barangays'
            )
        );
    }

    public function update(
        Request $request,
        Announcement $announcement
    ) {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
            ],

            'audience' => [
                'required',
                'in:all,barangay,zone',
            ],

            'brgy_id' => [
                'nullable',
                'exists:barangays,id',
            ],

            'zone' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        if ($validated['audience'] === 'all') {
            $validated['brgy_id'] = null;
            $validated['zone'] = null;
        }

        if ($validated['audience'] === 'barangay') {
            $validated['zone'] = null;

            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.',
                    ])
                    ->withInput();
            }
        }

        if ($validated['audience'] === 'zone') {
            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.',
                    ])
                    ->withInput();
            }

            if (!$validated['zone']) {
                return back()
                    ->withErrors([
                        'zone' => 'Please enter a zone.',
                    ])
                    ->withInput();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Detect Changes Before Update
        |--------------------------------------------------------------------------
        */

        $changes = [];

        $fields = [
            'title' => 'Title',
            'message' => 'Message',
            'audience' => 'Audience',
            'brgy_id' => 'Barangay',
            'zone' => 'Zone',
        ];

        foreach ($fields as $field => $fieldName) {

            $oldValue = $announcement->{$field};
            $newValue = $validated[$field];

            if ((string) $oldValue !== (string) $newValue) {

                /*
                |--------------------------------------------------------------------------
                | Barangay ID → Barangay Name
                |--------------------------------------------------------------------------
                */

                if ($field === 'brgy_id') {

                    $oldBarangay = $oldValue
                        ? Barangay::find($oldValue)
                        : null;

                    $newBarangay = $newValue
                        ? Barangay::find($newValue)
                        : null;

                    $oldDisplay =
                        $oldBarangay?->name ?? 'None';

                    $newDisplay =
                        $newBarangay?->name ?? 'None';

                }

                /*
                |--------------------------------------------------------------------------
                | Audience
                |--------------------------------------------------------------------------
                */

                elseif ($field === 'audience') {

                    $oldDisplay = match ($oldValue) {
                        'all' => 'All Residents',
                        'barangay' => 'Barangay',
                        'zone' => 'Zone',
                        default => $oldValue ?? 'None',
                    };

                    $newDisplay = match ($newValue) {
                        'all' => 'All Residents',
                        'barangay' => 'Barangay',
                        'zone' => 'Zone',
                        default => $newValue ?? 'None',
                    };

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
        | Update Announcement
        |--------------------------------------------------------------------------
        */

        $announcement->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'audience' => $validated['audience'],
            'brgy_id' => $validated['brgy_id'],
            'zone' => $validated['zone'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit: Announcement Updated
        |--------------------------------------------------------------------------
        */

        if (!empty($changes)) {

            AuditLogger::log(
                'ANNOUNCEMENT_UPDATED',
                'Updated announcement "'
                . $announcement->title
                . '". Changes: '
                . implode('; ', $changes)
            );
        }

        return redirect()
            ->route('admin.announcements.index')
            ->with(
                'success',
                'Announcement updated successfully.'
            );
    }

    public function destroy(Announcement $announcement)
    {
        /*
        |--------------------------------------------------------------------------
        | Save Details Before Delete
        |--------------------------------------------------------------------------
        */

        $announcementTitle = $announcement->title;

        $announcement->load('barangay');

        $barangayName =
            $announcement->barangay?->name;

        $audienceDescription = match ($announcement->audience) {
            'all' => 'All Residents',

            'barangay' => 'Barangay '
                . ($barangayName ?? 'Unknown'),

            'zone' => 'Barangay '
                . ($barangayName ?? 'Unknown')
                . ', Zone '
                . ($announcement->zone ?? 'Unknown'),

            default => 'Unknown',
        };

        /*
        |--------------------------------------------------------------------------
        | Delete Announcement
        |--------------------------------------------------------------------------
        */

        $announcement->delete();

        /*
        |--------------------------------------------------------------------------
        | Audit: Announcement Deleted
        |--------------------------------------------------------------------------
        */

        AuditLogger::log(
            'ANNOUNCEMENT_DELETED',
            'Deleted announcement "'
            . $announcementTitle
            . '" for '
            . $audienceDescription
            . '.'
        );

        return redirect()
            ->route('admin.announcements.index')
            ->with(
                'success',
                'Announcement deleted successfully.'
            );
    }
}