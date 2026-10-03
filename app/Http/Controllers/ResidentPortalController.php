<?php

namespace App\Http\Controllers;

use App\Models\CollectionSchedule;
use Illuminate\View\View;

class ResidentPortalController extends Controller
{
    public function schedule(): View
    {
        $resident = auth()->user();

        $schedules = CollectionSchedule::with('barangay')
            ->where('brgy_id', $resident->brgy_id)
            ->where('zone', $resident->zone)
            ->where('status', 'scheduled')
            ->whereDate('collection_date', '>=', today())
            ->orderBy('collection_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('resident.schedule', compact('schedules'));
    }

    public function announcements(): View
    {
        $resident = auth()->user();

        $announcements = \App\Models\Announcement::with('barangay')
            ->where(function ($query) use ($resident) {

                // All residents
                $query->where('audience', 'all');

                // Resident's barangay
                if ($resident->brgy_id) {
                    $query->orWhere(function ($q) use ($resident) {
                        $q->where('audience', 'barangay')
                            ->where('brgy_id', $resident->brgy_id);
                    });
                }

                // Resident's barangay + zone
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

        return view(
            'resident.announcements',
            compact('announcements')
        );
    }

    public function profile(): View
    {
        return view('resident.profile');
    }
}