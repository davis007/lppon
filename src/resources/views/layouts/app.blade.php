<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - ランディングページ管理</title>

    <!-- スタイルシート -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- カスタムスタイル -->
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('landing-page-manager.landing-pages.index') }}">
                    ランディングページ管理
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('landing-page-manager.landing-pages.index') }}">
                                ランディングページ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('landing-page-manager.landing-pages.create') }}">
                                新規作成
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <!-- スクリプト -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

