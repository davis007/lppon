<?php

use Illuminate\Support\Facades\Route;
use YourUsername\LandingPageManager\Http\Controllers\LandingPageController;
use YourUsername\LandingPageManager\Http\Controllers\LandingPageMetricController;
use YourUsername\LandingPageManager\Http\Controllers\LandingPageMetricApiController;

/*
|--------------------------------------------------------------------------
| ランディングページ管理ルート
|--------------------------------------------------------------------------
*/

// 管理画面ルート
Route::group([
    'prefix' => config('landing-page-manager.route_prefix', 'landing-page-manager'),
    'as' => 'landing-page-manager.',
    'middleware' => config('landing-page-manager.middleware.admin', ['web', 'auth']),
], function () {
    // ランディングページCRUD
    Route::resource('landing-pages', LandingPageController::class);
    
    // ランディングページメトリクス
    Route::get('landing-pages/{landing_page}/metrics', [LandingPageMetricController::class, 'index'])
        ->name('landing-pages.metrics.index');
    Route::get('landing-pages/{landing_page}/metrics/{metric}', [LandingPageMetricController::class, 'show'])
        ->name('landing-pages.metrics.show');
});

// API ルート
Route::group([
    'prefix' => 'api/'.config('landing-page-manager.route_prefix', 'landing-page-manager'),
    'as' => 'landing-page-manager.api.',
    'middleware' => config('landing-page-manager.middleware.api', ['api']),
], function () {
    // メトリクスAPI
    Route::post('metrics', [LandingPageMetricApiController::class, 'store'])
        ->name('metrics.store');
});

// 公開ランディングページルート
Route::group([
    'prefix' => config('landing-page-manager.public_route_prefix', 'lp'),
    'as' => 'landing-page-manager.landing-pages.public.',
    'middleware' => config('landing-page-manager.middleware.public', ['web']),
], function () {
    Route::get('{slug}', [LandingPageController::class, 'showPublic'])
        ->name('show');
});

