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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('concept');
            $table->text('purpose');
            $table->string('target');
            $table->string('profile_image')->nullable();
            $table->text('profile');
            $table->string('cta_button_text');
            $table->string('color_scheme');
            $table->string('framework');
            $table->string('font');
            $table->json('animations')->nullable();
            $table->text('generated_prompt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
