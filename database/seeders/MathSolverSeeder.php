<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MathLesson;

class MathSolverSeeder extends Seeder
{
    public function run(): void
    {
        $chapters = [
            [
                'chapter_no' => 1,
                'title' => 'বাস্তব সংখ্যা (Real Number)',
                'description' => 'বাস্তব সংখ্যার শ্রেণীবিভাগ, আবৃত্ত দশমিক, মূলদ ও অমূলদ সংখ্যা সম্পর্কিত ধারণা।'
            ],
            [
                'chapter_no' => 2,
                'title' => 'সেট ও ফাংশন (Set & Function)',
                'description' => 'সেটের প্রকাশ পদ্ধতি, সংযোগ ও ছেদ সেট, কার্তেসীয় গুণজ এবং ফাংশনের ডোমেন-রেঞ্জ।'
            ],
            [
                'chapter_no' => 3,
                'title' => 'বীজগাণিতিক রাশি (Algebraic Expression)',
                'description' => 'বর্গ ও ঘন সংবলিত সূত্রাবলী, উৎপাদকে বিশ্লেষণ এবং মান নির্ণয়।'
            ],
            [
                'chapter_no' => 4,
                'title' => 'সূচক ও লগারিদম (Exponents & Logarithms)',
                'description' => 'সূচকের সূত্রাবলী, লগারিদমের ভিত্তি ও বৈশিষ্ট্য এবং বৈজ্ঞানিক রূপে প্রকাশ।'
            ],
            [
                'chapter_no' => 5,
                'title' => 'এক চলকবিশিষ্ট সমীকরণ (Equation with One Variable)',
                'description' => 'সরল সমীকরণ গঠন ও সমাধান এবং বাস্তবভিত্তিক সমস্যার সমাধান।'
            ],
            [
                'chapter_no' => 6,
                'title' => 'রেখা, কোণ ও ত্রিভুজ (Lines, Angles & Triangles)',
                'description' => 'ইউক্লিডীয় জ্যামিতির মৌলিক ধারণা, কোণের প্রকারভেদ এবং ত্রিভুজ সংক্রান্ত উপপাদ্য।'
            ],
            [
                'chapter_no' => 7,
                'title' => 'ব্যবহারিক জ্যামিতি (Practical Geometry)',
                'description' => 'ত্রিভুজ ও চতুর্ভুজ অঙ্কন এবং বিভিন্ন সম্পাদ্য সমাধান।'
            ],
            [
                'chapter_no' => 8,
                'title' => 'বৃত্ত (Circle)',
                'description' => 'বৃত্তের কেন্দ্র, জ্যা, ব্যাস, স্পর্শক এবং বৃত্ত সংক্রান্ত উপপাদ্য ও সম্পাদ্য।'
            ],
            [
                'chapter_no' => 9,
                'title' => 'ত্রিকোণমিতিক অনুপাত (Trigonometric Ratio)',
                'description' => 'সূক্ষ্মকোণের ত্রিকোণমিতিক অনুপাত, অভেদাবলী এবং কোণসমূহের মান নির্ণয়।'
            ],
            [
                'chapter_no' => 10,
                'title' => 'দূরত্ব ও উচ্চতা (Distance & Height)',
                'description' => 'উন্নতি কোণ ও অবনতি কোণ ব্যবহার করে দূরত্ব ও উচ্চতা পরিমাপের বাস্তব সমস্যা।'
            ],
            [
                'chapter_no' => 11,
                'title' => 'বীজগাণিতিক অনুপাত ও সমানুপাত (Algebraic Ratio & Proportion)',
                'description' => 'অনুপাত ও সমানুপাতের রূপান্তর, যোজন-বিয়োজন এবং বাস্তব সমস্যার সমাধান।'
            ],
            [
                'chapter_no' => 12,
                'title' => 'দুই চলকবিশিষ্ট সরল সহসমীকরণ (Simple Simultaneous Equations)',
                'description' => 'প্রতিস্থাপন, অপনয়ন, আর গুণন এবং লেখচিত্রের সাহায্যে সহসমীকরণ সমাধান।'
            ],
            [
                'chapter_no' => 13,
                'title' => 'সসীম ধারা (Finite Series)',
                'description' => 'সমান্তর ধারা ও গুণোত্তর ধারার সাধারণ পদ এবং সমষ্টি নির্ণয়।'
            ],
            [
                'chapter_no' => 14,
                'title' => 'অনুপাত, সদৃশতা ও প্রতিসমতা (Ratio, Similarity & Symmetry)',
                'description' => 'জ্যামিতিক সদৃশতা, প্রতিসম রেখা এবং ঘূর্ণন প্রতিসমতা সংক্রান্ত আলোচনা।'
            ],
            [
                'chapter_no' => 15,
                'title' => 'क्षेत्रফল সম্পর্কিত উপপাদ্য ও সম্পাদ্য (Theorems Related to Area)',
                'description' => 'ত্রিভুজ ও চতুর্ভুজক্ষেত্রের ক্ষেত্রফল সংক্রান্ত জ্যামিতিক প্রমান ও অঙ্কন।'
            ],
            [
                'chapter_no' => 16,
                'title' => 'পরিমিতি (Mensuration)',
                'description' => 'ত্রিভুজ, চতুর্ভুজ, বৃত্ত এবং ঘনবস্তুর (সিলিন্ডার, গোলক, কোণক) ক্ষেত্রফল ও আয়তন পরিমাপ।'
            ],
            [
                'chapter_no' => 17,
                'title' => 'পরিসংখ্যান (Statistics)',
                'description' => 'গড়, মধ্যক, প্রচুরক নির্ণয় এবং অজিভ রেখা ও বহুভুজ অঙ্কন।'
            ]
        ];

        foreach ($chapters as $chapter) {
            MathLesson::updateOrCreate(
                ['chapter_no' => $chapter['chapter_no']],
                [
                    'title' => $chapter['title'],
                    'description' => $chapter['description'],
                    'is_active' => true
                ]
            );
        }
    }
}
