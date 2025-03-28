<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションの実行
     */
    public function up()
    {
        Schema::create('landing_page_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->string('visitor_id');
            $table->integer('page_view_count')->default(1);
            $table->integer('visit_duration')->default(0);
            $table->boolean('is_converted')->default(false);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            // 同じランディングページと訪問者IDの組み合わせは一意にする
            $table->unique(['landing_page_id', 'visitor_id']);
        });
    }

    /**
     * マイグレーションのロールバック
     */
    public function down()
    {
        Schema::dropIfExists('landing_page_metrics');
    }
};

