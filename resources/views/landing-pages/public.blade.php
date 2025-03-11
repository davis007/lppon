<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $landingPage->title }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            position: relative;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div id="lp-content">
        {!! $landingPage->content !!}
    </div>

    <!-- メトリクス計測用のJavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 訪問者IDの生成（実際のプロダクションでは、より堅牢な方法を使用すべき）
            const visitorId = 'visitor_' + Math.random().toString(36).substr(2, 9);

            // デバイスタイプの検出
            const deviceType = detectDeviceType();

            // デバイスタイプを検出する関数
            function detectDeviceType() {
                const userAgent = navigator.userAgent.toLowerCase();
                const width = window.innerWidth;

                // タブレットの検出
                if (/ipad|tablet|playbook|silk|(android(?!.*mobile))/i.test(userAgent) ||
                    (width >= 768 && width <= 1024)) {
                    return 'tablet';
                }

                // モバイルの検出
                if (/android|webos|iphone|ipod|blackberry|iemobile|opera mini/i.test(userAgent) ||
                    width < 768) {
                    return 'mobile';
                }

                // デフォルトはデスクトップ
                return 'desktop';
            }

            // ページの高さを取得
            const pageHeight = Math.max(
                document.body.scrollHeight,
                document.body.offsetHeight,
                document.documentElement.clientHeight,
                document.documentElement.scrollHeight,
                document.documentElement.offsetHeight
            ) - window.innerHeight;

            // スクロール深度のフラグ
            let scrollDepth25 = false;
            let scrollDepth50 = false;
            let scrollDepth75 = false;
            let scrollDepth100 = false;

            // 読了率（最大スクロール位置 / 全体の高さ）
            let maxScrollPosition = 0;

            // 滞在時間の計測
            const startTime = new Date().getTime();
            let timeSpent = 0;

            // スクロールイベントのリスナー
            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY;
                const scrollPercentage = (scrollPosition / pageHeight) * 100;

                // 最大スクロール位置の更新
                maxScrollPosition = Math.max(maxScrollPosition, scrollPosition);

                // スクロール深度の更新
                if (scrollPercentage >= 25 && !scrollDepth25) {
                    scrollDepth25 = true;
                    sendMetrics('scroll_depth_25');
                }

                if (scrollPercentage >= 50 && !scrollDepth50) {
                    scrollDepth50 = true;
                    sendMetrics('scroll_depth_50');
                }

                if (scrollPercentage >= 75 && !scrollDepth75) {
                    scrollDepth75 = true;
                    sendMetrics('scroll_depth_75');
                }

                if (scrollPercentage >= 100 && !scrollDepth100) {
                    scrollDepth100 = true;
                    sendMetrics('scroll_depth_100');
                }
            });

            // ページを離れる前のイベント
            window.addEventListener('beforeunload', function() {
                // 滞在時間の計算（秒）
                timeSpent = Math.floor((new Date().getTime() - startTime) / 1000);

                // 読了率の計算
                const readThroughRate = maxScrollPosition / pageHeight;

                // 最終メトリクスの送信
                sendFinalMetrics(readThroughRate, timeSpent, maxScrollPosition);
            });

            // スクロール深度メトリクスの送信
            function sendMetrics(metricType) {
                // CSRFトークンを取得
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('/api/landing-page-metrics', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        landing_page_id: {{ $landingPage->id }},
                        visitor_id: visitorId,
                        device_type: deviceType,
                        metric_type: metricType,
                        value: true
                    })
                }).catch(error => console.error('Error sending metrics:', error));
            }

            // 最終メトリクスの送信
            function sendFinalMetrics(readThroughRate, timeSpent, exitScrollPosition) {
                // CSRFトークンを取得
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // ビーコンAPIを使用してページ離脱時にもデータを送信できるようにする
                const data = {
                    landing_page_id: {{ $landingPage->id }},
                    visitor_id: visitorId,
                    device_type: deviceType,
                    read_through_rate: readThroughRate,
                    scroll_depth_25: scrollDepth25,
                    scroll_depth_50: scrollDepth50,
                    scroll_depth_75: scrollDepth75,
                    scroll_depth_100: scrollDepth100,
                    time_spent: timeSpent,
                    exit_scroll_position: exitScrollPosition
                };

                const blob = new Blob([JSON.stringify(data)], { type: 'application/json' });
                navigator.sendBeacon('/api/landing-page-metrics/final?_token=' + csrfToken, blob);
            }
        });
    </script>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
