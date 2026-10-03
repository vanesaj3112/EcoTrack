<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\SmsNotification;
use App\Models\User;
use Illuminate\View\View;

class SmsNotificationController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::query()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        $smsNotifications = SmsNotification::with([
            'announcement',
            'resident',
            'creator',
        ])
            ->orderByDesc('created_at')
            ->get();

        $residentCount = User::where('role', 'resident')
            ->whereNotNull('mobile_number')
            ->count();

        return view('admin.sms.index', compact(
            'announcements',
            'smsNotifications',
            'residentCount'
        ));
    }
}