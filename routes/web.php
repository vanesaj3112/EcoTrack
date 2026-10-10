<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BarangayController;
use App\Http\Controllers\Admin\CollectionScheduleController;
use App\Http\Controllers\Admin\CollectionRequestController as AdminCollectionRequestController;
use App\Http\Controllers\Admin\GarbageCollectorController;
use App\Http\Controllers\Admin\ResidentConcernController as AdminResidentConcernController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SmsNotificationController;

use App\Http\Controllers\CollectorCollectionController;
use App\Http\Controllers\CollectorDashboardController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentCollectionRequestController;
use App\Http\Controllers\ResidentConcernController;
use App\Http\Controllers\ResidentPortalController;
use App\Http\Controllers\Resident\DashboardController as ResidentDashboardController;

use Illuminate\Support\Facades\Route;


// ============================================================
// WELCOME
// ============================================================

Route::get('/', function () {
    return view('welcome');
});


// ============================================================
// DEFAULT DASHBOARD
// ============================================================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// ============================================================
// AUTHENTICATED ROUTES
// ============================================================

Route::middleware('auth')->group(function () {

    // ========================================================
    // ADMIN - BARANGAYS
    // ========================================================

    Route::get(
        '/admin/barangays',
        [BarangayController::class, 'index']
    )->name('admin.barangays.index');

    Route::post(
        '/admin/barangays',
        [BarangayController::class, 'store']
    )->name('admin.barangays.store');

    Route::put(
        '/admin/barangays/{barangay}',
        [BarangayController::class, 'update']
    )->name('admin.barangays.update');

    Route::delete(
        '/admin/barangays/{barangay}',
        [BarangayController::class, 'destroy']
    )->name('admin.barangays.destroy');


    // ========================================================
    // ADMIN - RESIDENTS
    // ========================================================

    Route::get(
        '/admin/residents',
        [ResidentController::class, 'index']
    )->name('admin.residents.index');

    Route::get(
        '/admin/residents/create',
        [ResidentController::class, 'create']
    )->name('admin.residents.create');

    Route::post(
        '/admin/residents',
        [ResidentController::class, 'store']
    )->name('admin.residents.store');

    Route::get(
        '/admin/residents/{resident}',
        [ResidentController::class, 'show']
    )->name('admin.residents.show');

    Route::get(
        '/admin/residents/{resident}/document/{type}',
        [ResidentController::class, 'document']
    )->name('admin.residents.document');

    Route::get(
        '/admin/residents/{resident}/edit',
        [ResidentController::class, 'edit']
    )->name('admin.residents.edit');

    Route::put(
        '/admin/residents/{resident}',
        [ResidentController::class, 'update']
    )->name('admin.residents.update');

    Route::post(
        '/admin/residents/{resident}/approve',
        [ResidentController::class, 'approve']
    )->name('admin.residents.approve');

    Route::post(
        '/admin/residents/{resident}/reject',
        [ResidentController::class, 'reject']
    )->name('admin.residents.reject');


    // ========================================================
    // ADMIN - COLLECTION SCHEDULES
    // ========================================================

    Route::get(
        '/admin/collection-schedules',
        [CollectionScheduleController::class, 'index']
    )->name('admin.collection-schedules.index');

    Route::get(
        '/admin/collection-schedules/{barangay}',
        [CollectionScheduleController::class, 'show']
    )->name('admin.collection-schedules.show');

    Route::post(
        '/admin/collection-schedules/{barangay}',
        [CollectionScheduleController::class, 'store']
    )->name('admin.collection-schedules.store');

    Route::put(
        '/admin/collection-schedules/{barangay}/{collectionSchedule}',
        [CollectionScheduleController::class, 'update']
    )->name('admin.collection-schedules.update');

    Route::delete(
        '/admin/collection-schedules/{barangay}/{collectionSchedule}',
        [CollectionScheduleController::class, 'destroy']
    )->name('admin.collection-schedules.destroy');


    // ========================================================
    // ADMIN - COLLECTION REQUESTS
    // ========================================================

    Route::get(
        '/admin/collection-requests',
        [AdminCollectionRequestController::class, 'index']
    )->middleware(['verified', 'role:lgu_admin'])
     ->name('admin.collection-requests.index');

    Route::patch(
        '/admin/collection-requests/{collectionRequest}/review',
        [AdminCollectionRequestController::class, 'review']
    )->middleware(['verified', 'role:lgu_admin'])
     ->name('admin.collection-requests.review');


    // ========================================================
    // ADMIN - ANNOUNCEMENTS
    // ========================================================

    Route::get(
        '/admin/announcements',
        [AnnouncementController::class, 'index']
    )->name('admin.announcements.index');

    Route::post(
        '/admin/announcements',
        [AnnouncementController::class, 'store']
    )->name('admin.announcements.store');

    Route::get(
        '/admin/announcements/{announcement}',
        [AnnouncementController::class, 'show']
    )->name('admin.announcements.show');

    Route::get(
        '/admin/announcements/{announcement}/edit',
        [AnnouncementController::class, 'edit']
    )->name('admin.announcements.edit');

    Route::put(
        '/admin/announcements/{announcement}',
        [AnnouncementController::class, 'update']
    )->name('admin.announcements.update');

    Route::delete(
        '/admin/announcements/{announcement}',
        [AnnouncementController::class, 'destroy']
    )->name('admin.announcements.destroy');


    // ========================================================
    // ADMIN - SMS NOTIFICATIONS
    // ========================================================

    Route::get(
        '/admin/sms',
        [SmsNotificationController::class, 'index']
    )->name('admin.sms.index');


    // ========================================================
    // ADMIN - AUDIT LOGS
    // ========================================================

    Route::get(
        '/admin/audit-logs',
        [AuditLogController::class, 'index']
    )->name('admin.audit-logs.index');


    // ========================================================
    // ADMIN - SITE SETTINGS
    // ========================================================

    Route::get(
        '/admin/settings',
        [SiteSettingController::class, 'edit']
    )->name('admin.settings.edit');

    Route::put(
        '/admin/settings',
        [SiteSettingController::class, 'update']
    )->name('admin.settings.update');


    // ========================================================
    // ADMIN - RESIDENT CONCERNS
    // ========================================================

    Route::get(
        '/admin/resident-concerns',
        [AdminResidentConcernController::class, 'index']
    )->name('admin.resident-concerns.index');

    Route::get(
        '/admin/resident-concerns/{residentConcern}',
        [AdminResidentConcernController::class, 'show']
    )->name('admin.resident-concerns.show');

    Route::put(
        '/admin/resident-concerns/{residentConcern}',
        [AdminResidentConcernController::class, 'update']
    )->name('admin.resident-concerns.update');

    Route::delete(
        '/admin/resident-concerns/{residentConcern}',
        [AdminResidentConcernController::class, 'destroy']
    )->name('admin.resident-concerns.destroy');


    // ========================================================
    // RESIDENT - DASHBOARD
    // ========================================================

    Route::get(
        '/resident/dashboard',
        [ResidentDashboardController::class, 'index']
    )->name('resident.dashboard');


    // ========================================================
    // RESIDENT - COLLECTION SCHEDULE
    // ========================================================

    Route::get(
        '/resident/schedule',
        [ResidentPortalController::class, 'schedule']
    )->name('resident.schedule');


    // ========================================================
    // RESIDENT - COLLECTION REQUESTS
    // ========================================================

    Route::post(
        '/resident/collection-requests',
        [ResidentCollectionRequestController::class, 'store']
    )->middleware('verified')
     ->name('resident.collection-requests.store');

    Route::patch(
        '/resident/collection-requests/{collectionRequest}/cancel',
        [ResidentCollectionRequestController::class, 'cancel']
    )->middleware('verified')
     ->name('resident.collection-requests.cancel');


    // ========================================================
    // RESIDENT - ANNOUNCEMENTS
    // ========================================================

    Route::get(
        '/resident/announcements',
        [ResidentPortalController::class, 'announcements']
    )->name('resident.announcements');


    // ========================================================
    // RESIDENT - CONCERNS
    // ========================================================

    Route::get(
        '/resident/concerns',
        [ResidentConcernController::class, 'index']
    )->name('resident.concerns.index');

    Route::get(
        '/resident/concerns/create',
        [ResidentConcernController::class, 'create']
    )->name('resident.concerns.create');

    Route::post(
        '/resident/concerns',
        [ResidentConcernController::class, 'store']
    )->name('resident.concerns.store');

    Route::get(
        '/resident/concerns/{concern}',
        [ResidentConcernController::class, 'show']
    )->name('resident.concerns.show');


    // ========================================================
    // RESIDENT - PROFILE
    // ========================================================

    Route::get(
        '/resident/profile',
        [ResidentPortalController::class, 'profile']
    )->name('resident.profile');

    Route::patch(
        '/resident/profile',
        [ResidentPortalController::class, 'updateProfile']
    )->name('resident.profile.update');


    // ========================================================
    // GENERIC BREEZE PROFILE
    // ========================================================

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');


    // ========================================================
    // PENDING VERIFICATION
    // ========================================================

    Route::get(
        '/pending-verification',
        function () {
            return view('auth.pending-verification');
        }
    )->name('pending.verification');


    // ========================================================
    // GARBAGE COLLECTOR
    // ========================================================

    Route::middleware([
        'verified',
        'role:garbage_collector'
    ])->group(function () {

        Route::get(
            '/collector/dashboard',
            [CollectorDashboardController::class, 'index']
        )->name('collector.dashboard');

        Route::post(
            '/collector/collection/{collectionSchedule}/start',
            [CollectorCollectionController::class, 'start']
        )->name('collector.collection.start');

        Route::post(
            '/collector/collection/{collectionSchedule}/complete',
            [CollectorCollectionController::class, 'complete']
        )->name('collector.collection.complete');

        Route::post(
            '/collector/collection/{collectionSchedule}/cancel',
            [CollectorCollectionController::class, 'cancel']
        )->name('collector.collection.cancel');


        
        Route::patch(
            '/collector/collection-requests/{collectionRequest}/accept',
            [\App\Http\Controllers\CollectorCollectionRequestController::class, 'accept']
        )->name('collector.collection-requests.accept');

        Route::patch(
            '/collector/collection-requests/{collectionRequest}/reject',
            [\App\Http\Controllers\CollectorCollectionRequestController::class, 'reject']
        )->name('collector.collection-requests.reject');

    });


    // ========================================================
    // ADMIN - GARBAGE COLLECTOR ACCOUNTS
    // ========================================================

    Route::middleware([
        'verified',
        'role:lgu_admin'
    ])->group(function () {

        Route::get(
            '/admin/garbage-collectors',
            [GarbageCollectorController::class, 'index']
        )->name('admin.garbage-collectors.index');

        Route::get(
            '/admin/garbage-collectors/create',
            [GarbageCollectorController::class, 'create']
        )->name('admin.garbage-collectors.create');

        Route::post(
            '/admin/garbage-collectors',
            [GarbageCollectorController::class, 'store']
        )->name('admin.garbage-collectors.store');

        Route::get(
            '/admin/garbage-collectors/{collector}/edit',
            [GarbageCollectorController::class, 'edit']
        )->name('admin.garbage-collectors.edit');

        Route::put(
            '/admin/garbage-collectors/{collector}',
            [GarbageCollectorController::class, 'update']
        )->name('admin.garbage-collectors.update');

        Route::delete(
            '/admin/garbage-collectors/{collector}',
            [GarbageCollectorController::class, 'destroy']
        )->name('admin.garbage-collectors.destroy');
    });

});


// ============================================================
// AUTHENTICATION ROUTES
// ============================================================

require __DIR__ . '/auth.php';