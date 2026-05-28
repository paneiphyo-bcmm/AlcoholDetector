// app/Repositories/DeviceRepository.php
<?php

namespace App\Repositories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;

class DeviceRepository
{
    public function getAll(): Collection
    {
        return Device::with('location')->get();
    }

    public function findById(string $deviceId): ?Device
    {
        return Device::find($deviceId);
    }

    public function create(array $data): Device
    {
        return Device::create($data);
    }

    public function update(string $deviceId, array $data): bool
    {
        return Device::where('device_id', $deviceId)->update($data);
    }
}