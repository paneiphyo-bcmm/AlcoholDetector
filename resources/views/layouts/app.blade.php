{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alcohol Detection System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">ADS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('locations.index') }}">拠点管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('devices.index') }}">デバイス管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('measurement_records.index') }}">測定履歴</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('licenses.index') }}">ライセンス管理</a>
                    </li>
                    @if(auth()->user()?->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('companies.index') }}">組織管理</a>
                    </li>
                    @endif
                </ul>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">ログアウト</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>