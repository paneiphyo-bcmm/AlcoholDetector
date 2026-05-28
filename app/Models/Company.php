// app/Models/Company.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $primaryKey = 'company_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'company_name',
        'corporate_id',
    ];

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class, 'company_id', 'company_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'company_id', 'company_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'company_id', 'company_id');
    }
}