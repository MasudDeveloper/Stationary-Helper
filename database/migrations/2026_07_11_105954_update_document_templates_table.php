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
        Schema::table('document_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('type');
            $table->string('language')->default('বাংলা')->after('category_id');
            $table->text('description')->nullable()->after('language');
            $table->integer('total_fields')->default(0)->after('content');
            $table->json('fields_data')->nullable()->after('total_fields');
            $table->boolean('is_active')->default(true)->after('fields_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_templates', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'language', 'description', 'total_fields', 'fields_data', 'is_active']);
        });
    }
};
