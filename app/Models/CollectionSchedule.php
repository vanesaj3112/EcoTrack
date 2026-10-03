<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionSchedule extends Model
{
    protected $fillable = [
        'brgy_id',
        'zone',
        'collection_date',
        'start_time',
        'end_time',
        'status',
        'created_by',
    ];

    protected $casts = [
        'collection_date' => 'date',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
