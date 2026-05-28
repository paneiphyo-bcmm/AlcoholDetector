// app/Http/Controllers/Api/LicenseController.php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLicenseRequest;
use App\Services\LicenseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LicenseController extends Controller
{
    public function __construct(
        private readonly LicenseService $licenseService
    ) {}

    // FR-006: ライセンス利用数チェック
    public function index(Request $request): JsonResponse
    {
        $exceededOnly = $request->boolean('exceeded_only');
        $licenses = $this->licenseService->getLicenses($exceededOnly);

        return response()->json(['licenses' => $licenses]);
    }

    // FR-007: ライセンス登録時契約数更新
    public function store(StoreLicenseRequest $request): JsonResponse
    {
        $license = $this->licenseService->store(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message' => 'ライセンスを登録しました。',
            'license' => $license,
        ], Response::HTTP_CREATED);
    }
}