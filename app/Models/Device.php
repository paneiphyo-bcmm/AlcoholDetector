// app/Models/Device.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $primaryKey = 'device_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'device_id',
        'location_id',
        'device_name',
        'serial_number',
        'installation_date',
    ];

    protected $casts = [
        'installation_date' => 'date',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function measurementRecords(): HasMany
    {
        return $this->hasMany(MeasurementRecord::class, 'device_id', 'device_id');
    }
}