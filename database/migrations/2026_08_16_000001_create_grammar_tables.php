<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grammar_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('level_no');
            $table->string('level_name');
            $table->string('category'); // e.g. "LEVEL 1 — Class 3–4 Foundation"
            $table->longText('rule')->nullable();
            $table->longText('formula')->nullable();
            $table->longText('recognition')->nullable();
            $table->longText('step_1')->nullable();
            $table->longText('step_2')->nullable();
            $table->longText('step_3')->nullable();
            $table->longText('example')->nullable();
            $table->longText('common_mistake')->nullable();
            $table->longText('exam_answer_pattern')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('grammar_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('grammar_lessons')->onDelete('cascade');
            $table->longText('question');
            $table->longText('options'); // JSON array of options
            $table->string('correct_answer');
            $table->longText('explanation')->nullable();
            $table->timestamps();
        });

        Schema::create('grammar_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('grammar_lessons')->onDelete('cascade');
            $table->decimal('score', 8, 2)->default(0);
            $table->boolean('is_completed')->default(false);
            $table->longText('answers')->nullable(); // JSON array of user choices
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grammar_submissions');
        Schema::dropIfExists('grammar_exercises');
        Schema::dropIfExists('grammar_lessons');
    }
};
