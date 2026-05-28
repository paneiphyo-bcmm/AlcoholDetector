// app/Models/License.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class License extends Model
{
    protected $primaryKey = 'license_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'license_id',
        'company_id',
        'contract_count',
        'usage_count',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function isExceeded(): bool
    {
        return $this->usage_count > $this->contract_count;
    }
}