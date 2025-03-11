<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LandingPageMetricController;
use App\Http\Controllers\Api\LandingPageMetricApiController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// 管理者用ルート（認証が必要）
Route::middleware(['auth'])->group(function () {
    // LP管理
    Route::resource('landing-pages', LandingPageController::class);

    // LPメトリクス管理
    Route::get('landing-pages/{landing_page}/metrics', [LandingPageMetricController::class, 'index'])
        ->name('landing-pages.metrics.index');
    Route::get('landing-pages/{landing_page}/metrics/{metric}', [LandingPageMetricController::class, 'show'])
        ->name('landing-pages.metrics.show');
});

// 公開されたLPを表示するためのルート（認証不要）
Route::get('lp/{slug}', [LandingPageController::class, 'show'])
    ->name('landing-pages.public.show');

// メトリクス収集用APIルート（CSRF保護を無効化）
Route::post('api/landing-page-metrics', [LandingPageMetricApiController::class, 'store']);
Route::post('api/landing-page-metrics/final', [LandingPageMetricApiController::class, 'storeFinal']);
