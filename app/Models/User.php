<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'password',
        'role',
        'brgy_id',
        'zone',
        'address',
        'status',
        'verification_document',
        'residency_document',
        'profile_photo',
        'verified_at',
        'verified_by',
        'rejection_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::created(function (User $user) {

            /*
             * Only create an admin notification
             * when a newly created account is a resident.
             */
            if ($user->role !== 'resident') {
                return;
            }

            /*
             * Get all LGU administrators.
             */
            $admins = User::where(
                'role',
                'lgu_admin'
            )->get();

            /*
             * Create an unread notification
             * for every LGU administrator.
             */
            foreach ($admins as $admin) {

                AdminNotification::create([
                    'admin_id' => $admin->id,

                    'type' => 'new_resident',

                    'reference_id' => $user->id,

                    'title' => 'New Resident Registration',

                    'message' => $user->name
                        . ' has registered as a new resident.',

                    'is_read' => false,
                ]);

            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(
            Barangay::class,
            'brgy_id'
        );
    }

    public function adminNotifications()
    {
        return $this->hasMany(
            AdminNotification::class,
            'admin_id'
        );
    }
}