// routes/web.php
<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\DeviceController;
use App\Http\Controllers\Web\LicenseController;
use App\Http\Controllers\Web\LocationController;
use App\Http\Controllers\Web\MeasurementRecordController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // 拠点管理 (FR-004)
    Route::resource('locations', LocationController::class)
        ->only(['index', 'create', 'store', 'edit', 'update'])
        ->middleware('location.access');

    // デバイス管理 (FR-005)
    Route::resource('devices', DeviceController::class)
        ->only(['index', 'create', 'store', 'edit', 'update']);
    Route::get('devices/export-csv', [DeviceController::class, 'exportCsv'])->name('devices.export-csv');

    // 測定履歴 (FR-011, FR-012)
    Route::get('measurement-records', [MeasurementRecordController::class, 'index'])->name('measurement_records.index');
    Route::get('measurement-records/export-csv', [MeasurementRecordController::class, 'exportCsv'])->name('measurement_records.export-csv');

    // ライセンス管理 (FR-006, FR-007, FR-009, FR-010)
    Route::get('licenses', [LicenseController::class, 'index'])->name('licenses.index');
    Route::post('licenses', [LicenseController::class, 'store'])->name('licenses.store');
    Route::get('licenses/export-csv', [LicenseController::class, 'exportCsv'])->name('licenses.export-csv');

    // 組織管理 (FR-013)
    Route::get('companies', [CompanyController::class, 'index'])->name('companies.index');
});