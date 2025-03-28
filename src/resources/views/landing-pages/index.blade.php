@extends('landing-page-manager::layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>ランディングページ一覧</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('landing-page-manager.landing-pages.create') }}" class="btn btn-primary">
                新規作成
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>タイトル</th>
                            <th>スラグ</th>
                            <th>ステータス</th>
                            <th>作成日</th>
                            <th width="200">アクション</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($landingPages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    @if ($page->is_published)
                                        <span class="badge bg-success">公開中</span>
                                    @else
                                        <span class="badge bg-secondary">非公開</span>
                                    @endif
                                </td>
                                <td>{{ $page->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('landing-page-manager.landing-pages.show', $page) }}" class="btn btn-sm btn-info">
                                            詳細
                                        </a>
                                        <a href="{{ route('landing-page-manager.landing-pages.edit', $page) }}" class="btn btn-sm btn-warning">
                                            編集
                                        </a>
                                        <a href="{{ route('landing-page-manager.landing-pages.metrics.index', $page) }}" class="btn btn-sm btn-primary">
                                            メトリクス
                                        </a>
                                        @if ($page->is_published)
                                            <a href="{{ route('landing-page-manager.landing-pages.public.show', $page->slug) }}" class="btn btn-sm btn-success" target="_blank">
                                                閲覧
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">ランディングページがありません</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $landingPages->links() }}
        </div>
    </div>
</div>
@endsection

