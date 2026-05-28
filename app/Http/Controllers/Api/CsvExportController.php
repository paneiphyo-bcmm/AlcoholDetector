// app/Http/Controllers/Api/CsvExportController.php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CsvExportRequest;
use App\Services\CsvExportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvExportController extends Controller
{
    public function __construct(
        private readonly CsvExportService $csvExportService
    ) {}

    // FR-009, FR-010: CSV出力
    public function export(CsvExportRequest $request): StreamedResponse|JsonResponse
    {
        $target = $request->input('target');
        $filters = $request->input('filter_conditions', []);

        if ($target === 'measurement_records') {
            $csvContent = $this->csvExportService->exportMeasurementRecords($filters);
            $filename = '測定履歴_' . now()->format('YmdHis') . '.csv';

            return response()->streamDownload(
                fn () => print($csvContent),
                $filename,
                ['Content-Type' => 'text/csv; charset=UTF-8']
            );
        }

        if ($target === 'licenses') {
            $url = $this->csvExportService->exportLicensesToS3();

            return response()->json(['url' => $url]);
        }

        return response()->json(['message' => '対象が不正です。'], Response::HTTP_BAD_REQUEST);
    }
}