// app/Services/MeasurementRecordService.php
<?php

namespace App\Services;

use App\Models\MeasurementRecord;
use App\Models\User;
use App\Repositories\LicenseRepository;
use App\Repositories\MeasurementRecordRepository;
use App\Repositories\OperationLogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MeasurementRecordService
{
    public function __construct(
        private readonly MeasurementRecordRepository $measurementRecordRepository,
        private readonly LicenseRepository $licenseRepository,
        private readonly OperationLogRepository $operationLogRepository
    ) {}

    public function search(array $filters): LengthAwarePaginator
    {
        return $this->measurementRecordRepository->search($filters);
    }

    public function store(array $data, User $operator): MeasurementRecord
    {
        return DB::transaction(function () use ($data, $operator) {
            $record = $this->measurementRecordRepository->create($data);

            // FR-008: 測定履歴保存時に利用者数をインクリメント
            if (!empty($data['user_id'])) {
                $user = User::find($data['user_id']);
                if ($user) {
                    $this->licenseRepository->incrementUsageCount($user->company_id);
                }
            }

            $this->operationLogRepository->create(
                $operator->user_id,
                "測定履歴登録: {$record->record_id}",
                request()->ip()
            );

            return $record;
        });
    }
}