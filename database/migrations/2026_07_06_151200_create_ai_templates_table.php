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
        Schema::create('ai_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('thumbnail_path');
            $table->text('prompt')->nullable();
            $table->json('inputs_schema')->nullable(); // fields configuration
            $table->json('overlay_settings')->nullable(); // positioning coordinates
            $table->boolean('is_premium')->default(false);
            $table->decimal('credits_cost', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_templates');
    }
};
