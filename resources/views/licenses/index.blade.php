{{-- resources/views/licenses/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h2>ライセンス管理</h2>

{{-- 新規ライセンス登録フォーム --}}
<div class="card mb-4">
    <div class="card-header">新規ライセンス登録</div>
    <div class="card-body">
        <form method="POST" action="{{ route('licenses.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">会社 <span class="text-danger">*</span></label>
                    <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" required>
                        <option value="">-- 選択してください --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->company_id }}"
                                {{ old('company_id') === $company->company_id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">契約数 <span class="text-danger">*</span></label>
                    <input type="number"
                           name="contract_count"
                           class="form-control @error('contract_count') is-invalid @enderror"
                           value="{{ old('contract_count', 0) }}"
                           min="0" required>
                    @error('contract_count')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- FR-006: 契約数超過フィルタ --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="form-check">
        <form method="GET" action="{{ route('licenses.index') }}">
            <input class="form-check-input" type="checkbox"
                   name="exceeded_only" value="1"
                   onchange="this.form.submit()"
                   {{ $exceededOnly ? 'checked' : '' }}>
            <label class="form-check-label">契約数超過会社のみ表示</label>
        </form>
    </div>
    <button onclick="exportMonthlyLicenseCsv()" class="btn btn-success btn-sm">月初CSV出力</button>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ライセンスID</th>
            <th>会社名</th>
            <th>契約数</th>
            <th>利用数</th>
            <th>状態</th>
        </tr>
    </thead>
    <tbody>
        @forelse($licenses as $license)
        <tr class="{{ $license->isExceeded() ? 'table-danger' : '' }}">
            <td>{{ $license->license_id }}</td>
            <td>{{ $license->company?->company_name ?? '-' }}</td>
            <td>{{ $license->contract_count }}</td>
            <td>{{ $license->usage_count }}</td>
            <td>
                @if($license->isExceeded())
                    <span class="badge bg-danger">超過</span>
                @else
                    <span class="badge bg-success">正常</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">ライセンスが登録されていません。</td>
        </tr>
        @endforelse
    </tbody>
</table>

<script>
function exportMonthlyLicenseCsv() {
    fetch('{{ route('licenses.export-csv') }}')
        .then(r => r.json())
        .then(data => alert('CSV出力完了: ' + data.url))
        .catch(() => alert('CSV出力に失敗しました。'));
}
</script>
@endsection