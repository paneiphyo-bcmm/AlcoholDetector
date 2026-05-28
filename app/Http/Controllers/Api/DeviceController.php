// app/Http/Controllers/Api/DeviceController.php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Repositories\DeviceRepository;
use App\Services\DeviceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeviceController extends Controller
{
    public function __construct(
        private readonly DeviceService $deviceService,
        private readonly DeviceRepository $deviceRepository
    ) {}

    public function index(): JsonResponse
    {
        $devices = $this->deviceRepository->getAll();

        return response()->json(['devices' => $devices]);
    }

    public function store(StoreDeviceRequest $request): JsonResponse
    {
        $device = $this->deviceService->store(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message' => 'デバイスを登録しました。',
            'device'  => $device,
        ], Response::HTTP_CREATED);
    }

    // FR-005: デバイス編集時拠点ID同期
    public function update(UpdateDeviceRequest $request, string $deviceId): JsonResponse
    {
        $this->deviceService->update(
            $deviceId,
            $request->validated(),
            $request->user()
        );

        return response()->json(['message' => 'デバイス情報を更新しました。']);
    }
}