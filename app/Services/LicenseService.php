// app/Services/LicenseService.php
<?php

namespace App\Services;

use App\Models\License;
use App\Models\User;
use App\Repositories\LicenseRepository;
use App\Repositories\OperationLogRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class LicenseService
{
    public function __construct(
        private readonly LicenseRepository $licenseRepository,
        private readonly OperationLogRepository $operationLogRepository
    ) {}

    public function getLicenses(bool $exceededOnly = false): Collection
    {
        return $this->licenseRepository->getAll($exceededOnly);
    }

    public function store(array $data, User $operator): License
    {
        $data['license_id'] = $this->generateLicenseId();

        $license = $this->licenseRepository->create($data);

        $this->operationLogRepository->create(
            $operator->user_id,
            "ライセンス登録: {$license->license_id}",
            request()->ip()
        );

        return $license;
    }

    public function updateContractCount(string $licenseId, int $contractCount, User $operator): bool
    {
        // FR-007: ライセンス登録時契約数更新
        $result = $this->licenseRepository->updateContractCount($licenseId, $contractCount);

        $this->operationLogRepository->create(
            $operator->user_id,
            "ライセンス契約数更新: {$licenseId} -> {$contractCount}",
            request()->ip()
        );

        return $result;
    }

    private function generateLicenseId(): string
    {
        return strtoupper(Str::random(20));
    }
}