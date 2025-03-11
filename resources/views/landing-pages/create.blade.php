@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>ランディングページ作成</span>
                    <a href="{{ route('landing-pages.index') }}" class="btn btn-secondary btn-sm">戻る</a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('landing-pages.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-md-right">タイトル</label>
                            <div class="col-md-10">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="slug" class="col-md-2 col-form-label text-md-right">スラッグ</label>
                            <div class="col-md-10">
                                <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}">
                                <small class="form-text text-muted">URLに使用される識別子です。空白の場合はタイトルから自動生成されます。</small>
                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-2 col-form-label text-md-right">説明</label>
                            <div class="col-md-10">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                                <small class="form-text text-muted">ランディングページの簡単な説明（管理用）</small>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="content" class="col-md-2 col-form-label text-md-right">コンテンツ</label>
                            <div class="col-md-10">
                                <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" rows="15" required>{{ old('content') }}</textarea>
                                <small class="form-text text-muted">HTMLコンテンツを入力してください</small>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-2 col-form-label text-md-right">ステータス</label>
                            <div class="col-md-10">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>下書き</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>公開</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>アーカイブ</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    保存
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // タイトルからスラッグを自動生成
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        titleInput.addEventListener('blur', function() {
            if (slugInput.value === '') {
                // タイトルをスラッグ形式に変換（日本語はローマ字変換しないので注意）
                const slug = titleInput.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '') // 特殊文字を削除
                    .replace(/\s+/g, '-')     // スペースをハイフンに変換
                    .replace(/--+/g, '-')     // 複数のハイフンを単一のハイフンに変換
                    .trim();

                slugInput.value = slug;
            }
        });
    });
</script>
@endsection
