<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionRequest extends Model
{
    protected $fillable = [
        'resident_id',
        'brgy_id',
        'zone',
        'requested_date',
        'preferred_start_time',
        'preferred_end_time',
        'notes',
        'status',
        'assigned_collector_id',
        'reviewed_by',
        'reviewed_at',
        'admin_notes',
    ];

    protected $casts = [
        'requested_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }

    public function assignedCollector()
    {
        return $this->belongsTo(User::class, 'assigned_collector_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    
}