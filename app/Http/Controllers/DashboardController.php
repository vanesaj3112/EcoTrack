<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CollectionSchedule;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalResidents = User::where('role', 'resident')->count();

        $pendingVerification = User::where('role', 'resident')
            ->where('status', 'pending')
            ->count();

        $collectionSchedules = CollectionSchedule::count();

        $announcements = Announcement::count();

        return view('dashboard', compact(
            'totalResidents',
            'pendingVerification',
            'collectionSchedules',
            'announcements'
        ));
    }
}
