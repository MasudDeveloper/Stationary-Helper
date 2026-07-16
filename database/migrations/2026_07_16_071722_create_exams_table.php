<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('subject')->nullable();
            $table->string('class')->nullable();
            $table->enum('type', ['mcq', 'cq'])->default('mcq');
            $table->integer('duration_minutes')->default(60);
            $table->boolean('status')->default(true); // true = active, false = closed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
