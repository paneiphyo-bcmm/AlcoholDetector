{{-- resources/views/devices/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<h2>デバイス編集</h2>
<div class="card">
    <div class="card-body">
        <p><strong>デバイスID：</strong>{{ $device->device_id }}</p>
        <form method="POST" action="{{ route('devices.update', $device->device_id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">デバイス名 <span class="text-danger">*</span></label>
                <input type="text"
                       name="device_name"
                       class="form-control @error('device_name') is-invalid @enderror"
                       value="{{ old('device_name', $device->device_name) }}"
                       maxlength="100" required>
                @error('device_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">シリアル番号</label>
                <input type="text"
                       name="serial_number"
                       class="form-control"
                       value="{{ old('serial_number', $device->serial_number) }}"
                       maxlength="50">
            </div>
            <div class="mb-3">
                <label class="form-label">拠点 <span class="text-danger">*</span></label>
                <select name="location_id" class="form-select @error('location_id') is-invalid @enderror" required>
                    <option value="">-- 選択してください --</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->location_id }}"
                            {{ old('location_id', $device->location_id) === $location->location_id ? 'selected' : '' }}>
                            {{ $location->location_name }}
                        </option>
                    @endforeach
                </select>
                @error('location_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">導入日</label>
                <input type="date"
                       name="installation_date"
                       class="form-control"
                       value="{{ old('installation_date', $device->installation_date?->format('Y-m-d')) }}">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">保存</button>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection