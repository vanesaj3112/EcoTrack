<?php

use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\ResidentPortalController;
use App\Http\Controllers\Admin\BarangayController;
use App\Http\Controllers\Admin\SmsNotificationController;
use App\Http\Controllers\Admin\CollectionScheduleController;
use App\Http\Middleware\AuditAdminActions;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Resident\DashboardController as ResidentDashboardController;
use Illuminate\Support\Facades\Route;


// Welcome
Route::get('/', function () {
    return view('welcome');
});


// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Admin Routes
Route::middleware('auth')->group(function () {

    // Barangays
    Route::get('/admin/barangays', [BarangayController::class, 'index'])
        ->name('admin.barangays.index');

    Route::post('/admin/barangays', [BarangayController::class, 'store'])
        ->name('admin.barangays.store');

    Route::put('/admin/barangays/{barangay}', [BarangayController::class, 'update'])
        ->name('admin.barangays.update');

    Route::delete('/admin/barangays/{barangay}', [BarangayController::class, 'destroy'])
        ->name('admin.barangays.destroy');


    // Residents
    Route::get('/admin/residents', [ResidentController::class, 'index'])
        ->name('admin.residents.index');

    Route::get('/admin/residents/create', [ResidentController::class, 'create'])
        ->name('admin.residents.create');

    Route::get('/admin/residents/{resident}', [ResidentController::class, 'show'])
        ->name('admin.residents.show');

    Route::get('/admin/residents/{resident}/document/{type}', [ResidentController::class, 'document'])
        ->name('admin.residents.document');

    Route::get('/admin/residents/{resident}/edit', [ResidentController::class, 'edit'])
        ->name('admin.residents.edit');

    Route::put('/admin/residents/{resident}', [ResidentController::class, 'update'])
        ->name('admin.residents.update');


    // Collection Schedules
    Route::get('/admin/collection-schedules', [CollectionScheduleController::class, 'index'])
        ->name('admin.collection-schedules.index');

        Route::post('/admin/collection-schedules', [CollectionScheduleController::class, 'store'])
    ->name('admin.collection-schedules.store');


    // Announcements
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])
        ->name('admin.announcements.index');

        Route::post('/admin/announcements', [AnnouncementController::class, 'store'])
    ->name('admin.announcements.store');

Route::get('/admin/announcements/{announcement}', [AnnouncementController::class, 'show'])
    ->name('admin.announcements.show');

Route::get('/admin/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])
    ->name('admin.announcements.edit');

Route::put('/admin/announcements/{announcement}', [AnnouncementController::class, 'update'])
    ->name('admin.announcements.update');

Route::delete('/admin/announcements/{announcement}', [AnnouncementController::class, 'destroy'])
    ->name('admin.announcements.destroy');


    // SMS Notifications
    Route::get('/admin/sms', [SmsNotificationController::class, 'index'])
        ->name('admin.sms.index');


    // Audit Logs
    Route::get('/admin/audit-logs', [AuditLogController::class, 'index'])
        ->name('admin.audit-logs.index');


    // Resident Dashboard
    Route::get('/resident/dashboard', [ResidentDashboardController::class, 'index'])
        ->name('resident.dashboard');


    // Resident Collection Schedule
    Route::get('/resident/schedule', [ResidentPortalController::class, 'schedule'])
        ->name('resident.schedule');


    // Resident Announcements
    Route::get('/resident/announcements', [ResidentPortalController::class, 'announcements'])
        ->name('resident.announcements');


    // Resident Profile
    Route::get('/resident/profile', [ResidentPortalController::class, 'profile'])
        ->name('resident.profile');


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

        // Site Settings
Route::get('/admin/settings', [SiteSettingController::class, 'edit'])
    ->name('admin.settings.edit');

Route::put('/admin/settings', [SiteSettingController::class, 'update'])
    ->name('admin.settings.update');


    // Pending Verification
    Route::get('/pending-verification', function () {
        return view('auth.pending-verification');
    })->name('pending.verification');

});


// Authentication Routes
require __DIR__.'/auth.php';