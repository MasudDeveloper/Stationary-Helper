<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountingLesson;
use App\Models\AccountingExercise;

class AccountingSolverSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Chapters/Lessons
        $ch2 = AccountingLesson::updateOrCreate(
            ['chapter_no' => 2],
            ['title' => 'লেনদেন (Transaction)', 'description' => 'লেনদেন চিহ্নিতকরণ এবং হিসাব সমীকরণে প্রভাব বিশ্লেষণ।']
        );

        $ch5 = AccountingLesson::updateOrCreate(
            ['chapter_no' => 5],
            ['title' => 'হিসাব (Account)', 'description' => 'হিসাবের বিভিন্ন শ্রেণীবিভাগ ও ডেবিট-ক্রেডিট নির্ণয়ের নিয়মাবলী।']
        );

        $ch6 = AccountingLesson::updateOrCreate(
            ['chapter_no' => 6],
            ['title' => 'জাবেদা (Journal)', 'description' => 'লেনদেনসমূহকে প্রাথমিক হিসাবের বই বা সাধারণ জাবেদায় লিপিবদ্ধকরণ।']
        );

        $ch9 = AccountingLesson::updateOrCreate(
            ['chapter_no' => 9],
            ['title' => 'রেওয়ামিল (Trial Balance)', 'description' => 'খতিয়ানের উদ্বৃত্তগুলো নিয়ে গাণিতিক শুদ্ধতা যাচাইকরণ।']
        );

        // 2. Exercises for Chapter 2
        AccountingExercise::create([
            'lesson_id' => $ch2->id,
            'title' => 'হিসাব সমীকরণ প্রভাব যাচাই',
            'stimulus' => '<p class="text-white mb-2">মি. রহমানের কারবারে ২০১৬ সালের জানুয়ারি মাসে নিম্নলিখিত ঘটনাগুলো সংঘটিত হয়েছে:</p>
                           <ul class="text-slate-300 list-disc pl-5 space-y-1">
                               <li>জানুয়ারি ১: ৫০,০০০ টাকা নগদ মূলধন নিয়ে ব্যবসা শুরু করলেন।</li>
                               <li>জানুয়ারি ৫: ধারে পণ্য ক্রয় ১০,০০০ টাকা।</li>
                           </ul>',
            'answer_schema' => [
                [
                    'account' => 'নগদান হিসাব',
                    'nature' => 'Asset',
                    'type' => 'Dr',
                    'amount' => 50000
                ],
                [
                    'account' => 'মূলধন হিসাব',
                    'nature' => 'Equity',
                    'type' => 'Cr',
                    'amount' => 50000
                ],
                [
                    'account' => 'ক্রয় হিসাব',
                    'nature' => 'Expense',
                    'type' => 'Dr',
                    'amount' => 10000
                ],
                [
                    'account' => 'পাওনাদার হিসাব',
                    'nature' => 'Liability',
                    'type' => 'Cr',
                    'amount' => 10000
                ]
            ]
        ]);

        // Exercises for Chapter 6
        AccountingExercise::create([
            'lesson_id' => $ch6->id,
            'title' => 'সাধারণ জাবেদা দাখিলা',
            'stimulus' => '<p class="text-white mb-2">নিন্মোক্ত লেনদেনগুলোর জাবেদা দাখিলা দিন:</p>
                           <ul class="text-slate-300 list-disc pl-5 space-y-1">
                               <li>১. কর্মচারীকে বেতন প্রদান করা হলো ৫,০০০ টাকা।</li>
                               <li>২. নগদে পণ্য বিক্রয় করা হলো ১৫,০০০ টাকা।</li>
                           </ul>',
            'answer_schema' => [
                [
                    'account' => 'বেতন হিসাব',
                    'nature' => 'Expense',
                    'type' => 'Dr',
                    'amount' => 5000
                ],
                [
                    'account' => 'নগদান হিসাব',
                    'nature' => 'Asset',
                    'type' => 'Cr',
                    'amount' => 5000
                ],
                [
                    'account' => 'নগদান হিসাব',
                    'nature' => 'Asset',
                    'type' => 'Dr',
                    'amount' => 15000
                ],
                [
                    'account' => 'বিক্রয় হিসাব',
                    'nature' => 'Revenue',
                    'type' => 'Cr',
                    'amount' => 15000
                ]
            ]
        ]);
    }
}
