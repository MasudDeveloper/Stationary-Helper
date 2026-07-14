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
        Schema::create('daily_cash_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('note_1000')->default(0);
            $table->integer('note_500')->default(0);
            $table->integer('note_200')->default(0);
            $table->integer('note_100')->default(0);
            $table->integer('note_50')->default(0);
            $table->integer('note_20')->default(0);
            $table->integer('note_10')->default(0);
            $table->integer('note_5')->default(0);
            $table->integer('note_2')->default(0);
            $table->integer('note_1')->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_cash_records');
    }
};
