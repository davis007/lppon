@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('プロンプト編集') }}</span>
                    <div>
                        <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-info btn-sm">{{ __('詳細に戻る') }}</a>
                        <a href="{{ route('prompts.index') }}" class="btn btn-secondary btn-sm ml-2">{{ __('一覧に戻る') }}</a>
                    </div>
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

                    <form method="POST" action="{{ route('prompts.update', $prompt) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>{{ __('基本情報') }}</h4>
                                <hr>
                            </div>
                        </div>

                        <!-- 基本情報 -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{ __('ページタイトル') }} <span class="text-danger">*</span></label>
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $prompt->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="concept">{{ __('コンセプト') }} <span class="text-danger">*</span></label>
                                    <input id="concept" type="text" class="form-control @error('concept') is-invalid @enderror" name="concept" value="{{ old('concept', $prompt->concept) }}" required>
                                    @error('concept')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purpose">{{ __('目的') }} <span class="text-danger">*</span></label>
                                    <textarea id="purpose" class="form-control @error('purpose') is-invalid @enderror" name="purpose" rows="4" required>{{ old('purpose', $prompt->purpose) }}</textarea>
                                    @error('purpose')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="target">{{ __('ターゲット') }} <span class="text-danger">*</span></label>
                                    <input id="target" type="text" class="form-control @error('target') is-invalid @enderror" name="target" value="{{ old('target', $prompt->target) }}" required>
                                    @error('target')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label for="cta_button_text">{{ __('CTAボタンテキスト') }} <span class="text-danger">*</span></label>
                                    <input id="cta_button_text" type="text" class="form-control @error('cta_button_text') is-invalid @enderror" name="cta_button_text" value="{{ old('cta_button_text', $prompt->cta_button_text) }}" required>
                                    <small class="form-text text-muted">{{ __('例：「参加する」「購入する」など') }}</small>
                                    @error('cta_button_text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile_image">{{ __('プロフィール画像') }}</label>
                                    @if ($prompt->profile_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $prompt->profile_image) }}" alt="現在のプロフィール画像" class="img-thumbnail" style="max-width: 150px;">
                                            <p class="text-muted mt-1">{{ __('新しい画像をアップロードすると、現在の画像は置き換えられます。') }}</p>
                                        </div>
                                    @endif
                                    <input id="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image">
                                    <small class="form-text text-muted">{{ __('2MB以下の画像ファイル') }}</small>
                                    @error('profile_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile">{{ __('プロフィール') }} <span class="text-danger">*</span></label>
                                    <textarea id="profile" class="form-control @error('profile') is-invalid @enderror" name="profile" rows="4" required>{{ old('profile', $prompt->profile) }}</textarea>
                                    @error('profile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 mt-4">
                            <div class="col-md-12">
                                <h4>{{ __('デザイン設定') }}</h4>
                                <hr>
                            </div>
                        </div>

                        <!-- デザイン設定 -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="color_scheme">{{ __('カラースキーム') }} <span class="text-danger">*</span></label>
                                    <select id="color_scheme" class="form-control @error('color_scheme') is-invalid @enderror" name="color_scheme" required>
                                        <option value="">{{ __('選択してください') }}</option>
                                        @foreach ($colorSchemes as $value => $label)
                                            <option value="{{ $value }}" {{ old('color_scheme', $prompt->color_scheme) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('color_scheme')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="framework">{{ __('フレームワーク') }} <span class="text-danger">*</span></label>
                                    <select id="framework" class="form-control @error('framework') is-invalid @enderror" name="framework" required>
                                        <option value="">{{ __('選択してください') }}</option>
                                        @foreach ($frameworks as $value => $label)
                                            <option value="{{ $value }}" {{ old('framework', $prompt->framework) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('framework')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="font">{{ __('フォント') }} <span class="text-danger">*</span></label>
                                    <select id="font" class="form-control @error('font') is-invalid @enderror" name="font" required>
                                        <option value="">{{ __('選択してください') }}</option>
                                        @foreach ($fonts as $value => $label)
                                            <option value="{{ $value }}" {{ old('font', $prompt->font) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('font')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('アニメーション効果') }}</label>
                                    <div class="mt-2">
                                        @foreach ($animations as $value => $label)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="animations[]" id="animation_{{ $value }}" value="{{ $value }}"
                                                    {{ is_array(old('animations', $prompt->animations)) && in_array($value, old('animations', $prompt->animations)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="animation_{{ $value }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('animations')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('プロンプトを更新') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
