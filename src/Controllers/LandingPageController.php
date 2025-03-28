<?php

namespace Davis007\LandingPageManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Davis007\LandingPageManager\Models\LandingPage;

class LandingPageController extends Controller
{
    /**
     * ランディングページ一覧を表示
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $landingPages = LandingPage::latest()->paginate(10);
        return view('landing-page-manager::landing-pages.index', compact('landingPages'));
    }

    /**
     * ランディングページ作成フォームを表示
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('landing-page-manager::landing-pages.create');
    }

    /**
     * ランディングページを保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_pages',
            'description' => 'nullable|string',
            'template' => 'required|string',
            'is_published' => 'boolean',
        ]);

        LandingPage::create($validated);

        return redirect()->route('landing-page-manager.landing-pages.index')
            ->with('success', 'ランディングページが作成されました。');
    }

    /**
     * ランディングページの詳細を表示
     *
     * @param  \Davis007\LandingPageManager\Models\LandingPage  $landingPage
     * @return \Illuminate\View\View
     */
    public function show(LandingPage $landingPage)
    {
        return view('landing-page-manager::landing-pages.show', compact('landingPage'));
    }

    /**
     * ランディングページ編集フォームを表示
     *
     * @param  \Davis007\LandingPageManager\Models\LandingPage  $landingPage
     * @return \Illuminate\View\View
     */
    public function edit(LandingPage $landingPage)
    {
        return view('landing-page-manager::landing-pages.edit', compact('landingPage'));
    }

    /**
     * ランディングページを更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Davis007\LandingPageManager\Models\LandingPage  $landingPage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, LandingPage $landingPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_pages,slug,' . $landingPage->id,
            'description' => 'nullable|string',
            'template' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $landingPage->update($validated);

        return redirect()->route('landing-page-manager.landing-pages.index')
            ->with('success', 'ランディングページが更新されました。');
    }

    /**
     * ランディングページを削除
     *
     * @param  \Davis007\LandingPageManager\Models\LandingPage  $landingPage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LandingPage $landingPage)
    {
        $landingPage->delete();

        return redirect()->route('landing-page-manager.landing-pages.index')
            ->with('success', 'ランディングページが削除されました。');
    }

    /**
     * 公開ランディングページを表示
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function showPublic(string $slug)
    {
        $landingPage = LandingPage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('landing-page-manager::landing-pages.public', compact('landingPage'));
    }
}

