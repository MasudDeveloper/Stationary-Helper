<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MathExercise;
use App\Models\MathLesson;
use Illuminate\Support\Facades\DB;

class AlgebraSeeder extends Seeder
{
    public function run(): void
    {
        $lesson = MathLesson::firstOrCreate(
            ['id' => 3],
            [
                'chapter_no' => 3,
                'title' => 'বীজগাণিতিক রাশি (Algebraic Expression)',
                'description' => 'বর্গ, ঘন, উৎপাদকে বিশ্লেষণ ও বীজগাণিতিক মান নির্ণয় সমাধান।'
            ]
        );

        // Delete existing exercises for lesson 3 to ensure sequential numbering
        MathExercise::where('lesson_id', $lesson->id)->delete();

        for ($i = 1; $i <= 50; $i++) {
            $mod = ($i - 1) % 5;
            $pattern = 'P' . ($mod + 1);
            $options = [];

            if ($pattern === 'P1') {
                $options = ['p' => 'P1', 'k' => 3 + ($i % 4)];
            } elseif ($pattern === 'P2') {
                $options = ['p' => 'P2', 'k' => 3 + ($i % 3)];
            } elseif ($pattern === 'P3') {
                $options = ['p' => 'P3', 'a' => 4 + ($i % 3), 'b' => 6];
            } elseif ($pattern === 'P4') {
                $options = ['p' => 'P4', 'coeffA' => 3, 'coeffB' => 11, 'coeffC' => -4];
            } else {
                $options = ['p' => 'P5', 'k' => 4 + ($i % 3)];
            }

            MathExercise::create([
                'lesson_id' => $lesson->id,
                'title' => "বীজগণিত সৃজনশীল প্রশ্ন নং: {$i}",
                'question' => "পরামিতিক প্রশ্ন - উদ্দীপক ও মান অনুযায়ী সমাধান নির্ণয় করা হবে।",
                'options' => $options,
                'correct_answer' => 'অটো সমাধান সক্রিয়',
                'explanation' => 'ডাইনামিক বীজগাণিতিক সূত্র ব্যবহার করে ধাপে ধাপে গাণিতিক সমাধান নির্ণয় করা হবে।'
            ]);
        }

        $this->command->info('Algebra (Chapter 3) seeded 50 exercises successfully!');
    }
}
