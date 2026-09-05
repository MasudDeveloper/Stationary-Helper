<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('chapter_no');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('accounting_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('accounting_lessons')->onDelete('cascade');
            $table->string('title');
            $table->longText('stimulus');
            $table->longText('answer_schema'); // JSON cast array containing items, accounts, debit/credit logic, etc.
            $table->timestamps();
        });

        Schema::create('accounting_student_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('accounting_exercises')->onDelete('cascade');
            $table->longText('submitted_answers'); // JSON cast array of student entries
            $table->boolean('is_correct')->default(false);
            $table->decimal('score', 8, 2)->default(0);
            $table->longText('feedback')->nullable(); // Explanations of mistakes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_student_submissions');
        Schema::dropIfExists('accounting_exercises');
        Schema::dropIfExists('accounting_lessons');
    }
};
