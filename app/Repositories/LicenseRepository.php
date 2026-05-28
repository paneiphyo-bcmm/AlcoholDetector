// app/Repositories/LicenseRepository.php
<?php

namespace App\Repositories;

use App\Models\License;
use Illuminate\Database\Eloquent\Collection;

class LicenseRepository
{
    public function getAll(bool $exceededOnly = false): Collection
    {
        $query = License::with('company');

        if ($exceededOnly) {
            $query->whereRaw('usage_count > contract_count');
        }

        return $query->get();
    }

    public function findByCompanyId(string $companyId): ?License
    {
        return License::where('company_id', $companyId)->first();
    }

    public function create(array $data): License
    {
        return License::create($data);
    }

    public function updateContractCount(string $licenseId, int $contractCount): bool
    {
        return License::where('license_id', $licenseId)
            ->update(['contract_count' => $contractCount]);
    }

    public function incrementUsageCount(string $companyId): int
    {
        return License::where('company_id', $companyId)
            ->increment('usage_count');
    }

    public function getAllForExport(): Collection
    {
        return License::with('company')->get();
    }
}