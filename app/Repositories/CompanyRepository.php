// app/Repositories/CompanyRepository.php
<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository
{
    public function search(?string $companyName, ?string $corporateId): Collection
    {
        $query = Company::query();

        if (!empty($companyName)) {
            $query->where('company_name', 'LIKE', '%' . $companyName . '%');
        }

        if (!empty($corporateId)) {
            $query->orWhere('corporate_id', $corporateId);
        }

        return $query->get();
    }

    public function findById(string $companyId): ?Company
    {
        return Company::find($companyId);
    }

    public function getAll(): Collection
    {
        return Company::all();
    }
}