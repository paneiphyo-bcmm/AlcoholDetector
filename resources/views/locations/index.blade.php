{{-- resources/views/locations/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>拠点一覧</h2>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('locations.create') }}" class="btn btn-primary">新規拠点登録</a>
    @endif
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>拠点ID</th>
            <th>拠点名</th>
            <th>拠点管理者</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @forelse($locations as $location)
        <tr>
            <td>{{ $location->location_id }}</td>
            <td>{{ $location->location_name }}</td>
            <td>{{ $location->adminUser?->user_name ?? '-' }}</td>
            <td>
                <a href="{{ route('locations.edit', $location->location_id) }}"
                   class="btn btn-sm btn-warning">編集</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">拠点が登録されていません。</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection