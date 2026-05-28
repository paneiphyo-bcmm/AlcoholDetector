{{-- resources/views/measurement_records/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h2>測定履歴一覧</h2>

{{-- FR-011, FR-012: フィルタ --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('measurement_records.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">拠点</label>
                    <select name="location_id" class="form-select">
                        <option value="">全拠点</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->location_id }}"
                                {{ ($filters['location_id'] ?? '') === $location->location_id ? 'selected' : '' }}>
                                {{ $location->location_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    {{-- FR-012: 複数選択氏名フィルタ --}}
                    <label class="form-label">氏名（複数可・部分一致）</label>
                    <input type="text"
                           name="user_names[]"
                           class="form-control"
                           placeholder="例: 山田"
                           value="{{ isset($filters['user_names'][0]) ? $filters['user_names'][0] : '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">会社名・法人ID</label>
                    <input type="text"
                           name="company_name_or_id"
                           class="form-control"
                           placeholder="会社名または法人ID"
                           value="{{ $filters['company_name_or_id'] ?? '' }}">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">検索</button>
                    <a href="{{ route('measurement_records.index') }}" class="btn btn-secondary">リセット</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-2">
    <span>{{ $records->total() }}件</span>
    <a href="{{ route('measurement_records.export-csv', request()->query()) }}"
       class="btn btn-success btn-sm">CSV出力</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>測定ID</th>
            <th>測定日時</th>
            <th>利用者氏名</th>
            <th>アルコール濃度</th>
            <th>拠点名</th>
            <th>デバイス名</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $record)
        <tr>
            <td>{{ $record->record_id }}</td>
            <td>{{ $record->measurement_time->format('Y-m-d H:i:s') }}</td>
            <td>{{ $record->user?->user_name ?? '-' }}</td>
            <td>{{ $record->alcohol_level }}</td>
            <td>{{ $record->location?->location_name ?? '-' }}</td>
            <td>{{ $record->device?->device_name ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">測定履歴が見つかりません。</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $records->withQueryString()->links() }}
@endsection