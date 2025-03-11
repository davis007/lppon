# Laravel 11 with boostrap4.5 laravel ui with Auth

Laravel11が上記タイトルが全てインストール済み
Viteを削除してBoostrap4.5に対応させているVerです。# laravel11_without_Vite_on_Boostrap4.5

LPseisei システムにおけるメトリクス計測の仕組み
LPseisei システムでは、HTMLコンテンツを登録した後、以下の方法でページ進度やクリックなどの計測が行われています：

計測の仕組み
JavaScriptによる自動計測：

公開されたLPページ（resources/views/landing-pages/public.blade.php）には、メトリクス計測用のJavaScriptが自動的に埋め込まれます
このJavaScriptは、ユーザーがページを閲覧する際に自動的に実行され、様々なデータを収集します
計測されるデータ：

訪問者情報：ランダムに生成された訪問者ID
デバイスタイプ：デスクトップ、モバイル、タブレットを自動検出
スクロール深度：25%、50%、75%、100%の各ポイントに達したかどうか
読了率：ページの最大スクロール位置 / 全体の高さ
滞在時間：ページに滞在した秒数
離脱スクロール位置：ユーザーがページを離れた時点でのスクロール位置
データ送信のタイミング：

スクロール深度到達時：25%、50%、75%、100%の各ポイントに達した時点でAPIにデータ送信
ページ離脱時：ユーザーがページを離れる際に、Beacon APIを使用して最終的なメトリクスデータを送信
APIエンドポイント：

個別メトリクス記録：/api/landing-page-metrics
最終メトリクス記録：/api/landing-page-metrics/final
データベース構造
メトリクスデータは landing_page_metrics テーブルに保存され、以下のフィールドが含まれます：

landing_page_id：関連するLPのID
visitor_id：訪問者の一意識別子
device_type：デバイスタイプ（desktop/mobile/tablet）
read_through_rate：読了率（0〜1の値）
scroll_depth_25/50/75/100：各スクロール深度に達したかどうか（boolean）
time_spent：滞在時間（秒）
exit_scroll_position：離脱時のスクロール位置（ピクセル）
管理画面での確認方法
収集されたデータは管理画面で以下のように確認できます：

メトリクス一覧：訪問者数、平均読了率、デバイスタイプ別の訪問者数、スクロール深度などの集計データ
メトリクス詳細：個別訪問者のデータ詳細（デバイスタイプ、読了率、スクロール深度、滞在時間など）
比較機能：他のLPとのパフォーマンス比較
このように、HTMLコンテンツを登録するだけで、自動的にJavaScriptが埋め込まれ、ユーザーの行動データが収集・分析できる仕組みになっています。
