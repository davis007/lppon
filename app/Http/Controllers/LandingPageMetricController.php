<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\LandingPageMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageMetricController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $landing_page_id)
    {
        $landingPage = LandingPage::findOrFail($landing_page_id);

        // メトリクスの集計データを取得
        $metrics = [
            'total_visitors' => $landingPage->metrics()->distinct('visitor_id')->count('visitor_id'),
            'avg_read_through_rate' => $landingPage->metrics()->avg('read_through_rate'),
            'scroll_depth' => [
                '25%' => $landingPage->metrics()->where('scroll_depth_25', true)->count(),
                '50%' => $landingPage->metrics()->where('scroll_depth_50', true)->count(),
                '75%' => $landingPage->metrics()->where('scroll_depth_75', true)->count(),
                '100%' => $landingPage->metrics()->where('scroll_depth_100', true)->count(),
            ],
            'avg_time_spent' => $landingPage->metrics()->avg('time_spent'),
            'avg_exit_scroll_position' => $landingPage->metrics()->avg('exit_scroll_position'),
            // デバイスタイプ別の訪問者数
            'device_types' => [
                'desktop' => $landingPage->metrics()->where('device_type', 'desktop')->distinct('visitor_id')->count('visitor_id'),
                'mobile' => $landingPage->metrics()->where('device_type', 'mobile')->distinct('visitor_id')->count('visitor_id'),
                'tablet' => $landingPage->metrics()->where('device_type', 'tablet')->distinct('visitor_id')->count('visitor_id'),
                'unknown' => $landingPage->metrics()->whereNull('device_type')->distinct('visitor_id')->count('visitor_id'),
            ],
            // デバイスタイプ別の平均読了率
            'device_read_through_rates' => [
                'desktop' => $landingPage->metrics()->where('device_type', 'desktop')->avg('read_through_rate'),
                'mobile' => $landingPage->metrics()->where('device_type', 'mobile')->avg('read_through_rate'),
                'tablet' => $landingPage->metrics()->where('device_type', 'tablet')->avg('read_through_rate'),
            ],
        ];

        // 日別のデータを取得
        $dailyMetrics = $landingPage->metrics()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(DISTINCT visitor_id) as visitors'),
                DB::raw('AVG(read_through_rate) as read_through_rate'),
                DB::raw('AVG(time_spent) as time_spent')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('landing-pages.metrics.index', compact('landingPage', 'metrics', 'dailyMetrics'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $landing_page_id, string $metric_id)
    {
        $landingPage = LandingPage::findOrFail($landing_page_id);
        $metric = LandingPageMetric::findOrFail($metric_id);

        // 比較用のデータを取得（オプション）
        $comparisonData = null;
        if (request()->has('compare_with')) {
            $compareWithId = request()->input('compare_with');
            $compareLandingPage = LandingPage::findOrFail($compareWithId);

            $comparisonData = [
                'landing_page' => $compareLandingPage,
                'metrics' => [
                    'total_visitors' => $compareLandingPage->metrics()->distinct('visitor_id')->count('visitor_id'),
                    'avg_read_through_rate' => $compareLandingPage->metrics()->avg('read_through_rate'),
                    'scroll_depth' => [
                        '25%' => $compareLandingPage->metrics()->where('scroll_depth_25', true)->count(),
                        '50%' => $compareLandingPage->metrics()->where('scroll_depth_50', true)->count(),
                        '75%' => $compareLandingPage->metrics()->where('scroll_depth_75', true)->count(),
                        '100%' => $compareLandingPage->metrics()->where('scroll_depth_100', true)->count(),
                    ],
                    'avg_time_spent' => $compareLandingPage->metrics()->avg('time_spent'),
                    'avg_exit_scroll_position' => $compareLandingPage->metrics()->avg('exit_scroll_position'),
                    // デバイスタイプ別の訪問者数
                    'device_types' => [
                        'desktop' => $compareLandingPage->metrics()->where('device_type', 'desktop')->distinct('visitor_id')->count('visitor_id'),
                        'mobile' => $compareLandingPage->metrics()->where('device_type', 'mobile')->distinct('visitor_id')->count('visitor_id'),
                        'tablet' => $compareLandingPage->metrics()->where('device_type', 'tablet')->distinct('visitor_id')->count('visitor_id'),
                        'unknown' => $compareLandingPage->metrics()->whereNull('device_type')->distinct('visitor_id')->count('visitor_id'),
                    ],
                ],
            ];
        }

        return view('landing-pages.metrics.show', compact('landingPage', 'metric', 'comparisonData'));
    }
}
