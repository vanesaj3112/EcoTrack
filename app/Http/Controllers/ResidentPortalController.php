<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CollectionRequest;
use App\Models\CollectionSchedule;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResidentPortalController extends Controller
{
    /**
     * Display the resident's regular collection schedules
     * and additional collection request form.
     */
    public function schedule(): View
    {
        $resident = auth()->user();

        // Regular collection schedules for the resident's area.
        $schedules = CollectionSchedule::with([
            'barangay',
            'collector',
        ])
            ->where('brgy_id', $resident->brgy_id)
            ->where('zone', $resident->zone)
            ->whereIn('status', ['scheduled', 'cancelled'])
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
            ->orderBy('start_time')
            ->get();

        /*
         * Collectors available for selection.
         *
         * This currently lists all garbage collectors. The list
         * still needs date/time availability filtering to ensure
         * a collector has a schedule and no conflicting collection.
         */
        $availableCollectors = User::query()
            ->where('role', 'garbage_collector')
            ->with('barangay')
            ->orderBy('name')
            ->get();

        // The resident's additional collection request history.
        $myRequests = CollectionRequest::with([
            'barangay',
            'assignedCollector',
        ])
            ->where('resident_id', $resident->id)
            ->latest()
            ->get();

        return view('resident.schedule', compact(
            'schedules',
            'availableCollectors',
            'myRequests'
        ));
    }

    /**
     * Display announcements visible to the resident.
     */
    public function announcements(): View
    {
        $resident = auth()->user();

        $announcements = Announcement::with('barangay')
            ->where(function ($query) use ($resident) {

                // Announcements for all residents.
                $query->where('audience', 'all');

                // Announcements for the resident's barangay.
                if ($resident->brgy_id) {
                    $query->orWhere(function ($q) use ($resident) {
                        $q->where('audience', 'barangay')
                            ->where('brgy_id', $resident->brgy_id);
                    });
                }

                // Announcements for the resident's barangay and zone.
                if ($resident->brgy_id && $resident->zone) {
                    $query->orWhere(function ($q) use ($resident) {
                        $q->where('audience', 'zone')
                            ->where('brgy_id', $resident->brgy_id)
                            ->where('zone', $resident->zone);
                    });
                }
            })
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();

        // Mark visible announcements as read without duplicating
        // existing announcement read records.
        $now = now();

        $reads = $announcements->map(function ($announcement) use ($resident, $now) {
            return [
                'announcement_id' => $announcement->id,
                'resident_id' => $resident->id,
                'read_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->all();

        if (!empty($reads)) {
            DB::table('announcement_reads')->insertOrIgnore($reads);
        }

        return view(
            'resident.announcements',
            compact('announcements')
        );
    }

    /**
     * Display the resident's profile.
     */
    public function profile(): View
    {
        $resident = auth()->user();

        return view(
            'resident.profile',
            compact('resident')
        );
    }

    /**
     * Update the resident's profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $resident = auth()->user();

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
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $changes = [];

        // Name.
        if ((string) $resident->name !== (string) $validated['name']) {
            $changes[] =
                'Full Name: '
                . ($resident->name ?? 'None')
                . ' → '
                . ($validated['name'] ?? 'None');
        }

        // Email.
        if ((string) $resident->email !== (string) $validated['email']) {
            $changes[] =
                'Email Address: '
                . ($resident->email ?? 'None')
                . ' → '
                . ($validated['email'] ?? 'None');
        }

        // Mobile number.
        if (
            (string) ($resident->mobile_number ?? '')
            !== (string) ($validated['mobile_number'] ?? '')
        ) {
            $changes[] =
                'Mobile Number: '
                . ($resident->mobile_number ?? 'None')
                . ' → '
                . ($validated['mobile_number'] ?? 'None');
        }

        // Address.
        if (
            (string) ($resident->address ?? '')
            !== (string) ($validated['address'] ?? '')
        ) {
            $changes[] =
                'Address: '
                . ($resident->address ?? 'None')
                . ' → '
                . ($validated['address'] ?? 'None');
        }

        // Profile photo.
        if ($request->hasFile('profile_photo')) {
            if ($resident->profile_photo) {
                Storage::disk('public')->delete(
                    $resident->profile_photo
                );
            }

            $resident->profile_photo = $request
                ->file('profile_photo')
                ->store('profile-photos', 'public');

            $changes[] = 'Profile Photo: Updated';
        }

        // Password.
        if (!empty($validated['password'])) {
            $resident->password = Hash::make(
                $validated['password']
            );

            $changes[] = 'Password: Updated';
        }

        // Update basic information.
        $resident->name = $validated['name'];
        $resident->email = $validated['email'];
        $resident->mobile_number = $validated['mobile_number'] ?? null;
        $resident->address = $validated['address'] ?? null;

        $resident->save();

        // Audit log.
        if (!empty($changes)) {
            AuditLogger::log(
                'RESIDENT_PROFILE_UPDATED',
                'Resident updated own profile ('
                . $resident->email
                . '). Changes: '
                . implode('; ', $changes)
            );
        }

        return redirect()
            ->route('resident.profile')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}