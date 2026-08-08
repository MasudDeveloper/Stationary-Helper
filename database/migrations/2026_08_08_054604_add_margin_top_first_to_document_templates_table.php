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
            $table->decimal('margin_top_first', 8, 2)->nullable()->default(4.50)->after('page_orientation');
            $table->decimal('margin_top', 8, 2)->default(1.00)->change();
            $table->decimal('margin_bottom', 8, 2)->default(1.00)->change();
            $table->decimal('margin_left', 8, 2)->default(1.00)->change();
            $table->decimal('margin_right', 8, 2)->default(1.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_templates', function (Blueprint $table) {
            $table->dropColumn('margin_top_first');
            // Revert changes is optional, but for completeness:
            $table->integer('margin_top')->default(10)->change();
            $table->integer('margin_bottom')->default(20)->change();
            $table->integer('margin_left')->default(20)->change();
            $table->integer('margin_right')->default(20)->change();
        });
    }
};
