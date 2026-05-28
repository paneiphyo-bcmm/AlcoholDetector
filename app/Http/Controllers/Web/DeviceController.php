// app/Http/Controllers/Web/DeviceController.php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Repositories\DeviceRepository;
use App\Repositories\LocationRepository;
use App\Services\DeviceService;
use App\Services\CsvExportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DeviceController extends Controller
{
    public function __construct(
        private readonly DeviceService $deviceService,
        private readonly DeviceRepository $deviceRepository,
        private readonly LocationRepository $locationRepository,
        private readonly CsvExportService $csvExportService
    ) {}

    public function index(): View
    {
        $devices = $this->deviceRepository->getAll();

        return view('devices.index', compact('devices'));
    }

    public function create(): View
    {
        $locations = $this->locationRepository->getAllForAdmin();

        return view('devices.create', compact('locations'));
    }

    public function store(StoreDeviceRequest $request): RedirectResponse
    {
        $this->deviceService->store($request->validated(), $request->user());

        return redirect()->route('devices.index')->with('success', 'デバイスを登録しました。');
    }

    public function edit(string $deviceId): View
    {
        $device    = $this->deviceRepository->findById($deviceId);
        $locations = $this->locationRepository->getAllForAdmin();
        abort_if(!$device, 404);

        return view('devices.edit', compact('device', 'locations'));
    }

    public function update(UpdateDeviceRequest $request, string $deviceId): RedirectResponse
    {
        $this->deviceService->update($deviceId, $request->validated(), $request->user());

        return redirect()->route('devices.index')->with('success', 'デバイス情報を更新しました。');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $csvContent = $this->csvExportService->exportMeasurementRecords([]);
        $filename = 'デバイス一覧_' . now()->format('YmdHis') . '.csv';

        return response()->streamDownload(
            fn () => print($csvContent),
            $filename,
            ['Content-Type' => 'text/csv; charset=UTF-8']
        );
    }
}