<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResidentConcern extends Model
{
    protected $fillable = [
        'resident_id',
        'category',
        'subject',
        'description',
        'photo_path',
        'status',
        'admin_response',
        'handled_by',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'resident_id'
        );
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'handled_by'
        );
    }
}