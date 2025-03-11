<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\LandingPageMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingPageMetricApiController extends Controller
{
    /**
     * スクロール深度などの個別のメトリクスを記録
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'landing_page_id' => 'required|exists:landing_pages,id',
            'visitor_id' => 'required|string',
            'device_type' => 'nullable|string|in:desktop,mobile,tablet',
            'metric_type' => 'required|string|in:scroll_depth_25,scroll_depth_50,scroll_depth_75,scroll_depth_100',
            'value' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 既存のメトリクスレコードを検索または新規作成
        $metric = LandingPageMetric::firstOrNew([
            'landing_page_id' => $request->landing_page_id,
            'visitor_id' => $request->visitor_id,
        ]);

        // デバイスタイプを設定（初回のみ）
        if (!$metric->device_type && $request->has('device_type')) {
            $metric->device_type = $request->device_type;
        }

        // メトリクスタイプに基づいてフィールドを更新
        $metric->{$request->metric_type} = $request->value;
        $metric->save();

        return response()->json(['success' => true]);
    }

    /**
     * ページ離脱時に最終的なメトリクスを記録
     */
    public function storeFinal(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($data ?? [], [
            'landing_page_id' => 'required|exists:landing_pages,id',
            'visitor_id' => 'required|string',
            'device_type' => 'nullable|string|in:desktop,mobile,tablet',
            'read_through_rate' => 'required|numeric|min:0|max:1',
            'scroll_depth_25' => 'required|boolean',
            'scroll_depth_50' => 'required|boolean',
            'scroll_depth_75' => 'required|boolean',
            'scroll_depth_100' => 'required|boolean',
            'time_spent' => 'required|integer|min:0',
            'exit_scroll_position' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 既存のメトリクスレコードを検索または新規作成
        $metric = LandingPageMetric::firstOrNew([
            'landing_page_id' => $data['landing_page_id'],
            'visitor_id' => $data['visitor_id'],
        ]);

        // 全てのフィールドを更新
        $metric->read_through_rate = $data['read_through_rate'];
        $metric->scroll_depth_25 = $data['scroll_depth_25'];
        $metric->scroll_depth_50 = $data['scroll_depth_50'];
        $metric->scroll_depth_75 = $data['scroll_depth_75'];
        $metric->scroll_depth_100 = $data['scroll_depth_100'];
        $metric->time_spent = $data['time_spent'];
        $metric->exit_scroll_position = $data['exit_scroll_position'];

        // デバイスタイプを設定（初回のみ）
        if (!$metric->device_type && isset($data['device_type'])) {
            $metric->device_type = $data['device_type'];
        }

        $metric->save();

        return response()->json(['success' => true]);
    }
}
