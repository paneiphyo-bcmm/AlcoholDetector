{{-- resources/views/locations/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<h2>拠点編集</h2>
<div class="card">
    <div class="card-body">
        <p><strong>拠点ID：</strong>{{ $location->location_id }}</p>
        <form method="POST" action="{{ route('locations.update', $location->location_id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">拠点名 <span class="text-danger">*</span></label>
                <input type="text"
                       name="location_name"
                       class="form-control @error('location_name') is-invalid @enderror"
                       value="{{ old('location_name', $location->location_name) }}"
                       maxlength="100" required>
                @error('location_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">拠点管理者ユーザID <span class="text-danger">*</span></label>
                <input type="text"
                       name="admin_user_id"
                       class="form-control @error('admin_user_id') is-invalid @enderror"
                       value="{{ old('admin_user_id', $location->admin_user_id) }}"
                       maxlength="10" required>
                @error('admin_user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">拠点保存</button>
                <a href="{{ route('locations.index') }}" class="btn btn-secondary">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection