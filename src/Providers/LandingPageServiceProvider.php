<?php

namespace David007\LandingPageManager\Providers;

use Illuminate\Support\ServiceProvider;

class LandingPageServiceProvider extends ServiceProvider
{
    /**
     * パッケージのブートストラップ
     */
    public function boot()
    {
        // ルートの登録
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // ビューの登録
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'landing-page-manager');

        // マイグレーションの登録
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // アセットの公開設定
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/landing-page-manager'),
        ], 'landing-page-manager-views');

        $this->publishes([
            __DIR__ . '/../config/landing-page-manager.php' => config_path('landing-page-manager.php'),
        ], 'landing-page-manager-config');
    }

    /**
     * パッケージのサービス登録
     */
    public function register()
    {
        // 設定ファイルのマージ
        $this->mergeConfigFrom(
            __DIR__ . '/../config/landing-page-manager.php', 'landing-page-manager'
        );
    }
}

