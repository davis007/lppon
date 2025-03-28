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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('template');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * マイグレーションのロールバック
     */
    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
};

