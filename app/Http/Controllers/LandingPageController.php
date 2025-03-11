<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LandingPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 認証が必要なアクションを指定
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $landingPages = LandingPage::latest()->paginate(10);
        return view('landing-pages.index', compact('landingPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('landing-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_pages',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ]);

        // スラッグが指定されていない場合は、タイトルから自動生成
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $landingPage = LandingPage::create($validated);

        return redirect()->route('landing-pages.show', $landingPage)
            ->with('success', 'ランディングページが作成されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // URLがスラッグの場合（公開ページ用）
        if (!is_numeric($id)) {
            $landingPage = LandingPage::where('slug', $id)
                ->where('status', 'published')
                ->firstOrFail();

            return view('landing-pages.public', compact('landingPage'));
        }

        // IDの場合（管理画面用）
        $landingPage = LandingPage::findOrFail($id);
        return view('landing-pages.show', compact('landingPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $landingPage = LandingPage::findOrFail($id);
        return view('landing-pages.edit', compact('landingPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $landingPage = LandingPage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('landing_pages')->ignore($landingPage)],
            'description' => 'nullable|string',
            'content' => 'required|string',
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ]);

        // スラッグが指定されていない場合は、タイトルから自動生成
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $landingPage->update($validated);

        return redirect()->route('landing-pages.show', $landingPage)
            ->with('success', 'ランディングページが更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $landingPage = LandingPage::findOrFail($id);
        $landingPage->delete();

        return redirect()->route('landing-pages.index')
            ->with('success', 'ランディングページが削除されました。');
    }
}
