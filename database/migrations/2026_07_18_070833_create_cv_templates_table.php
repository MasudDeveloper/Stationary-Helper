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
        Schema::create('cv_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('language')->default('en'); // en, bn
            $table->string('format')->nullable(); // 1-page, 2-page, normal
            $table->string('design_name')->nullable();
            $table->longText('content')->nullable();
            $table->integer('total_fields')->default(0);
            $table->json('fields_data')->nullable();
            $table->integer('credit_cost')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_templates');
    }
};
