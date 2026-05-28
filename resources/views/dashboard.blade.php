{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<h2>ダッシュボード</h2>
<p>ようこそ、{{ auth()->user()->user_name }} さん。</p>
<div class="row g-3 mt-2">
    <div class="col-md-3">
        <a href="{{ route('locations.index') }}" class="text-decoration-none">
            <div class="card text-center p-3 bg-primary text-white">
                <h5>拠点管理</h5>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('devices.index') }}" class="text-decoration-none">
            <div class="card text-center p-3 bg-info text-white">
                <h5>デバイス管理</h5>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('measurement_records.index') }}" class="text-decoration-none">
            <div class="card text-center p-3 bg-success text-white">
                <h5>測定履歴</h5>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('licenses.index') }}" class="text-decoration-none">
            <div class="card text-center p-3 bg-warning text-white">
                <h5>ライセンス管理</h5>
            </div>
        </a>
    </div>
</div>
@endsection