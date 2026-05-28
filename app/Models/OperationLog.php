// app/Models/OperationLog.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'operation_detail',
        'operation_time',
        'ip_address',
    ];

    protected $casts = [
        'operation_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}