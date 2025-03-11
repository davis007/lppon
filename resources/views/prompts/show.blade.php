@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('プロンプト詳細') }}</span>
                    <div>
                        <a href="{{ route('prompts.edit', $prompt) }}" class="btn btn-warning btn-sm">{{ __('編集') }}</a>
                        <a href="{{ route('prompts.index') }}" class="btn btn-secondary btn-sm ml-2">{{ __('戻る') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>{{ __('基本情報') }}</h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('ページタイトル') }}:</label>
                                <p>{{ $prompt->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('コンセプト') }}:</label>
                                <p>{{ $prompt->concept }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('目的') }}:</label>
                                <p>{{ $prompt->purpose }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('ターゲット') }}:</label>
                                <p>{{ $prompt->target }}</p>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('CTAボタンテキスト') }}:</label>
                                <p>{{ $prompt->cta_button_text }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('プロフィール画像') }}:</label>
                                @if ($prompt->profile_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $prompt->profile_image) }}" alt="プロフィール画像" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @else
                                    <p>{{ __('画像なし') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('プロフィール') }}:</label>
                                <p>{{ $prompt->profile }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>{{ __('デザイン設定') }}</h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('カラースキーム') }}:</label>
                                <p>
                                    @php
                                        $colorSchemes = [
                                            'blackboard' => '黒板風（ダーク＆チョーク）',
                                            'report' => 'レポート風（クリーン＆プロフェッショナル）',
                                            'modern' => 'モダン（シンプル＆スタイリッシュ）',
                                            'nature' => '自然（グリーン＆アース）',
                                            'tech' => 'テクノロジー（ブルー＆グレー）',
                                            'creative' => 'クリエイティブ（カラフル＆ポップ）',
                                            'elegant' => 'エレガント（ゴールド＆ブラック）',
                                            'minimal' => 'ミニマル（ホワイト＆グレー）',
                                        ];
                                    @endphp
                                    {{ $colorSchemes[$prompt->color_scheme] ?? $prompt->color_scheme }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('フレームワーク') }}:</label>
                                <p>
                                    @php
                                        $frameworks = [
                                            'tailwind' => 'Tailwind CSS',
                                            'bootstrap' => 'Bootstrap 4.5',
                                        ];
                                    @endphp
                                    {{ $frameworks[$prompt->framework] ?? $prompt->framework }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('フォント') }}:</label>
                                <p>
                                    @php
                                        $fonts = [
                                            'noto-sans-jp' => 'Noto Sans JP',
                                            'noto-serif-jp' => 'Noto Serif JP',
                                            'm-plus-1p' => 'M PLUS 1p',
                                            'kosugi-maru' => 'Kosugi Maru',
                                            'sawarabi-gothic' => 'Sawarabi Gothic',
                                            'sawarabi-mincho' => 'Sawarabi Mincho',
                                        ];
                                    @endphp
                                    {{ $fonts[$prompt->font] ?? $prompt->font }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('アニメーション効果') }}:</label>
                                <p>
                                    @php
                                        $animations = [
                                            'scroll' => 'スクロールアニメーション',
                                            'typewriter' => 'タイプライター効果',
                                            'particle' => 'パーティクルエフェクト',
                                        ];
                                        $selectedAnimations = [];
                                        if (!empty($prompt->animations)) {
                                            foreach ($prompt->animations as $animation) {
                                                if (isset($animations[$animation])) {
                                                    $selectedAnimations[] = $animations[$animation];
                                                }
                                            }
                                        }
                                    @endphp
                                    {{ !empty($selectedAnimations) ? implode(', ', $selectedAnimations) : '設定なし' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>{{ __('生成されたプロンプト') }}</h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <pre class="mb-0" style="white-space: pre-wrap;">{{ $prompt->generated_prompt }}</pre>
                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" onclick="copyToClipboard()">{{ __('クリップボードにコピー') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const promptText = document.querySelector('pre').innerText;
        navigator.clipboard.writeText(promptText).then(function() {
            alert('{{ __("プロンプトをクリップボードにコピーしました。") }}');
        }, function(err) {
            console.error('コピーに失敗しました: ', err);
            alert('{{ __("コピーに失敗しました。") }}');
        });
    }
</script>
@endsection
