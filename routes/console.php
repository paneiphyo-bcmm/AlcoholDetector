// routes/console.php
<?php

use Illuminate\Support\Facades\Schedule;

// FR-010: 月初ライセンスデータCSV保存（毎月1日 0時実行）
Schedule::command('csv:export-monthly-licenses')
    ->monthlyOn(1, '00:00')
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('月初ライセンスCSVスケジューラ実行失敗');
    });