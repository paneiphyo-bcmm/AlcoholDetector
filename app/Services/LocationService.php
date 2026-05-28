// app/Services/LocationService.php
<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\LocationRepository;
use App\Repositories\OperationLogRepository;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly OperationLogRepository $operationLogRepository
    ) {}

    public function getLocationsForUser(User $user): Collection
    {
        if ($user->isAdmin()) {
            return $this->locationRepository->getAllForAdmin();
        }

        return $this->locationRepository->getByUserId($user->user_id);
    }

    public function store(array $data, User $operator): \App\Models\Location
    {
        $location = $this->locationRepository->create($data);

        $this->operationLogRepository->create(
            $operator->user_id,
            "拠点登録: {$location->location_id}",
            request()->ip()
        );

        return $location;
    }

    public function update(string $locationId, array $data, User $operator): bool
    {
        $result = $this->locationRepository->update($locationId, $data);

        $this->operationLogRepository->create(
            $operator->user_id,
            "拠点更新: {$locationId}",
            request()->ip()
        );

        return $result;
    }
}