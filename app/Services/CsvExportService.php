// app/Services/CsvExportService.php
<?php

namespace App\Services;

use App\Repositories\LicenseRepository;
use App\Repositories\MeasurementRecordRepository;
use Illuminate\Support\Facades\Storage;

class CsvExportService
{
    public function __construct(
        private readonly MeasurementRecordRepository $measurementRecordRepository,
        private readonly LicenseRepository $licenseRepository
    ) {}

    // FR-009: 測定履歴CSV出力
    public function exportMeasurementRecords(array $filters): string
    {
        $records = $this->measurementRecordRepository->searchForExport($filters);

        $headers = [
            '測定ID',
            '測定日時',
            '利用者氏名',
            'アルコール濃度',
            '拠点名',
            'デバイス名',
        ];

        $rows = $records->map(fn ($record) => [
            $record->record_id,
            $record->measurement_time->format('Y-m-d H:i:s'),
            $record->user?->user_name ?? '',
            $record->alcohol_level,
            $record->location?->location_name ?? '',
            $record->device?->device_name ?? '',
        ])->toArray();

        return $this->buildCsvContent($headers, $rows);
    }

    // FR-010: 月初ライセンスデータCSV保存
    public function exportLicensesToS3(): string
    {
        $licenses = $this->licenseRepository->getAllForExport();

        $headers = [
            'ライセンスID',
            '会社ID',
            '会社名',
            '契約数',
            '利用数',
        ];

        $rows = $licenses->map(fn ($license) => [
            $license->license_id,
            $license->company_id,
            $license->company?->company_name ?? '',
            $license->contract_count,
            $license->usage_count,
        ])->toArray();

        $csvContent = $this->buildCsvContent($headers, $rows);

        $fileName = 'licenses/' . now()->format('Ym') . '_licenses.csv';
        Storage::disk('s3')->put($fileName, $csvContent);

        return Storage::disk('s3')->url($fileName);
    }

    private function buildCsvContent(array $headers, array $rows): string
    {
        $output = fopen('php://temp', 'r+');

        // BOM付きUTF-8でExcel対応
        fputs($output, "\xEF\xBB\xBF");
        fputcsv($output, $headers);

        foreach ($rows as $row) {
            fputcsv($output, $row);
        }

        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);

        return $content;
    }
}