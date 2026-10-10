<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\ResidentConcern;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.layouts.resident', function ($view) {
            $user = auth()->user();

            $unreadAnnouncementCount = 0;
            $unreadConcernCount = 0;

            if ($user && request()->routeIs('resident.*')) {

                // Count unread announcements visible to this resident.
                $announcementsQuery = Announcement::query()
                    ->whereNotNull('published_at')
                    ->where(function ($query) use ($user) {
                        $query->where('audience', 'all');

                        if ($user->brgy_id) {
                            $query->orWhere(function ($q) use ($user) {
                                $q->where('audience', 'barangay')
                                    ->where('brgy_id', $user->brgy_id);
                            });
                        }

                        if ($user->brgy_id && $user->zone) {
                            $query->orWhere(function ($q) use ($user) {
                                $q->where('audience', 'zone')
                                    ->where('brgy_id', $user->brgy_id)
                                    ->where('zone', $user->zone);
                            });
                        }
                    });

                $unreadAnnouncementCount = $announcementsQuery
                    ->whereDoesntHave('reads', function ($query) use ($user) {
                        $query->where('resident_id', $user->id);
                    })
                    ->count();

                // Count concerns with unread admin updates.
                $unreadConcernCount = ResidentConcern::query()
                    ->where('resident_id', $user->id)
                    ->whereNotNull('resident_update_at')
                    ->where(function ($query) {
                        $query->whereNull('resident_update_read_at')
                            ->orWhereColumn(
                                'resident_update_at',
                                '>',
                                'resident_update_read_at'
                            );
                    })
                    ->count();
            }

            $view->with([
                'unreadAnnouncementCount' => $unreadAnnouncementCount,
                'unreadConcernCount' => $unreadConcernCount,
            ]);
        });
    }
}
