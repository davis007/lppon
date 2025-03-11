@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>ランディングページ一覧</span>
                    <a href="{{ route('landing-pages.create') }}" class="btn btn-primary btn-sm">新規作成</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (count($landingPages) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>タイトル</th>
                                        <th>ステータス</th>
                                        <th>作成日</th>
                                        <th>更新日</th>
                                        <th>アクション</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($landingPages as $landingPage)
                                        <tr>
                                            <td>{{ $landingPage->id }}</td>
                                            <td>{{ $landingPage->title }}</td>
                                            <td>
                                                @if ($landingPage->status === 'published')
                                                    <span class="badge badge-success">公開中</span>
                                                @elseif ($landingPage->status === 'draft')
                                                    <span class="badge badge-warning">下書き</span>
                                                @else
                                                    <span class="badge badge-secondary">アーカイブ</span>
                                                @endif
                                            </td>
                                            <td>{{ $landingPage->created_at->format('Y-m-d H:i') }}</td>
                                            <td>{{ $landingPage->updated_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('landing-pages.show', $landingPage->id) }}" class="btn btn-info btn-sm">詳細</a>
                                                    <a href="{{ route('landing-pages.edit', $landingPage->id) }}" class="btn btn-warning btn-sm">編集</a>
                                                    <a href="{{ route('landing-pages.metrics.index', $landingPage->id) }}" class="btn btn-success btn-sm">メトリクス</a>
                                                    @if ($landingPage->status === 'published')
                                                        <a href="{{ route('landing-pages.public.show', $landingPage->slug) }}" class="btn btn-primary btn-sm" target="_blank">表示</a>
                                                    @endif
                                                    <form action="{{ route('landing-pages.destroy', $landingPage->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $landingPages->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            ランディングページがまだありません。新規作成ボタンから作成してください。
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
