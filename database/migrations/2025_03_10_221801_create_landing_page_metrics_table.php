<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing_page_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->string('visitor_id');
            $table->float('read_through_rate')->default(0);
            $table->boolean('scroll_depth_25')->default(false);
            $table->boolean('scroll_depth_50')->default(false);
            $table->boolean('scroll_depth_75')->default(false);
            $table->boolean('scroll_depth_100')->default(false);
            $table->integer('time_spent')->default(0); // 滞在時間（秒）
            $table->integer('exit_scroll_position')->default(0); // 離脱時のスクロール位置（ピクセル）
            $table->timestamps();

            // インデックスを追加
            $table->index(['landing_page_id', 'visitor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_metrics');
    }
};
