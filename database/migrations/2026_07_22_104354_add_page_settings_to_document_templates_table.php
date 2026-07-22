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
            $table->string('page_size')->default('a4')->after('credit_cost');
            $table->string('page_orientation')->default('portrait')->after('page_size');
            $table->integer('margin_top')->default(10)->after('page_orientation');
            $table->integer('margin_bottom')->default(20)->after('margin_top');
            $table->integer('margin_left')->default(20)->after('margin_bottom');
            $table->integer('margin_right')->default(20)->after('margin_left');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_templates', function (Blueprint $table) {
            $table->dropColumn([
                'page_size', 'page_orientation', 
                'margin_top', 'margin_bottom', 
                'margin_left', 'margin_right'
            ]);
        });
    }
};
