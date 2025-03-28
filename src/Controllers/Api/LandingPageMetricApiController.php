<?php

namespace YourUsername\LandingPageManager\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use YourUsername\LandingPageManager\Models\LandingPage;
use YourUsername\LandingPageManager\Models\LandingPageMetric;

class LandingPageMetricApiController extends Controller
{
    /**
     * メトリクスデータを格納する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'landing_page_id' => 'required|exists:landing_pages,id',
            'visitor_id' => 'required|string',
            'page_view_count' => 'integer',
            'visit_duration' => 'integer',
        ]);

        // 既存のメトリクスがあれば更新、なければ新規作成
        $metric = LandingPageMetric::updateOrCreate(
            [
                'landing_page_id' => $validated['landing_page_id'],
                'visitor_id' => $validated['visitor_id'],
            ],
            [
                'page_view_count' => $validated['page_view_count'] ?? 1,
                'visit_duration' => $validated['visit_duration'] ?? 0,
                'last_activity_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'メトリクスが記録されました',
            'data' => $metric
        ]);
    }

    /**
     * 最終的なメトリクスデータを格納する（コンバージョン含む）
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFinal(Request $request)
    {
        $validated = $request->validate([
            'landing_page_id' => 'required|exists:landing_pages,id',
            'visitor_id' => 'required|string',
            'page_view_count' => 'integer',
            'visit_duration' => 'integer',
            'is_converted' => 'boolean',
        ]);

        // 既存のメトリクスがあれば更新、なければ新規作成
        $metric = LandingPageMetric::updateOrCreate(
            [
                'landing_page_id' => $validated['landing_page_id'],
                'visitor_id' => $validated['visitor_id'],
            ],
            [
                'page_view_count' => $validated['page_view_count'] ?? 1,
                'visit_duration' => $validated['visit_duration'] ?? 0,
                'is_converted' => $validated['is_converted'] ?? false,
                'last_activity_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => '最終メトリクスが記録されました',
            'data' => $metric
        ]);
    }
}

