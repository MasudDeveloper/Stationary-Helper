<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MathExercise;
use App\Models\MathLesson;

class GeometrySeeder extends Seeder
{
    public function run(): void
    {
        $lesson = MathLesson::firstOrCreate(
            ['chapter_no' => 6],
            [
                'title' => 'জ্যামিতি ও পরিমিতি (Geometry & Mensuration)',
                'description' => 'কোণ, ত্রিভুজ, চতুর্ভুজ, বৃত্ত, ঘনবস্তু এবং ত্রিকোণমিতিক চিত্র ও সমাধান।'
            ]
        );

        // Delete existing exercises for geometry lesson to ensure clean 100 questions
        MathExercise::where('lesson_id', $lesson->id)->delete();

        $patterns = [
            'P1' => 'রেখা, কোণ ও পূরক-সম্পূরক কোণ',
            'P2' => 'ত্রিভুজ ও পিথাগোরাসের উপপাদ্য',
            'P3' => 'চতুর্ভুজ, সামান্তরিক ও ট্রাপিজিয়াম',
            'P4' => 'বৃত্ত, বৃত্তচাপ ও স্পর্শক',
            'P5' => 'ঘনবস্তু, সিলিন্ডার ও গোলক (3D Geometry)'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $mod = ($i - 1) % 5;
            $pKey = 'P' . ($mod + 1);

            $options = [];
            if ($pKey === 'P1') {
                $options = ['p' => 'P1', 'angle' => 30 + ($i * 3) % 120];
            } elseif ($pKey === 'P2') {
                $options = ['p' => 'P2', 'sideA' => 3 + ($i % 5), 'sideB' => 4 + ($i % 4)];
            } elseif ($pKey === 'P3') {
                $options = ['p' => 'P3', 'length' => 8 + ($i % 6), 'width' => 5 + ($i % 4)];
            } elseif ($pKey === 'P4') {
                $options = ['p' => 'P4', 'radius' => 7 + ($i % 7)];
            } else {
                $options = ['p' => 'P5', 'r' => 5 + ($i % 5), 'h' => 10 + ($i % 8)];
            }

            MathExercise::create([
                'lesson_id' => $lesson->id,
                'title' => "জ্যামিতি সৃজনশীল প্রশ্ন নং: {$i}",
                'question' => "পরামিতিক জ্যামিতিক প্রশ্ন - উদ্দীপক ও চিত্র অনুযায়ী সমাধান নির্ণয় করা হবে।",
                'options' => $options,
                'correct_answer' => 'অটো সমাধান সক্রিয়',
                'explanation' => 'জ্যামিতিক সূত্র ও চিত্র বিশ্লেষণ করে ধাপে ধাপে গাণিতিক উত্তর বের করা হবে।'
            ]);
        }

        $this->command->info('Geometry (Chapter 6) seeded 100 exercises successfully!');
    }
}
