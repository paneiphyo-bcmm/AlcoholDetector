{{-- resources/views/companies/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h2>組織管理</h2>

{{-- FR-013: 会社名部分一致・法人ID検索 --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('companies.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">会社名（部分一致）</label>
                    <input type="text"
                           name="company_name"
                           class="form-control"
                           placeholder="会社名"
                           value="{{ request('company_name') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">法人ID（完全一致）</label>
                    <input type="text"
                           name="corporate_id"
                           class="form-control"
                           placeholder="法人番号"
                           value="{{ request('corporate_id') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">検索</button>
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">リセット</a>
                </div>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>会社ID</th>
            <th>会社名</th>
            <th>法人ID</th>
            <th>作成日時</th>
        </tr>
    </thead>
    <tbody>
        @forelse($companies as $company)
        <tr>
            <td>{{ $company->company_id }}</td>
            <td>{{ $company->company_name }}</td>
            <td>{{ $company->corporate_id ?? '-' }}</td>
            <td>{{ $company->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">該当する会社が見つかりません。</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection