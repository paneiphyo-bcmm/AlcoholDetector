// app/Services/CompanyService.php
<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use Illuminate\Database\Eloquent\Collection;

class CompanyService
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    ) {}

    // FR-013: 会社名部分一致・法人ID検索
    public function search(?string $companyName, ?string $corporateId): Collection
    {
        return $this->companyRepository->search($companyName, $corporateId);
    }
}