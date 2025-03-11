@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>メトリクス一覧: {{ $landingPage->title }}</span>
                    <div>
                        <a href="{{ route('landing-pages.show', $landingPage->id) }}" class="btn btn-info btn-sm mr-2">LP詳細</a>
                        <a href="{{ route('landing-pages.index') }}" class="btn btn-secondary btn-sm">戻る</a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- メトリクスサマリー -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">メトリクスサマリー</h4>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">訪問者数</h5>
                                            <p class="card-text h3">{{ $metrics['total_visitors'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">平均読了率</h5>
                                            <p class="card-text h3">{{ number_format($metrics['avg_read_through_rate'] * 100, 1) }}%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">平均滞在時間</h5>
                                            <p class="card-text h3">{{ number_format($metrics['avg_time_spent']) }}秒</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">平均離脱位置</h5>
                                            <p class="card-text h3">{{ number_format($metrics['avg_exit_scroll_position']) }}px</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- デバイスタイプ別訪問者数 -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">デバイスタイプ別訪問者数</h4>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">デスクトップ</h5>
                                            <p class="card-text h3">{{ $metrics['device_types']['desktop'] }}</p>
                                            <p class="card-text">
                                                @if($metrics['total_visitors'] > 0)
                                                    {{ number_format(($metrics['device_types']['desktop'] / $metrics['total_visitors']) * 100, 1) }}%
                                                @else
                                                    0%
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">モバイル</h5>
                                            <p class="card-text h3">{{ $metrics['device_types']['mobile'] }}</p>
                                            <p class="card-text">
                                                @if($metrics['total_visitors'] > 0)
                                                    {{ number_format(($metrics['device_types']['mobile'] / $metrics['total_visitors']) * 100, 1) }}%
                                                @else
                                                    0%
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">タブレット</h5>
                                            <p class="card-text h3">{{ $metrics['device_types']['tablet'] }}</p>
                                            <p class="card-text">
                                                @if($metrics['total_visitors'] > 0)
                                                    {{ number_format(($metrics['device_types']['tablet'] / $metrics['total_visitors']) * 100, 1) }}%
                                                @else
                                                    0%
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">不明</h5>
                                            <p class="card-text h3">{{ $metrics['device_types']['unknown'] }}</p>
                                            <p class="card-text">
                                                @if($metrics['total_visitors'] > 0)
                                                    {{ number_format(($metrics['device_types']['unknown'] / $metrics['total_visitors']) * 100, 1) }}%
                                                @else
                                                    0%
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- デバイスタイプ別読了率 -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">デバイスタイプ別平均読了率</h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">デスクトップ</h5>
                                            <p class="card-text h3">{{ number_format($metrics['device_read_through_rates']['desktop'] * 100, 1) }}%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">モバイル</h5>
                                            <p class="card-text h3">{{ number_format($metrics['device_read_through_rates']['mobile'] * 100, 1) }}%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">タブレット</h5>
                                            <p class="card-text h3">{{ number_format($metrics['device_read_through_rates']['tablet'] * 100, 1) }}%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- スクロール深度 -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">スクロール深度</h4>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    25%: {{ $metrics['scroll_depth']['25%'] }}人
                                </div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    50%: {{ $metrics['scroll_depth']['50%'] }}人
                                </div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    75%: {{ $metrics['scroll_depth']['75%'] }}人
                                </div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    100%: {{ $metrics['scroll_depth']['100%'] }}人
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 日別データ -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">日別データ</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>日付</th>
                                            <th>訪問者数</th>
                                            <th>平均読了率</th>
                                            <th>平均滞在時間</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyMetrics as $metric)
                                            <tr>
                                                <td>{{ $metric->date }}</td>
                                                <td>{{ $metric->visitors }}</td>
                                                <td>{{ number_format($metric->read_through_rate * 100, 1) }}%</td>
                                                <td>{{ number_format($metric->time_spent) }}秒</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 他のLPとの比較 -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="mb-3">他のLPとの比較</h4>
                            <form action="{{ route('landing-pages.metrics.index', $landingPage->id) }}" method="GET" class="mb-4">
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <label for="compare_with">比較するLP:</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="compare_with" id="compare_with" class="form-control">
                                            <option value="">選択してください</option>
                                            @foreach (App\Models\LandingPage::where('id', '!=', $landingPage->id)->get() as $otherLP)
                                                <option value="{{ $otherLP->id }}" {{ request('compare_with') == $otherLP->id ? 'selected' : '' }}>
                                                    {{ $otherLP->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">比較</button>
                                    </div>
                                </div>
                            </form>

                            @if (request()->has('compare_with') && $comparisonLP = App\Models\LandingPage::find(request('compare_with')))
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>メトリクス</th>
                                                <th>{{ $landingPage->title }}</th>
                                                <th>{{ $comparisonLP->title }}</th>
                                                <th>差分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>訪問者数</td>
                                                <td>{{ $metrics['total_visitors'] }}</td>
                                                <td>{{ $comparisonLP->metrics()->distinct('visitor_id')->count('visitor_id') }}</td>
                                                <td>
                                                    @php
                                                        $diff = $metrics['total_visitors'] - $comparisonLP->metrics()->distinct('visitor_id')->count('visitor_id');
                                                        $diffClass = $diff > 0 ? 'text-success' : ($diff < 0 ? 'text-danger' : '');
                                                    @endphp
                                                    <span class="{{ $diffClass }}">{{ $diff > 0 ? '+' : '' }}{{ $diff }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>平均読了率</td>
                                                <td>{{ number_format($metrics['avg_read_through_rate'] * 100, 1) }}%</td>
                                                <td>{{ number_format($comparisonLP->metrics()->avg('read_through_rate') * 100, 1) }}%</td>
                                                <td>
                                                    @php
                                                        $diff = ($metrics['avg_read_through_rate'] - $comparisonLP->metrics()->avg('read_through_rate')) * 100;
                                                        $diffClass = $diff > 0 ? 'text-success' : ($diff < 0 ? 'text-danger' : '');
                                                    @endphp
                                                    <span class="{{ $diffClass }}">{{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }}%</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>平均滞在時間</td>
                                                <td>{{ number_format($metrics['avg_time_spent']) }}秒</td>
                                                <td>{{ number_format($comparisonLP->metrics()->avg('time_spent')) }}秒</td>
                                                <td>
                                                    @php
                                                        $diff = $metrics['avg_time_spent'] - $comparisonLP->metrics()->avg('time_spent');
                                                        $diffClass = $diff > 0 ? 'text-success' : ($diff < 0 ? 'text-danger' : '');
                                                    @endphp
                                                    <span class="{{ $diffClass }}">{{ $diff > 0 ? '+' : '' }}{{ number_format($diff) }}秒</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
