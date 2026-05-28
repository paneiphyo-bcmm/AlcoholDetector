// app/Models/User.php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'user_name',
        'email',
        'password',
        'location_id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const ROLE_ADMIN = 'admin';
    public const ROLE_ORGANIZATION = 'organization';
    public const ROLE_PRIVATE = 'private';

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isOrganization(): bool
    {
        return $this->role === self::ROLE_ORGANIZATION;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function measurementRecords(): HasMany
    {
        return $this->hasMany(MeasurementRecord::class, 'user_id', 'user_id');
    }

    public function operationLogs(): HasMany
    {
        return $this->hasMany(OperationLog::class, 'user_id', 'user_id');
    }
}