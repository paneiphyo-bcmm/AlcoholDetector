// app/Http/Controllers/Web/MeasurementRecordController.php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchMeasurementRecordRequest;
use App\Repositories\LocationRepository;
use App\Services\CsvExportService;
use App\Services\MeasurementRecordService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MeasurementRecordController extends Controller
{
    public function __construct(
        private readonly MeasurementRecordService $measurementRecordService,
        private readonly LocationRepository $locationRepository,
        private readonly CsvExportService $csvExportService
    ) {}

    // FR-011, FR-012: 測定履歴画面表示・複数選択氏名フィルタ
    public function index(SearchMeasurementRecordRequest $request): View
    {
        $filters   = $request->validated();
        $records   = $this->measurementRecordService->search($filters);
        $locations = $this->locationRepository->getAllForAdmin();

        return view('measurement_records.index', compact('records', 'locations', 'filters'));
    }

    public function exportCsv(SearchMeasurementRecordRequest $request): StreamedResponse
    {
        $filters    = $request->validated();
        $csvContent = $this->csvExportService->exportMeasurementRecords($filters);
        $filename   = '測定履歴_' . now()->format('YmdHis') . '.csv';

        return response()->streamDownload(
            fn () => print($csvContent),
            $filename,
            ['Content-Type' => 'text/csv; charset=UTF-8']
        );
    }
}