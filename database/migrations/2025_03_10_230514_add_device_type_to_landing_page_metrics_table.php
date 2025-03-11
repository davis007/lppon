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
        Schema::table('landing_page_metrics', function (Blueprint $table) {
            $table->string('device_type')->nullable()->after('visitor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_page_metrics', function (Blueprint $table) {
            $table->dropColumn('device_type');
        });
    }
};
