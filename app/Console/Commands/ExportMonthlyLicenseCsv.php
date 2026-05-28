// app/Console/Commands/ExportMonthlyLicenseCsv.php
<?php

namespace App\Console\Commands;

use App\Services\CsvExportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExportMonthlyLicenseCsv extends Command
{
    protected $signature   = 'csv:export-monthly-licenses';
    protected $description = '月初ライセンスデータをCSV出力してS3に保存する';

    public function __construct(
        private readonly CsvExportService $csvExportService
    ) {
        parent::__construct();
    }

    // FR-010: 月初ライセンスデータCSV保存
    public function handle(): int
    {
        try {
            $this->info('月初ライセンスCSV出力開始...');

            $url = $this->csvExportService->exportLicensesToS3();

            $this->info("CSV出力完了: {$url}");
            Log::info('月初ライセンスCSV出力完了', ['url' => $url]);

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("CSV出力失敗: {$e->getMessage()}");
            Log::error('月初ライセンスCSV出力失敗', ['error' => $e->getMessage()]);

            return self::FAILURE;
        }
    }
}