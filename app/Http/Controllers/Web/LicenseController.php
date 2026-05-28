// app/Http/Controllers/Web/LicenseController.php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLicenseRequest;
use App\Repositories\CompanyRepository;
use App\Services\CsvExportService;
use App\Services\LicenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LicenseController extends Controller
{
    public function __construct(
        private readonly LicenseService $licenseService,
        private readonly CompanyRepository $companyRepository,
        private readonly CsvExportService $csvExportService
    ) {}

    public function index(Request $request): View
    {
        $exceededOnly = $request->boolean('exceeded_only');
        $licenses     = $this->licenseService->getLicenses($exceededOnly);
        $companies    = $this->companyRepository->getAll();

        return view('licenses.index', compact('licenses', 'companies', 'exceededOnly'));
    }

    public function store(StoreLicenseRequest $request): RedirectResponse
    {
        $this->licenseService->store($request->validated(), $request->user());

        return redirect()->route('licenses.index')->with('success', 'ライセンスを登録しました。');
    }

    public function exportCsv(): JsonResponse
    {
        $url = $this->csvExportService->exportLicensesToS3();

        return response()->json(['url' => $url]);
    }
}