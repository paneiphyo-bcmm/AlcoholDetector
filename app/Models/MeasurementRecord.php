// app/Models/MeasurementRecord.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasurementRecord extends Model
{
    protected $primaryKey = 'record_id';

    protected $fillable = [
        'device_id',
        'location_id',
        'user_id',
        'measurement_time',
        'alcohol_level',
    ];

    protected $casts = [
        'measurement_time' => 'datetime',
        'alcohol_level'    => 'decimal:2',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id', 'device_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}