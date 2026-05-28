// app/Repositories/MeasurementRecordRepository.php
<?php

namespace App\Repositories;

use App\Models\MeasurementRecord;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MeasurementRecordRepository
{
    public function search(array $filters): LengthAwarePaginator
    {
        $query = MeasurementRecord::with(['user', 'location', 'device']);

        if (!empty($filters['location_id'])) {
            $query->where('measurement_records.location_id', $filters['location_id']);
        }

        if (!empty($filters['user_names'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where(function ($inner) use ($filters) {
                    foreach ($filters['user_names'] as $name) {
                        $inner->orWhere('user_name', 'LIKE', '%' . $name . '%');
                    }
                });
            });
        }

        if (!empty($filters['company_name_or_id'])) {
            $keyword = $filters['company_name_or_id'];
            $query->whereHas('user.company', function ($q) use ($keyword) {
                $q->where('company_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('corporate_id', $keyword);
            });
        }

        return $query->orderBy('measurement_time', 'desc')->paginate(50);
    }

    public function searchForExport(array $filters): Collection
    {
        $query = MeasurementRecord::with(['user', 'location', 'device']);

        if (!empty($filters['location_id'])) {
            $query->where('measurement_records.location_id', $filters['location_id']);
        }

        if (!empty($filters['user_names'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where(function ($inner) use ($filters) {
                    foreach ($filters['user_names'] as $name) {
                        $inner->orWhere('user_name', 'LIKE', '%' . $name . '%');
                    }
                });
            });
        }

        if (!empty($filters['company_name_or_id'])) {
            $keyword = $filters['company_name_or_id'];
            $query->whereHas('user.company', function ($q) use ($keyword) {
                $q->where('company_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('corporate_id', $keyword);
            });
        }

        return $query->orderBy('measurement_time', 'desc')->get();
    }

    public function create(array $data): MeasurementRecord
    {
        return MeasurementRecord::create($data);
    }

    public function updateLocationByDeviceId(string $deviceId, string $locationId): int
    {
        return MeasurementRecord::where('device_id', $deviceId)
            ->update(['location_id' => $locationId]);
    }
}