// app/Http/Controllers/Api/LocationController.php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $locations = $this->locationService->getLocationsForUser($request->user());

        return response()->json(['locations' => $locations]);
    }

    public function store(StoreLocationRequest $request): JsonResponse
    {
        $location = $this->locationService->store(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message'  => '拠点を登録しました。',
            'location' => $location,
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateLocationRequest $request, string $locationId): JsonResponse
    {
        $this->locationService->update(
            $locationId,
            $request->validated(),
            $request->user()
        );

        return response()->json(['message' => '拠点情報を更新しました。']);
    }
}