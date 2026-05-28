// app/Http/Controllers/Web/CompanyController.php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService
    ) {}

    // FR-013: 会社名部分一致・法人ID検索
    public function index(Request $request): View
    {
        $request->validate([
            'company_name' => ['nullable', 'string', 'max:200'],
            'corporate_id' => ['nullable', 'string', 'max:50'],
        ]);

        $companies = $this->companyService->search(
            $request->input('company_name'),
            $request->input('corporate_id')
        );

        return view('companies.index', compact('companies'));
    }
}