<?php

namespace David007\LandingPageManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use David007\LandingPageManager\Models\LandingPage;
use David007\LandingPageManager\Models\LandingPageMetric;

class LandingPageMetricController extends Controller
{
    /**
     * 指定されたランディングページのメトリクス一覧を表示
     *
     * @param  \David007\LandingPageManager\Models\LandingPage  $landingPage
     * @return \Illuminate\View\View
     */
    public function index(LandingPage $landingPage)
    {
        $metrics = $landingPage->metrics()->latest()->paginate(20);
        return view('landing-page-manager::landing-pages.metrics.index', compact('landingPage', 'metrics'));
    }

    /**
     * 指定されたランディングページの指定メトリクスの詳細を表示
     *
     * @param  \David007\LandingPageManager\Models\LandingPage  $landingPage
     * @param  \David007\LandingPageManager\Models\LandingPageMetric  $metric
     * @return \Illuminate\View\View
     */
    public function show(LandingPage $landingPage, LandingPageMetric $metric)
    {
        // メトリクスが指定したランディングページに属しているか確認
        if ($metric->landing_page_id !== $landingPage->id) {
            abort(404);
        }

        return view('landing-page-manager::landing-pages.metrics.show', compact('landingPage', 'metric'));
    }
}

