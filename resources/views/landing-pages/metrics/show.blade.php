@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>メトリクス詳細: {{ $landingPage->title }}</span>
                    <div>
                        <a href="{{ route('landing-pages.metrics.index', $landingPage->id) }}" class="btn btn-info btn-sm mr-2">メトリクス一覧</a>
                        <a href="{{ route('landing-pages.show', $landingPage->id) }}" class="btn btn-primary btn-sm mr-2">LP詳細</a>
                        <a href="{{ route('landing-pages.index') }}" class="btn btn-secondary btn-sm">戻る</a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- メトリクス詳細情報 -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">メトリクス詳細情報</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 200px;">ID</th>
                                            <td>{{ $metric->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>訪問者ID</th>
                                            <td>{{ $metric->visitor_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>デバイスタイプ</th>
                                            <td>
                                                @if ($metric->device_type == 'desktop')
                                                    <span class="badge badge-primary">デスクトップ</span>
                                                @elseif ($metric->device_type == 'mobile')
                                                    <span class="badge badge-success">モバイル</span>
                                                @elseif ($metric->device_type == 'tablet')
                                                    <span class="badge badge-info">タブレット</span>
                                                @else
                                                    <span class="badge badge-secondary">不明</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>読了率</th>
                                            <td>{{ number_format($metric->read_through_rate * 100, 1) }}%</td>
                                        </tr>
                                        <tr>
                                            <th>スクロール深度 25%</th>
                                            <td>
                                                @if ($metric->scroll_depth_25)
                                                    <span class="badge badge-success">達成</span>
                                                @else
                                                    <span class="badge badge-secondary">未達成</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>スクロール深度 50%</th>
                                            <td>
                                                @if ($metric->scroll_depth_50)
                                                    <span class="badge badge-success">達成</span>
                                                @else
                                                    <span class="badge badge-secondary">未達成</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>スクロール深度 75%</th>
                                            <td>
                                                @if ($metric->scroll_depth_75)
                                                    <span class="badge badge-success">達成</span>
                                                @else
                                                    <span class="badge badge-secondary">未達成</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>スクロール深度 100%</th>
                                            <td>
                                                @if ($metric->scroll_depth_100)
                                                    <span class="badge badge-success">達成</span>
                                                @else
                                                    <span class="badge badge-secondary">未達成</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>滞在時間</th>
                                            <td>{{ $metric->time_spent }}秒</td>
                                        </tr>
                                        <tr>
                                            <th>離脱スクロール位置</th>
                                            <td>{{ $metric->exit_scroll_position }}px</td>
                                        </tr>
                                        <tr>
                                            <th>記録日時</th>
                                            <td>{{ $metric->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 視覚化 -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">スクロール深度の視覚化</h4>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $metric->read_through_rate * 100 }}%;"
                                    aria-valuenow="{{ $metric->read_through_rate * 100 }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                    {{ number_format($metric->read_through_rate * 100, 1) }}%
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <div>0%</div>
                                <div>25%</div>
                                <div>50%</div>
                                <div>75%</div>
                                <div>100%</div>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                @for ($i = 0; $i <= 4; $i++)
                                    @php
                                        $depth = $i * 25;
                                        $depthReached = false;

                                        if ($depth == 0) {
                                            $depthReached = true;
                                        } elseif ($depth == 25 && $metric->scroll_depth_25) {
                                            $depthReached = true;
                                        } elseif ($depth == 50 && $metric->scroll_depth_50) {
                                            $depthReached = true;
                                        } elseif ($depth == 75 && $metric->scroll_depth_75) {
                                            $depthReached = true;
                                        } elseif ($depth == 100 && $metric->scroll_depth_100) {
                                            $depthReached = true;
                                        }
                                    @endphp

                                    <div>
                                        @if ($depthReached)
                                            <span class="badge badge-success">達成</span>
                                        @else
                                            <span class="badge badge-secondary">未達成</span>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- 比較データ -->
                    @if (isset($comparisonData))
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">比較データ: {{ $comparisonData['landing_page']->title }}</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>メトリクス</th>
                                                <th>{{ $landingPage->title }}</th>
                                                <th>{{ $comparisonData['landing_page']->title }}</th>
                                                <th>差分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>読了率</td>
                                                <td>{{ number_format($metric->read_through_rate * 100, 1) }}%</td>
                                                <td>{{ number_format($comparisonData['metrics']['avg_read_through_rate'] * 100, 1) }}%</td>
                                                <td>
                                                    @php
                                                        $diff = ($metric->read_through_rate - $comparisonData['metrics']['avg_read_through_rate']) * 100;
                                                        $diffClass = $diff > 0 ? 'text-success' : ($diff < 0 ? 'text-danger' : '');
                                                    @endphp
                                                    <span class="{{ $diffClass }}">{{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }}%</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>滞在時間</td>
                                                <td>{{ $metric->time_spent }}秒</td>
                                                <td>{{ number_format($comparisonData['metrics']['avg_time_spent']) }}秒</td>
                                                <td>
                                                    @php
                                                        $diff = $metric->time_spent - $comparisonData['metrics']['avg_time_spent'];
                                                        $diffClass = $diff > 0 ? 'text-success' : ($diff < 0 ? 'text-danger' : '');
                                                    @endphp
                                                    <span class="{{ $diffClass }}">{{ $diff > 0 ? '+' : '' }}{{ number_format($diff) }}秒</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>離脱スクロール位置</td>
                                                <td>{{ $metric->exit_scroll_position }}px</td>
                                                <td>{{ number_format($comparisonData['metrics']['avg_exit_scroll_position']) }}px</td>
                                                <td>
                                                    @php
                                                        $diff = $metric->exit_scroll_position - $comparisonData['metrics']['avg_exit_scroll_position'];
                                                        $diffClass = $diff > 0 ? 'text-success' : ($diff < 0 ? 'text-danger' : '');
                                                    @endphp
                                                    <span class="{{ $diffClass }}">{{ $diff > 0 ? '+' : '' }}{{ number_format($diff) }}px</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
