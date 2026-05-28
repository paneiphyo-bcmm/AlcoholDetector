// app/Services/DeviceService.php
<?php

namespace App\Services;

use App\Models\Device;
use App\Models\User;
use App\Repositories\DeviceRepository;
use App\Repositories\MeasurementRecordRepository;
use App\Repositories\OperationLogRepository;
use Illuminate\Support\Facades\DB;

class DeviceService
{
    public function __construct(
        private readonly DeviceRepository $deviceRepository,
        private readonly MeasurementRecordRepository $measurementRecordRepository,
        private readonly OperationLogRepository $operationLogRepository
    ) {}

    public function store(array $data, User $operator): Device
    {
        $device = $this->deviceRepository->create($data);

        $this->operationLogRepository->create(
            $operator->user_id,
            "デバイス登録: {$device->device_id}",
            request()->ip()
        );

        return $device;
    }

    public function update(string $deviceId, array $data, User $operator): bool
    {
        return DB::transaction(function () use ($deviceId, $data, $operator) {
            $device = $this->deviceRepository->findById($deviceId);

            $locationChanged = $device && isset($data['location_id'])
                && $device->location_id !== $data['location_id'];

            $result = $this->deviceRepository->update($deviceId, $data);

            // FR-005: 拠点ID変更時に測定履歴の拠点IDを同期
            if ($locationChanged) {
                $this->measurementRecordRepository->updateLocationByDeviceId(
                    $deviceId,
                    $data['location_id']
                );
            }

            $this->operationLogRepository->create(
                $operator->user_id,
                "デバイス更新: {$deviceId}",
                request()->ip()
            );

            return $result;
        });
    }
}