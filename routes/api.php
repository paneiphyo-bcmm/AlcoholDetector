// routes/api.php
<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CsvExportController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\LicenseController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MeasurementRecordController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // 拠点 (FR-004)
    Route::get('/locations', [LocationController::class, 'index']);
    Route::post('/locations', [LocationController::class, 'store'])->middleware('admin');
    Route::post('/locations/{location_id}', [LocationController::class, 'update'])->middleware('location.access');

    // デバイス (FR-005)
    Route::get('/devices', [DeviceController::class, 'index']);
    Route::post('/devices', [DeviceController::class, 'store'])->middleware('admin');
    Route::post('/devices/{device_id}', [DeviceController::class, 'update']);

    // 測定履歴 (FR-008, FR-011, FR-012)
    Route::get('/measurement_records', [MeasurementRecordController::class, 'index']);
    Route::post('/measurement_records', [MeasurementRecordController::class, 'store']);

    // ライセンス (FR-006, FR-007)
    Route::get('/licenses', [LicenseController::class, 'index']);
    Route::post('/licenses', [LicenseController::class, 'store'])->middleware('admin');

    // 組織管理 (FR-013)
    Route::get('/companies/search', [CompanyController::class, 'search']);

    // CSV出力 (FR-009, FR-010)
    Route::get('/export/csv', [CsvExportController::class, 'export']);
});