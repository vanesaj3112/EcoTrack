<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionInstance extends Model
{
    protected $fillable = [
        'collection_schedule_id',
        'collection_date',
        'collector_id',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'collection_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function collectionSchedule()
    {
        return $this->belongsTo(
            CollectionSchedule::class,
            'collection_schedule_id'
        );
    }

    public function collector()
    {
        return $this->belongsTo(
            User::class,
            'collector_id'
        );
    }
}
