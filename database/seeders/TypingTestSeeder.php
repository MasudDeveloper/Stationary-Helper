<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypingTestParagraph;

class TypingTestSeeder extends Seeder
{
    public function run()
    {
        $paragraphs = [
            // Bangla
            [
                'title' => 'বাংলা বেসিক ১ - সুন্দর প্রকৃতি',
                'language' => 'Bangla',
                'content' => 'আমাদের দেশ বাংলাদেশ। এ দেশের প্রকৃতি অনেক সুন্দর। চারদিকে সবুজের সমারোহ এবং নদীর স্রোত আমাদের মন ভরিয়ে দেয়। আমরা আমাদের দেশকে অনেক ভালোবাসি এবং এর উন্নতি চাই।',
                'is_active' => true,
            ],
            [
                'title' => 'বাংলা বেসিক ২ - পরিশ্রমের ফল',
                'language' => 'Bangla',
                'content' => 'জীবনে সফল হতে হলে কঠোর পরিশ্রম করতে হয়। যারা অলসতা করে সময় নষ্ট করে তারা কখনোই কাঙ্ক্ষিত লক্ষ্যে পৌঁছাতে পারে না। তাই আমাদের উচিত সময়মতো নিজের কাজগুলো সম্পন্ন করা।',
                'is_active' => true,
            ],
            [
                'title' => 'বাংলা বেসিক ৩ - বিজ্ঞান ও প্রযুক্তি',
                'language' => 'Bangla',
                'content' => 'বর্তমান যুগ হলো বিজ্ঞান ও প্রযুক্তির যুগ। প্রতিদিন নতুন নতুন প্রযুক্তি আবিষ্কার হচ্ছে এবং আমাদের জীবনযাত্রা আগের চেয়ে অনেক সহজ হয়ে উঠেছে। প্রযুক্তির সঠিক ব্যবহার আমাদের আরও এগিয়ে নিয়ে যাবে।',
                'is_active' => true,
            ],
            [
                'title' => 'বাংলা বেসিক ৪ - শিক্ষাই শক্তি',
                'language' => 'Bangla',
                'content' => 'শিক্ষা মানুষের সবচেয়ে বড় শক্তি। এটি শুধু আমাদের জ্ঞানই বৃদ্ধি করে না, বরং সমাজের ভালো ও মন্দের পার্থক্য বুঝতে সাহায্য করে। তাই প্রতিটি মানুষের জন্যই শিক্ষা অর্জন করা অপরিহার্য।',
                'is_active' => true,
            ],
            [
                'title' => 'বাংলা বেসিক ৫ - সুস্থ শরীর',
                'language' => 'Bangla',
                'content' => 'সুস্থ শরীর একটি অমূল্য সম্পদ। নিয়মিত ব্যায়াম এবং পুষ্টিকর খাবার খাওয়ার মাধ্যমে আমরা আমাদের শরীরকে সুস্থ রাখতে পারি। সুস্বাস্থ্যের অধিকারী মানুষ জীবনে যেকোনো কাজ অনেক সহজেই করতে পারে।',
                'is_active' => true,
            ],
            
            // English
            [
                'title' => 'English Basic 1 - Quick Brown Fox',
                'language' => 'English',
                'content' => 'The quick brown fox jumps over the lazy dog. This is a very common sentence used to test typing speed because it contains all the letters of the English alphabet.',
                'is_active' => true,
            ],
            [
                'title' => 'English Basic 2 - Morning Walk',
                'language' => 'English',
                'content' => 'A morning walk is a very good exercise. It keeps our mind fresh and our body healthy. Waking up early in the morning and taking a long walk helps you to stay active throughout the entire day.',
                'is_active' => true,
            ],
            [
                'title' => 'English Basic 3 - Importance of Time',
                'language' => 'English',
                'content' => 'Time is very valuable. Once it is gone, it never comes back. Successful people always understand the value of time and they manage their daily tasks very efficiently.',
                'is_active' => true,
            ],
            [
                'title' => 'English Basic 4 - Modern Technology',
                'language' => 'English',
                'content' => 'Modern technology has changed the way we live and communicate. The internet has made the world a global village. We can now easily connect with people who are thousands of miles away.',
                'is_active' => true,
            ],
            [
                'title' => 'English Basic 5 - Reading Books',
                'language' => 'English',
                'content' => 'Reading books is a great habit. It expands our knowledge, improves our vocabulary, and enhances our imagination. Books are like windows to entirely new worlds.',
                'is_active' => true,
            ],
        ];

        foreach ($paragraphs as $paragraph) {
            TypingTestParagraph::create($paragraph);
        }
    }
}
