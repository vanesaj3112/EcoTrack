<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionSchedule extends Model
{
    protected $fillable = [
        'brgy_id',
        'zone',
        'day_of_week',
        'collection_date',
        'start_time',
        'end_time',
        'collector_id',
        'status',
        'started_at',
        'completed_at',
        'created_by',
    ];

    protected $casts = [
        'collection_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function barangay()
    {
        return $this->belongsTo(
            Barangay::class,
            'brgy_id'
        );
    }

    public function collector()
    {
        return $this->belongsTo(
            User::class,
            'collector_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

   public function instances()
{
    return $this->hasMany(
        CollectionInstance::class,
        'collection_schedule_id'
    );
}

}
