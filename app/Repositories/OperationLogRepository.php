// app/Repositories/OperationLogRepository.php
<?php

namespace App\Repositories;

use App\Models\OperationLog;

class OperationLogRepository
{
    public function create(string $userId, string $detail, ?string $ipAddress): OperationLog
    {
        return OperationLog::create([
            'user_id'          => $userId,
            'operation_detail' => $detail,
            'operation_time'   => now(),
            'ip_address'       => $ipAddress,
        ]);
    }
}