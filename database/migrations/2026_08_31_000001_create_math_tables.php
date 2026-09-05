<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('math_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('chapter_no');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('math_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('math_lessons')->onDelete('cascade');
            $table->string('title');
            $table->longText('question');
            $table->longText('options')->nullable(); // JSON array of options for multiple choice
            $table->string('correct_answer');
            $table->longText('explanation')->nullable();
            $table->timestamps();
        });

        Schema::create('math_student_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('math_lessons')->onDelete('cascade');
            $table->decimal('score', 8, 2)->default(0);
            $table->boolean('is_completed')->default(false);
            $table->longText('answers')->nullable(); // JSON array of student answers
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('math_student_submissions');
        Schema::dropIfExists('math_exercises');
        Schema::dropIfExists('math_lessons');
    }
};
