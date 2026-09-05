<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MathLesson;
use App\Models\MathExercise;

class SetFunctionSeeder extends Seeder
{
    public function run(): void
    {
        $lesson = MathLesson::where('chapter_no', 2)->first();

        if (!$lesson) {
            $lesson = MathLesson::create([
                'chapter_no' => 2,
                'title' => 'সেট ও ফাংশন (Set & Function)',
                'description' => 'সেটের প্রকাশ পদ্ধতি, সংযোগ ও ছেদ সেট, কার্তেসীয় গুণজ এবং ফাংশনের ডোমেন-রেঞ্জ।',
                'is_active' => true,
            ]);
        }

        // Delete previous exercises for chapter 2 to re-seed cleanly
        MathExercise::where('lesson_id', $lesson->id)->delete();

        for ($i = 1; $i <= 100; $i++) {
            $type = ($i - 1) % 5;
            $params = [
                'id' => $i,
                's1' => 'A',
                's2' => 'B',
                'fn' => 'f',
                'vr' => 'x',
            ];

            if ($type === 0) {
                $params['p'] = 'P1';
                $params['aLim'] = 11;
                $params['b1'] = 9;
                $params['b2'] = 130;
                $params['c1'] = 3;
                $params['c2'] = 1;
                $params['c3'] = 3;
                $params['c4'] = -1;
                $title = "সৃজনশীল প্রশ্ন নং {$i} (প্যাটার্ন ১: মৌলিক সংখ্যা ও ভগ্নাংশ ফাংশন)";
            } elseif ($type === 1) {
                $params['p'] = 'P2';
                $params['s1'] = 'P';
                $params['s2'] = 'Q';
                $params['fn'] = 'g';
                $params['vr'] = 'y';
                $params['uLim'] = 10;
                $params['p1'] = 12;
                $params['q1'] = 3;
                $params['q2'] = 9;
                $title = "সৃজনশীল প্রশ্ন নং {$i} (প্যাটার্ন ২: গুণনীয়ক, গুণিতক ও এক-এক ফাংশন)";
            } elseif ($type === 2) {
                $params['p'] = 'P3';
                $params['s1'] = 'S';
                $params['s2'] = 'A';
                $params['fn'] = 'F';
                $params['kRel'] = 2;
                $params['fA'] = 1;
                $params['fB'] = 5;
                $params['fC'] = -3;
                $title = "সৃজনশীল প্রশ্ন নং {$i} (প্যাটার্ন ৩: ক্রমজোড় অন্বয় ও বহুপদী ফাংশন)";
            } elseif ($type === 3) {
                $params['p'] = 'P4';
                $params['fn'] = 'f';
                $params['c1'] = 2;
                $params['c2'] = 3;
                $params['c3'] = 2;
                $params['c4'] = -1;
                $params['sqLim'] = 4;
                $params['gn'] = 6;
                $title = "সৃজনশীল প্রশ্ন নং {$i} (প্যাটার্ন ৪: সেট গঠন পদ্ধতি ও শক্তি সেট)";
            } else {
                $params['p'] = 'P5';
                $params['fn'] = 'g';
                $params['vr'] = 't';
                $params['kVal'] = 1;
                $params['tPow'] = 3;
                $title = "সৃজনশীল প্রশ্ন নং {$i} (প্যাটার্ন ৫: ভেনচিত্র ও পাওয়ার ফাংশন)";
            }

            MathExercise::create([
                'lesson_id' => $lesson->id,
                'title' => $title,
                'question' => "প্যাটার্ন: {$params['p']}",
                'options' => $params, // Stores full parameter dictionary in JSON options
                'correct_answer' => 'অটো সমাধান সক্রিয়',
                'explanation' => 'ডাইনামিক সূত্র দ্বারা স্বয়ংক্রিয় সমাধান নির্ণয় করা হবে।',
            ]);
        }
    }
}
