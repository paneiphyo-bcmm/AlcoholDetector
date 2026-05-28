{{-- resources/views/devices/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>デバイス一覧</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('devices.export-csv') }}" class="btn btn-success">一覧CSV出力</a>
        <a href="{{ route('devices.create') }}" class="btn btn-primary">新規登録</a>
    </div>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>デバイスID</th>
            <th>デバイス名</th>
            <th>シリアル番号</th>
            <th>拠点名</th>
            <th>導入日</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @forelse($devices as $device)
        <tr>
            <td>{{ $device->device_id }}</td>
            <td>{{ $device->device_name }}</td>
            <td>{{ $device->serial_number ?? '-' }}</td>
            <td>{{ $device->location?->location_name ?? '-' }}</td>
            <td>{{ $device->installation_date?->format('Y-m-d') ?? '-' }}</td>
            <td>
                <a href="{{ route('devices.edit', $device->device_id) }}"
                   class="btn btn-sm btn-warning">編集</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">デバイスが登録されていません。</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection