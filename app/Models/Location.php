// app/Models/Location.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    protected $primaryKey = 'location_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'location_id',
        'location_name',
        'admin_user_id',
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'location_id', 'location_id');
    }

    public function measurementRecords(): HasMany
    {
        return $this->hasMany(MeasurementRecord::class, 'location_id', 'location_id');
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'user_id');
    }
}