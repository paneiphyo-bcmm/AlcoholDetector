// app/Http/Controllers/Api/MeasurementRecordController.php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchMeasurementRecordRequest;
use App\Http\Requests\StoreMeasurementRecordRequest;
use App\Services\MeasurementRecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MeasurementRecordController extends Controller
{
    public function __construct(
        private readonly MeasurementRecordService $measurementRecordService
    ) {}

    // FR-011, FR-012: 測定履歴画面表示・複数選択氏名フィルタ
    public function index(SearchMeasurementRecordRequest $request): JsonResponse
    {
        $records = $this->measurementRecordService->search($request->validated());

        return response()->json(['records' => $records]);
    }

    // FR-008: 測定履歴保存時利用者数更新
    public function store(StoreMeasurementRecordRequest $request): JsonResponse
    {
        $record = $this->measurementRecordService->store(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message'   => '測定履歴を登録しました。',
            'record_id' => $record->record_id,
        ], Response::HTTP_CREATED);
    }
}