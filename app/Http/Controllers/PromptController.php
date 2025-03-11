<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prompts = Prompt::where('user_id', Auth::id())->latest()->paginate(10);
        return view('prompts.index', compact('prompts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // カラースキームのプリセット
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

        // フレームワーク選択
        $frameworks = [
            'tailwind' => 'Tailwind CSS',
            'bootstrap' => 'Bootstrap 4.5',
        ];

        // フォント設定
        $fonts = [
            'noto-sans-jp' => 'Noto Sans JP',
            'noto-serif-jp' => 'Noto Serif JP',
            'm-plus-1p' => 'M PLUS 1p',
            'kosugi-maru' => 'Kosugi Maru',
            'sawarabi-gothic' => 'Sawarabi Gothic',
            'sawarabi-mincho' => 'Sawarabi Mincho',
        ];

        // アニメーション効果
        $animations = [
            'scroll' => 'スクロールアニメーション',
            'typewriter' => 'タイプライター効果',
            'particle' => 'パーティクルエフェクト',
        ];

        return view('prompts.create', compact('colorSchemes', 'frameworks', 'fonts', 'animations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'concept' => 'required|string|max:255',
            'purpose' => 'required|string',
            'target' => 'required|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'profile' => 'required|string',
            'cta_button_text' => 'required|string|max:255',
            'color_scheme' => 'required|string|max:255',
            'framework' => 'required|string|max:255',
            'font' => 'required|string|max:255',
            'animations' => 'nullable|array',
        ]);

        // プロフィール画像のアップロード処理
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $path;
        }

        // ユーザーIDを追加
        $validated['user_id'] = Auth::id();

        // プロンプトの生成
        $validated['generated_prompt'] = $this->generatePrompt($validated);

        // プロンプトの保存
        $prompt = Prompt::create($validated);

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'プロンプトが正常に生成されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prompt $prompt)
    {
        // 権限チェック
        $this->authorize('view', $prompt);

        return view('prompts.show', compact('prompt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prompt $prompt)
    {
        // 権限チェック
        $this->authorize('update', $prompt);

        // カラースキームのプリセット
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

        // フレームワーク選択
        $frameworks = [
            'tailwind' => 'Tailwind CSS',
            'bootstrap' => 'Bootstrap 4.5',
        ];

        // フォント設定
        $fonts = [
            'noto-sans-jp' => 'Noto Sans JP',
            'noto-serif-jp' => 'Noto Serif JP',
            'm-plus-1p' => 'M PLUS 1p',
            'kosugi-maru' => 'Kosugi Maru',
            'sawarabi-gothic' => 'Sawarabi Gothic',
            'sawarabi-mincho' => 'Sawarabi Mincho',
        ];

        // アニメーション効果
        $animations = [
            'scroll' => 'スクロールアニメーション',
            'typewriter' => 'タイプライター効果',
            'particle' => 'パーティクルエフェクト',
        ];

        return view('prompts.edit', compact('prompt', 'colorSchemes', 'frameworks', 'fonts', 'animations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prompt $prompt)
    {
        // 権限チェック
        $this->authorize('update', $prompt);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'concept' => 'required|string|max:255',
            'purpose' => 'required|string',
            'target' => 'required|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'profile' => 'required|string',
            'cta_button_text' => 'required|string|max:255',
            'color_scheme' => 'required|string|max:255',
            'framework' => 'required|string|max:255',
            'font' => 'required|string|max:255',
            'animations' => 'nullable|array',
        ]);

        // プロフィール画像のアップロード処理
        if ($request->hasFile('profile_image')) {
            // 古い画像を削除
            if ($prompt->profile_image) {
                Storage::disk('public')->delete($prompt->profile_image);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $path;
        }

        // プロンプトの生成
        $validated['generated_prompt'] = $this->generatePrompt($validated);

        // プロンプトの更新
        $prompt->update($validated);

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'プロンプトが正常に更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prompt $prompt)
    {
        // 権限チェック
        $this->authorize('delete', $prompt);

        // プロフィール画像の削除
        if ($prompt->profile_image) {
            Storage::disk('public')->delete($prompt->profile_image);
        }

        // プロンプトの削除
        $prompt->delete();

        return redirect()->route('prompts.index')
            ->with('success', 'プロンプトが正常に削除されました。');
    }

    /**
     * プロンプトを生成する
     *
     * @param array $data
     * @return string
     */
    private function generatePrompt(array $data): string
    {
        // カラースキームの設定
        $colorSchemeDetails = $this->getColorSchemeDetails($data['color_scheme']);

        // フォントの設定
        $fontDetails = $this->getFontDetails($data['font']);

        // アニメーション効果の設定
        $animationDetails = '';
        if (!empty($data['animations'])) {
            $animationDetails = $this->getAnimationDetails($data['animations']);
        }

        // フレームワークの設定
        $frameworkDetails = $data['framework'] === 'tailwind' ? 'Tailwind CSS' : 'Bootstrap 4.5';

        // プロンプトテンプレート
        $prompt = <<<EOT
# ランディングページ作成プロンプト

## 基本情報
- タイトル: {$data['title']}
- コンセプト: {$data['concept']}
- 目的: {$data['purpose']}
- ターゲット: {$data['target']}

## デザイン設定
- カラースキーム: {$colorSchemeDetails}
- フレームワーク: {$frameworkDetails}
- フォント: {$fontDetails}
- アニメーション: {$animationDetails}

## プロフィール情報
{$data['profile']}

## CTAボタン
- テキスト: {$data['cta_button_text']}

## 要件
1. レスポンシブデザイン（スマートフォン、タブレット、デスクトップ対応）
2. SEO対策済みのHTML構造
3. 高速読み込みのための最適化
4. アクセシビリティ対応
5. モダンでクリーンなデザイン

## 出力形式
完全なHTMLファイル（CSS、JavaScriptを含む）
EOT;

        return $prompt;
    }

    /**
     * カラースキームの詳細を取得する
     *
     * @param string $scheme
     * @return string
     */
    private function getColorSchemeDetails(string $scheme): string
    {
        $schemes = [
            'blackboard' => 'メインカラー: #2C3E50, アクセントカラー: #E74C3C, #3498DB, ダークカラー: #1A252F, ライトカラー: #ECF0F1',
            'report' => 'メインカラー: #FFFFFF, アクセントカラー: #007BFF, #6C757D, ダークカラー: #343A40, ライトカラー: #F8F9FA',
            'modern' => 'メインカラー: #F5F5F5, アクセントカラー: #FF5722, #03A9F4, ダークカラー: #212121, ライトカラー: #FAFAFA',
            'nature' => 'メインカラー: #F1F8E9, アクセントカラー: #8BC34A, #4CAF50, ダークカラー: #33691E, ライトカラー: #DCEDC8',
            'tech' => 'メインカラー: #E0F7FA, アクセントカラー: #00BCD4, #607D8B, ダークカラー: #006064, ライトカラー: #B2EBF2',
            'creative' => 'メインカラー: #FFEBEE, アクセントカラー: #F44336, #9C27B0, ダークカラー: #B71C1C, ライトカラー: #FFCDD2',
            'elegant' => 'メインカラー: #212121, アクセントカラー: #FFC107, #9E9E9E, ダークカラー: #000000, ライトカラー: #F5F5F5',
            'minimal' => 'メインカラー: #FFFFFF, アクセントカラー: #000000, #757575, ダークカラー: #212121, ライトカラー: #FAFAFA',
        ];

        return $schemes[$scheme] ?? 'カスタム';
    }

    /**
     * フォントの詳細を取得する
     *
     * @param string $font
     * @return string
     */
    private function getFontDetails(string $font): string
    {
        $fonts = [
            'noto-sans-jp' => 'Noto Sans JP（ゴシック体）',
            'noto-serif-jp' => 'Noto Serif JP（明朝体）',
            'm-plus-1p' => 'M PLUS 1p（ゴシック体）',
            'kosugi-maru' => 'Kosugi Maru（丸ゴシック体）',
            'sawarabi-gothic' => 'Sawarabi Gothic（ゴシック体）',
            'sawarabi-mincho' => 'Sawarabi Mincho（明朝体）',
        ];

        return $fonts[$font] ?? 'カスタム';
    }

    /**
     * アニメーション効果の詳細を取得する
     *
     * @param array $animations
     * @return string
     */
    private function getAnimationDetails(array $animations): string
    {
        $effects = [];
        $animationMap = [
            'scroll' => 'スクロールアニメーション',
            'typewriter' => 'タイプライター効果',
            'particle' => 'パーティクルエフェクト',
        ];

        foreach ($animations as $animation) {
            if (isset($animationMap[$animation])) {
                $effects[] = $animationMap[$animation];
            }
        }

        return implode(', ', $effects);
    }
}
