// app/Repositories/LocationRepository.php
<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationRepository
{
    public function getAllForAdmin(): Collection
    {
        return Location::with('adminUser')->get();
    }

    public function getByUserId(string $userId): Collection
    {
        return Location::where('admin_user_id', $userId)->get();
    }

    public function findById(string $locationId): ?Location
    {
        return Location::find($locationId);
    }

    public function create(array $data): Location
    {
        return Location::create($data);
    }

    public function update(string $locationId, array $data): bool
    {
        return Location::where('location_id', $locationId)->update($data);
    }
}