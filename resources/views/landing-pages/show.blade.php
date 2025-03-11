@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>ランディングページ詳細: {{ $landingPage->title }}</span>
                    <div>
                        @if ($landingPage->status === 'published')
                            <a href="{{ route('landing-pages.public.show', $landingPage->slug) }}" class="btn btn-primary btn-sm mr-2" target="_blank">公開ページを表示</a>
                        @endif
                        <a href="{{ route('landing-pages.metrics.index', $landingPage->id) }}" class="btn btn-success btn-sm mr-2">メトリクス</a>
                        <a href="{{ route('landing-pages.edit', $landingPage->id) }}" class="btn btn-warning btn-sm mr-2">編集</a>
                        <a href="{{ route('landing-pages.index') }}" class="btn btn-secondary btn-sm">戻る</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">ID:</div>
                        <div class="col-md-9">{{ $landingPage->id }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">タイトル:</div>
                        <div class="col-md-9">{{ $landingPage->title }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">スラッグ:</div>
                        <div class="col-md-9">{{ $landingPage->slug }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">説明:</div>
                        <div class="col-md-9">{{ $landingPage->description ?? '説明なし' }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">ステータス:</div>
                        <div class="col-md-9">
                            @if ($landingPage->status === 'published')
                                <span class="badge badge-success">公開中</span>
                            @elseif ($landingPage->status === 'draft')
                                <span class="badge badge-warning">下書き</span>
                            @else
                                <span class="badge badge-secondary">アーカイブ</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">作成日:</div>
                        <div class="col-md-9">{{ $landingPage->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">更新日:</div>
                        <div class="col-md-9">{{ $landingPage->updated_at->format('Y-m-d H:i:s') }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">コンテンツプレビュー:</div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="content-preview">
                                        {!! Str::limit($landingPage->content, 500) !!}
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-outline-primary" id="toggleContent">全文表示</button>
                                    </div>
                                    <div class="content-full mt-3" style="display: none;">
                                        {!! $landingPage->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">メトリクス概要:</div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">訪問者数</h5>
                                                    <p class="card-text h3">{{ $landingPage->metrics()->distinct('visitor_id')->count('visitor_id') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">平均読了率</h5>
                                                    <p class="card-text h3">{{ number_format($landingPage->metrics()->avg('read_through_rate') * 100, 1) }}%</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">平均滞在時間</h5>
                                                    <p class="card-text h3">{{ number_format($landingPage->metrics()->avg('time_spent')) }}秒</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="{{ route('landing-pages.metrics.index', $landingPage->id) }}" class="btn btn-primary">詳細メトリクスを表示</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <form action="{{ route('landing-pages.destroy', $landingPage->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？この操作は元に戻せません。')">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggleContent');
        const previewContent = document.querySelector('.content-preview');
        const fullContent = document.querySelector('.content-full');

        toggleButton.addEventListener('click', function() {
            if (fullContent.style.display === 'none') {
                previewContent.style.display = 'none';
                fullContent.style.display = 'block';
                toggleButton.textContent = '省略表示';
            } else {
                previewContent.style.display = 'block';
                fullContent.style.display = 'none';
                toggleButton.textContent = '全文表示';
            }
        });
    });
</script>
@endsection
