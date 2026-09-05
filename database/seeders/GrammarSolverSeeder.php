<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarLesson;
use App\Models\GrammarExercise;

class GrammarSolverSeeder extends Seeder
{
    public function run(): void
    {
        // Level 1: Parts of Speech (Basic)
        $l1 = GrammarLesson::updateOrCreate(
            ['level_no' => 1],
            [
                'level_name' => 'Parts of Speech — Basic Foundation',
                'category' => 'LEVEL 1 — Class 3–4 Foundation',
                'rule' => 'Sentence-এ ব্যবহৃত প্রতিটি অর্থপূর্ণ শব্দকে এক একটি Parts of Speech বলে। এটি ৮ প্রকার: Noun (বিশেষ্য), Pronoun (সর্বনাম), Adjective (বিশেষণ), Verb (ক্রিয়া), Adverb (ক্রিয়া বিশেষণ), Preposition (পদান্বয়ী অব্যয়), Conjunction (সংযোজক অব্যয়), Interjection (আবেগসূচক অব্যয়)।',
                'formula' => 'Word in Context = Specific Part of Speech (যেমন: Water is life - এখানে Water হলো Noun; Water the plants - এখানে Water হলো Verb)',
                'recognition' => 'শব্দের কাজ দেখে চিনতে হবে। নাম বোঝালে Noun, নামের পরিবর্তে বসলে Pronoun, দোষ/গুণ/অবস্থা বোঝালে Adjective, কাজ করা বোঝালে Verb।',
                'step_1' => 'প্রথমে Sentence-এর প্রতিটি শব্দের নিচে দাগ দিন।',
                'step_2' => 'শব্দটি দ্বারা কোনো কিছুর নাম, কাজ, গুণ নাকি সংযোগ বোঝাচ্ছে তা নির্ণয় করুন।',
                'step_3' => 'চিহ্নিত করার নিয়ম অনুযায়ী নির্দিষ্ট Parts of Speech-এর নাম নির্ধারণ করুন।',
                'example' => 'Sentence: "Rahim is a good boy." এখানে রহিম হলো Noun, is হলো Verb, good হলো Adjective, boy হলো Noun।',
                'common_mistake' => 'ভুল: Fast-কে সবসময় Adverb ভাবা। রহিম runs fast-এ fast হলো Adverb, কিন্তু রহিম ইজ এ fast runner-এ fast হলো Adjective।',
                'exam_answer_pattern' => 'পরীক্ষায় সাধারণত আন্ডারলাইন করা শব্দটির Parts of Speech সনাক্ত করতে বলা হয়। উত্তর লেখার সময় ছক কেটে একদিকে Word এবং অন্যদিকে Parts of Speech লিখবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l1->id,
            'question' => 'Identify the underlined word: "He runs <span class="underline">fast</span> in the field."',
            'options' => ['Noun', 'Verb', 'Adjective', 'Adverb'],
            'correct_answer' => 'Adverb',
            'explanation' => 'এখানে runs (ক্রিয়া) কীভাবে সম্পন্ন হচ্ছে তা fast দ্বারা নির্দেশ করা হয়েছে, তাই এটি Adverb।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l1->id,
            'question' => 'Which part of speech is the word "honesty"?',
            'options' => ['Noun', 'Adjective', 'Adverb', 'Abstract Noun'],
            'correct_answer' => 'Abstract Noun',
            'explanation' => 'Honesty (সততা) একটি গুণের নাম, যা ধরা বা ছোঁয়া যায় না, তাই এটি Abstract Noun।'
        ]);

        // Level 2: Articles
        $l2 = GrammarLesson::updateOrCreate(
            ['level_no' => 13],
            [
                'level_name' => 'Article (A, An, The) Complete',
                'category' => 'LEVEL 7 — Article Complete',
                'rule' => 'A, An এবং The-কে Article বলে। Article প্রধানত ২ প্রকার: Indefinite (A, An) ও Definite (The)। অনির্দিষ্ট ব্যক্তি/বস্তুর পূর্বে A/An বসে, নির্দিষ্ট করে বোঝালে The বসে।',
                'formula' => 'Consonant Sound = A; Vowel Sound = An; Unique/Definite Object = The',
                'recognition' => 'শব্দের প্রথম অক্ষরের উচ্চারণ বা Sound দেখে চিনতে হবে। যেমন: U-এর উচ্চারণ যদি "ইউ" (Yew) এর মতো হয় তবে A বসবে, আর "আ" (Uh) হলে An বসবে।',
                'step_1' => 'যে শূন্যস্থানের পূর্বে Article বসাতে হবে তার পরের শব্দটির প্রথম অক্ষর ও উচ্চারণ লক্ষ্য করুন।',
                'step_2' => 'শব্দটি নির্দিষ্ট কোনো মহাজাগতিক বস্তু, নদী, মহাসাগর, নাকি অনির্দিষ্ট কোনো সাধারণ বস্তু তা নির্ধারণ করুন।',
                'step_3' => 'উচ্চারণের সাউন্ড (ভাওয়েল/কনসোনেন্ট) অনুযায়ী A, An, The অথবা কোনো Article না বসলে Cross (x) বসান।',
                'example' => 'He is a university student. (U-এর উচ্চারণ ইউ)। She ate an apple. (A-এর উচ্চারণ ভাওয়েল)। The Padma is a big river. (Padma নির্দিষ্ট নদী)।',
                'common_mistake' => 'ভুল: "an university" লেখা। university-র প্রথম অক্ষর U (vowel) হলেও উচ্চারণ "ইউ" হওয়ায় এর পূর্বে "a" বসবে, "an" নয়।',
                'exam_answer_pattern' => 'পরীক্ষায় সাধারণত শূন্যস্থান পূরণ আকারে আসে। উত্তরপত্রে শুধুমাত্র ক্রমিক নম্বর (a, b, c...) দিয়ে Article (a/an/the/x) লিখতে হবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l2->id,
            'question' => 'Fill in the blank: "He is ______ honest man."',
            'options' => ['a', 'an', 'the', 'x (no article)'],
            'correct_answer' => 'an',
            'explanation' => 'Honest শব্দের H অনুচ্চারিত থাকে এবং এর উচ্চারণ ভাওয়েল sound (অ-নেস্ট) এর মতো শুরু হয়, তাই এর পূর্বে "an" বসবে।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l2->id,
            'question' => 'Fill in the blank: "______ Pacific Ocean is the deepest ocean."',
            'options' => ['A', 'An', 'The', 'x'],
            'correct_answer' => 'The',
            'explanation' => 'মহাসাগর (Pacific Ocean) নির্দিষ্ট এবং অনন্য ভৌগলিক নাম হওয়ায় এর পূর্বে "The" বসবে।'
        ]);

        // Level 3: Tense Intro
        $l3 = GrammarLesson::updateOrCreate(
            ['level_no' => 21],
            [
                'level_name' => 'Tense - Present & Structures',
                'category' => 'LEVEL 4 — TENSE Complete',
                'rule' => 'ক্রিয়া সম্পন্ন হওয়ার সময়কে Tense (কাল) বলে। প্রধানত ৩ প্রকার: Present, Past, Future। প্রতিটি আবার ৪ ভাগে বিভক্ত। Present Indefinite: বর্তমানের সাধারণ কাজ, চিরন্তন সত্য বা অভ্যাসগত কাজ। Present Continuous: বর্তমানে কোনো কাজ চলছে। Present Perfect: কোনো কাজ এইমাত্র শেষ হয়েছে কিন্তু তার ফল এখনও আছে।',
                'formula' => 'Present Indefinite: Sub + V1 (s/es for 3rd Person Singular) + Obj. Present Continuous: Sub + am/is/are + V-ing + Obj. Present Perfect: Sub + have/has + V3 + Obj.',
                'recognition' => 'Sentence-এ ব্যবহৃত auxiliary verb এবং verb-এর রূপ দেখে টেন্স চিনতে হবে। এছাড়া signal words (যেমন: now, daily, already, just now) দেখেও চেনা যায়।',
                'step_1' => 'প্রথমে Sentence-এর প্রধান Verb এবং Auxiliary Verb চিহ্নিত করুন।',
                'step_2' => 'Verb-এর রূপটি V1 (present), V2 (past), V3 (past participle) নাকি V-ing তা নির্ধারণ করুন।',
                'step_3' => 'টেন্সের গঠন প্রণালী বা ফর্মুলা মিলিয়ে সঠিক টেন্সের নাম নির্ধারণ করুন।',
                'example' => 'He goes to school. (Present Indefinite - Third-person singular goes). We are learning English. (Present Continuous - am/is/are + V-ing).',
                'common_mistake' => 'ভুল: He go to school বা He is go to school লেখা। Present Indefinite-এ He singular হওয়ায় "goes" হবে, আর Continuous-এ "is going" হবে।',
                'exam_answer_pattern' => 'পরীক্ষায় ব্র্যাকেটের verb-এর সঠিক রূপ লিখতে অথবা বাক্যটির টেন্স পরিবর্তন করতে বলা হয়। উত্তর লেখার সময় বাক্যটির সঠিক রূপটি পরিষ্কারভাবে লিখবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l3->id,
            'question' => 'Identify the tense: "She has already finished her homework."',
            'options' => ['Present Simple', 'Present Continuous', 'Present Perfect', 'Present Perfect Continuous'],
            'correct_answer' => 'Present Perfect',
            'explanation' => 'গঠন প্রণালী: Sub + has + V3 (finished) থাকায় এটি Present Perfect Tense।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l3->id,
            'question' => 'Which is the correct formula for Present Continuous Tense?',
            'options' => [
                'Subject + V1 + Object',
                'Subject + was/were + V-ing + Object',
                'Subject + am/is/are + V-ing + Object',
                'Subject + have/has + V3 + Object'
            ],
            'correct_answer' => 'Subject + am/is/are + V-ing + Object',
            'explanation' => 'Present Continuous Tense-এর গঠন প্রণালী হলো Subject + am/is/are + V-ing + Object।'
        ]);

        // Level 4: Subject-Verb Agreement
        $l4 = GrammarLesson::updateOrCreate(
            ['level_no' => 29],
            [
                'level_name' => 'Subject-Verb Agreement',
                'category' => 'LEVEL 6 — Subject-Verb Agreement',
                'rule' => 'Subject-এর Number (বচন) এবং Person (পুরুষ) অনুযায়ী Verb নির্ধারণ করাকে Subject-Verb Agreement বলে। Subject যদি Singular হয়, Verb-ও Singular হবে। Subject যদি Plural হয়, Verb-ও Plural হবে।',
                'formula' => 'Singular Subject = Singular Verb (He plays); Plural Subject = Plural Verb (They play)',
                'recognition' => 'বাক্যের সাবজেক্টটি একবচন (singular) নাকি বহুবচন (plural) তা দেখে Verb-এর সঠিক রূপ নির্ধারণ করতে হবে।',
                'step_1' => 'প্রথমে বাক্যের মূল সাবজেক্টটি খুঁজে বের করুন (প্রয়োজনে relative clause বাদ দিন)।',
                'step_2' => 'সাবজেক্টটি Singular নাকি Plural তা পরীক্ষা করুন (মনে রাখবেন "One of", "Either...or" ইত্যাদির বিশেষ নিয়ম রয়েছে)।',
                'step_3' => 'সাবজেক্টের বচন ও পুরুষ অনুযায়ী সঠিক Helping Verb অথবা Main Verb-এর শেষে s/es যুক্ত বা মুক্ত করুন।',
                'example' => 'The color of his eyes is blue. (Subject হলো "The color", যা Singular, তাই "is" হয়েছে, "eyes"-এর জন্য "are" হবে না)।',
                'common_mistake' => 'ভুল: "One of my friends are a doctor" লেখা। এখানে "One" হলো মূল সাবজেক্ট, তাই Verb হবে "is" (friend-দের মধ্যে একজন)।',
                'exam_answer_pattern' => 'পরীক্ষায় সাধারণত Right Form of Verbs-এর অংশ হিসেবে আসে। সাবজেক্ট চিহ্নিত করে সঠিক Verb-টি খাতায় লিখবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l4->id,
            'question' => 'Choose the correct sentence:',
            'options' => [
                'Either Rahim or his brothers is coming.',
                'Either Rahim or his brothers are coming.',
                'Either Rahim or his brothers has come.',
                'Either Rahim or his brothers was coming.'
            ],
            'correct_answer' => 'Either Rahim or his brothers are coming.',
            'explanation' => 'Either...or দ্বারা যুক্ত সাবজেক্টের ক্ষেত্রে verb-এর নিকটবর্তী সাবজেক্ট অনুযায়ী verb নির্ধারিত হয়। এখানে নিকটবর্তী "brothers" বহুবচন হওয়ায় "are" হবে।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l4->id,
            'question' => 'Fill in the blank: "The quality of these mangoes ______ good."',
            'options' => ['are', 'is', 'were', 'have'],
            'correct_answer' => 'is',
            'explanation' => 'এখানে মূল সাবজেক্ট হলো "The quality" (Singular), "mangoes" নয়। তাই singular verb "is" বসবে।'
        ]);

        // Level 5: Voice Change
        $l5 = GrammarLesson::updateOrCreate(
            ['level_no' => 46],
            [
                'level_name' => 'Voice Change Structures',
                'category' => 'LEVEL 12 — Voice',
                'rule' => 'কর্তা নিজে কাজটি করে নাকি কর্তার ওপর কাজের ফল এসে পড়ে তা প্রকাশ করার পদ্ধতিকে Voice বলে। এটি ২ প্রকার: Active (কর্তা সক্রিয়) ও Passive (কর্ম প্রধান)।',
                'formula' => 'Active: Sub + Verb + Obj -> Passive: Active-এর Obj + Be-verb + V3 + by + Active-এর Sub',
                'recognition' => 'Active বাক্যে কর্তা সরাসরি কাজটি করে। Passive বাক্যে am/is/are/was/were/be/been/being + V3 থাকে এবং সাধারণত কাজের পরে "by + Object" থাকে।',
                'step_1' => 'Active বাক্যের Subject, Verb এবং Object চিহ্নিত করুন।',
                'step_2' => 'Active-এর Object-কে Passive-এর Subject করুন এবং Tense ও Subject অনুযায়ী auxiliary be-verb বসান।',
                'step_3' => 'Main verb-এর Past Participle (V3) রূপ বসিয়ে তারপর "by" যোগে Active-এর Subject-কে Object হিসেবে লিখুন।',
                'example' => 'Active: He writes a letter. -> Passive: A letter is written by him.',
                'common_mistake' => 'ভুল: Passive করার সময় Be-verb ভুলে যাওয়া। যেমন: "A letter written by him" লেখা (সঠিক: "is written")।',
                'exam_answer_pattern' => 'পরীক্ষায় ব্র্যাকেটে (Passive) বা (Active) নির্দেশ দেওয়া থাকে। রূপান্তরিত বাক্যটি সম্পূর্ণ নির্ভুল বানানে উত্তরপত্রে লিখবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l5->id,
            'question' => 'Change into passive: "We play football."',
            'options' => [
                'Football played by us.',
                'Football is play by us.',
                'Football is played by us.',
                'Football has been played by us.'
            ],
            'correct_answer' => 'Football is played by us.',
            'explanation' => 'Present Simple Tense-এর passive গঠন: Obj + am/is/are + V3 + by + Sub। তাই "Football is played by us" সঠিক।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l5->id,
            'question' => 'Change into passive: "Who has broken the glass?"',
            'options' => [
                'By whom has the glass broken?',
                'By whom has the glass been broken?',
                'Who has been broken the glass?',
                'By whom was the glass broken?'
            ],
            'correct_answer' => 'By whom has the glass been broken?',
            'explanation' => 'Who-এর পরিবর্তে By whom বসে। Present Perfect Tense-এর passive-এ have/has been বসে। তাই সঠিক বাক্য: By whom has the glass been broken?'
        ]);

        // Level 6: Preposition (Basic & Appropriate)
        $l6 = GrammarLesson::updateOrCreate(
            ['level_no' => 34],
            [
                'level_name' => 'Preposition & Appropriate Prepositions',
                'category' => 'LEVEL 8 — Preposition Complete',
                'rule' => 'যেসব শব্দ Noun বা Pronoun-এর পূর্বে বসে বাক্যের অন্য শব্দের সাথে সম্পর্ক স্থাপন করে তাদের Preposition বলে। কিছু বিশেষ শব্দের পর নির্দিষ্ট preposition বসে, একে Appropriate Preposition বলে।',
                'formula' => 'Preposition + Noun/Pronoun/V-ing (যেমন: good at, interested in, fond of, afraid of)',
                'recognition' => 'শব্দগুলোর অর্থ এবং স্থানকাল চিহ্নিত করে Preposition বসাতে হয়। যেমন: ছোট জায়গার পূর্বে at, বড় জায়গার পূর্বে in বসে। কোনো নির্দিষ্ট বিষয়ের দক্ষতায় good at বসে।',
                'step_1' => 'শূন্যস্থানের আগের শব্দ এবং পরের শব্দটির মধ্যকার সম্পর্ক লক্ষ্য করুন।',
                'step_2' => 'এটি কোনো স্থান, সময়, অভিমুখ নাকি কোনো নির্দিষ্ট Appropriate Preposition-এর নিয়মকে নির্দেশ করছে তা ভাবুন।',
                'step_3' => 'নিয়ম মিলিয়ে সঠিক Preposition-টি বসান।',
                'example' => 'I live at Mirpur in Dhaka. (Mirpur ছোট জায়গা, Dhaka বড় শহর)। He is fond of sweets. (fond-এর পর of বসে)।',
                'common_mistake' => 'ভুল: "good in English" বলা। ইংরেজিতে দক্ষ বোঝাতে "good at English" বলতে হবে, "good in" নয়।',
                'exam_answer_pattern' => 'পরীক্ষায় উপযুক্ত Preposition দিয়ে শূন্যস্থান পূরণ করতে বলা হয়। উত্তরপত্রে শুধু নম্বর দিয়ে সঠিক Preposition শব্দটি লিখতে হবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l6->id,
            'question' => 'Fill in the blank: "She is very good ______ drawing."',
            'options' => ['in', 'at', 'with', 'for'],
            'correct_answer' => 'at',
            'explanation' => 'কোনো বিষয়ে দক্ষতা বোঝাতে "good at" Appropriate Preposition বসে।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l6->id,
            'question' => 'Fill in the blank: "He has been suffering ______ fever since Sunday."',
            'options' => ['with', 'by', 'from', 'in'],
            'correct_answer' => 'from',
            'explanation' => 'রোগ বা কষ্টে ভোগা বোঝাতে "suffer from" ব্যবহৃত হয়।'
        ]);

        // Level 7: Right Form of Verbs
        $l7 = GrammarLesson::updateOrCreate(
            ['level_no' => 50],
            [
                'level_name' => 'Right Form of Verb Rules',
                'category' => 'LEVEL 14 — Right Form of Verb',
                'rule' => 'Sentence-এর অর্থ ও ব্যাকরণগত কাঠামোকে শুদ্ধ করার জন্য Verb-এর সঠিক রূপ ব্যবহার করার নিয়মকে Right Form of Verb বলে। এটি টেন্স, মোডাল, ভয়েস এবং সাবজেক্ট-ভার্ব এগ্রিমেন্টের ওপর নির্ভর করে।',
                'formula' => 'Modal + V1; Preposition + V-ing (except to); have/has/had + V3; had better/would rather + V1',
                'recognition' => 'Sentence-এ কিছু signal words থাকে। যেমন: yesterday, ago থাকলে V2 (Past Simple) হবে। always, daily থাকলে V1 (Present Simple) হবে। just, already থাকলে Present Perfect হবে।',
                'step_1' => 'Sentence-এর কাল (Tense) এবং সাবজেক্ট-ভার্ব রিলেশন চিহ্নিত করুন।',
                'step_2' => 'ব্র্যাকেটের Verb-টির পূর্বে কোনো Modal, Preposition, Passive trigger অথবা Auxiliary verb আছে কিনা তা লক্ষ্য করুন।',
                'step_3' => 'নির্দিষ্ট রুল বা ফর্মুলা মিলিয়ে Verb-টির সঠিক রূপান্তর (V1, V2, V3, V-ing, s/es) খাতায় লিখুন।',
                'example' => 'I saw him running. (saw-এর পর ২য় verb running হয়েছে)। You had better leave now. (had better-এর পর V1 leave বসেছে)।',
                'common_mistake' => 'ভুল: "To goes to school" বা "to playing" লেখা। সাধারণত "to"-এর পর verb-এর base form (V1) বসে, V-ing নয় (ব্যতিক্রম: with a view to, look forward to)।',
                'exam_answer_pattern' => 'পরীক্ষায় সাধারণত একটি অনুচ্ছেদ বা আলাদা বাক্য দেওয়া থাকে এবং ব্র্যাকেটে Verb থাকে। উত্তরপত্রে ক্রমিক নম্বর অনুযায়ী শুধু রূপান্তরিত Verb রূপটি লিখতে হবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l7->id,
            'question' => 'Provide the correct form of verb: "It has been ______ (rain) since morning."',
            'options' => ['rained', 'rains', 'raining', 'rain'],
            'correct_answer' => 'raining',
            'explanation' => 'Present Perfect Continuous Tense-এর গঠন অনুযায়ী have/has been + V-ing বসে। তাই raining হবে।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l7->id,
            'question' => 'Provide the correct form of verb: "He went to the library with a view to ______ (read) books."',
            'options' => ['read', 'reads', 'reading', 'to read'],
            'correct_answer' => 'reading',
            'explanation' => 'সাধারণত "to"-এর পর V1 বসে, কিন্তু "with a view to"-এর পর verb-এর সাথে "ing" যুক্ত হয়। তাই reading সঠিক।'
        ]);

        // Level 8: Completing Sentence
        $l8 = GrammarLesson::updateOrCreate(
            ['level_no' => 51],
            [
                'level_name' => 'Completing Sentence Structures',
                'category' => 'LEVEL 15 — Completing Sentence',
                'rule' => 'অসম্পূর্ণ বাক্যকে নির্দিষ্ট ব্যাকরণগত কাঠামো এবং অর্থপূর্ণ শব্দসমষ্টি দিয়ে পূর্ণ করার নিয়মকে Completing Sentence বলে। এর কিছু বহুল ব্যবহৃত কাঠামো হলো: so that, lest, it is high time, though/although, as if, too...to, conditionals।',
                'formula' => 'Lest + Subject + should + V1; It is high time + Subject + V2; So that + Sub + can/could + V1',
                'recognition' => 'বাক্যের প্রথম অংশে সংযোগকারী অব্যয় বা ক্লাজটি (যেমন: lest, so that, conditional if) দেখে এর গঠন চিনতে হবে।',
                'step_1' => 'অসম্পূর্ণ বাক্যের দেওয়া অংশটুকু পড়ুন এবং সংযোগকারী শব্দটির (যেমন: lest, as if) নির্দিষ্ট স্ট্রাকচার মনে করুন।',
                'step_2' => 'অর্থ বজায় রেখে পরবর্তী অংশের জন্য একটি উপযুক্ত বিষয় বা ধারণা মনে মনে ঠিক করুন।',
                'step_3' => 'ব্যাকরণের সঠিক ফর্মুলা (যেমন: should + V1 বা V2) মেনে বাক্যটি খাতায় সম্পূর্ণ করে লিখুন এবং নতুন অংশে আন্ডারলাইন করুন।',
                'example' => 'Walk fast lest you should miss the train. (lest-এর পর Sub + should + V1 বসেছে)। It is high time we studied hard. (It is high time-এর পর Sub + V2 বসেছে)।',
                'common_mistake' => 'ভুল: "lest you will miss" লেখা। lest-এর পর সবসময় "should" বা "might" ব্যবহার করতে হবে, will বা can নয়।',
                'exam_answer_pattern' => 'পরীক্ষায় প্রশ্নের অসম্পূর্ণ বাক্যটি সম্পূর্ণ করে লিখতে হবে। সম্পূর্ণ বাক্যটি লিখে যে অংশটুকু তুমি নিজে যুক্ত করেছ, তার নিচে দাগ (underline) দিয়ে দেবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l8->id,
            'question' => 'Complete the sentence: "Run fast lest ______."',
            'options' => [
                'you will miss the bus',
                'you should miss the bus',
                'you can miss the bus',
                'you would have missed the bus'
            ],
            'correct_answer' => 'you should miss the bus',
            'explanation' => 'Lest-এর নিয়ম অনুযায়ী পরবর্তী অংশে Subject + should + V1 বসাতে হবে। তাই "you should miss the bus" সঠিক।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l8->id,
            'question' => 'Complete the sentence: "It is high time we ______ our habits."',
            'options' => ['change', 'changed', 'should change', 'will change'],
            'correct_answer' => 'changed',
            'explanation' => '"It is high time" এর পরে Subject থাকলে verb-এর Past Simple (V2) রূপ বসে। তাই changed বসবে।'
        ]);

        // Level 9: Tag Question
        $l9 = GrammarLesson::updateOrCreate(
            ['level_no' => 53],
            [
                'level_name' => 'Tag Question shortcuts',
                'category' => 'LEVEL 17 — Tag Question',
                'rule' => 'কথোপকথনের সময় শ্রোতার সম্মতি বা সত্যতা যাচাই করার জন্য বাক্যের শেষে যে সংক্ষিপ্ত প্রশ্ন জুড়ে দেওয়া হয়, তাকে Tag Question বলে। মূল বাক্যটি Positive হলে tag হবে Negative, এবং মূল বাক্যটি Negative হলে tag হবে Positive।',
                'formula' => 'Positive Statement -> Negative Tag (isn\'t he? / don\'t they?); Negative Statement -> Positive Tag (is he? / do they?)',
                'recognition' => 'বাক্যের auxiliary verb এবং subject দেখে ট্যাগ চেনা যায়। auxiliary verb না থাকলে tense অনুযায়ী do/does/did বসাতে হয়। Subject-এর প্রোনাউন রূপ ব্যবহার করতে হয়।',
                'step_1' => 'মূল বাক্যের Subject এবং Auxiliary Verb (সাহায্যকারী ক্রিয়া) খুঁজে বের করুন।',
                'step_2' => 'বাক্যটি হ্যাঁ-বোধক নাকি না-বোধক তা লক্ষ্য করুন (হার্ডলি, নোবডি, নেভার থাকলে বাক্যটি না-বোধক)।',
                'step_3' => 'সাহায্যকারী ক্রিয়ার সাথে n\'t যুক্ত বা মুক্ত করুন এবং সাবজেক্টটির উপযুক্ত Pronoun ব্যবহার করে প্রশ্নবোধক চিহ্ন (?) দিন।',
                'example' => 'He is a student, isn\'t he? (Positive to Negative). Everybody loves a flower, don\'t they? (Everybody-র প্রোনাউন they, এবং plural verb হওয়ায় don\'t বসেছে)।',
                'common_mistake' => 'ভুল: "I am a student, amn\'t I?" লেখা। am-এর negative tag হিসেবে "aren\'t I?" অথবা "ain\'t I?" লিখতে হবে, amn\'t নয়।',
                'exam_answer_pattern' => 'পরীক্ষায় সম্পূর্ণ বাক্যটি লিখে কমা (,) দিয়ে ট্যাগ অংশটুকু লিখে শেষে অবশ্যই প্রশ্নবোধক চিহ্ন (?) দিতে হবে এবং ট্যাগ অংশের নিচে আন্ডারলাইন করবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l9->id,
            'question' => 'Choose the correct tag for: "Let\'s have a picnic, ______?"',
            'options' => ['will we', 'shall we', 'don\'t we', 'aren\'t we'],
            'correct_answer' => 'shall we',
            'explanation' => 'বাক্যটি Let\'s বা Let us দিয়ে শুরু হলে ট্যাগ সবসময় "shall we" হয়।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l9->id,
            'question' => 'Choose the correct tag for: "Barking dogs seldom bite, ______?"',
            'options' => ['do they', 'don\'t they', 'does it', 'doesn\'t it'],
            'correct_answer' => 'do they',
            'explanation' => '"Seldom" শব্দটি না-বোধক (negative) অর্থ প্রকাশ করে, তাই ট্যাগ হবে হ্যাঁ-বোধক (positive)। সাবজেক্ট "dogs" বহুবচন হওয়ায় প্রোনাউন they বসবে এবং verb-এর base form থাকায় tag হবে "do they"।'
        ]);

        // Level 10: Simple / Complex / Compound
        $l10 = GrammarLesson::updateOrCreate(
            ['level_no' => 57],
            [
                'level_name' => 'Simple / Complex / Compound structure',
                'category' => 'LEVEL 21 — Simple / Complex / Compound',
                'rule' => 'গঠন অনুযায়ী Sentence ৩ প্রকার। Simple Sentence: একটি মাত্র Subject ও একটি Finite Verb থাকে। Complex Sentence: একটি Principal Clause এবং এক বা একাধিক Subordinate Clause থাকে যা though, since, because, if, who, that ইত্যাদি দ্বারা যুক্ত থাকে। Compound Sentence: একাধিক Principal Clause দুই বা ততোধিক coordinating conjunction (and, but, or, so, yet) দ্বারা যুক্ত থাকে।',
                'formula' => 'Simple: Single Subject + Finite Verb. Complex: Subordinate Connector (if/since/though) + Main Clause. Compound: Clause + Coordinating Conjunction (and/but/or) + Clause',
                'recognition' => 'বাক্যে ব্যবহৃত connectors (who, which, since, but, or) দেখে বাক্যটি কোন ধরণের তা সহজে চেনা যায়।',
                'step_1' => 'প্রথমে বাক্যে কয়টি finite verb এবং clause আছে তা খুঁজে বের করুন।',
                'step_2' => 'ক্লজগুলো কোনো জটিল কানেক্টর (যেমন: although) নাকি কোঅর্ডিনেটিং কানেক্টর (যেমন: but) দ্বারা যুক্ত তা চিহ্নিত করুন।',
                'step_3' => 'কানেক্টর এবং ক্লজের সংখ্যা বিবেচনা করে বাক্যের শ্রেণীবিভাগ (Simple/Complex/Compound) করুন।',
                'example' => 'Simple: Despite his poverty, he is honest. Complex: Though he is poor, he is honest. Compound: He is poor but he is honest.',
                'common_mistake' => 'ভুল: Complex করার সময় principal clause-এর পূর্বেও "but" বা "so" যোগ করে ফেলা। যেমন: "Though he is poor but he is honest" লেখা (ভুল, "but" বসবে না)।',
                'exam_answer_pattern' => 'পরীক্ষায় ব্র্যাকেটে রূপান্তরের নির্দেশ দেওয়া থাকে। একটি বাক্যকে অন্য বাক্যে রূপান্তরের সময় তার নির্দিষ্ট কানেক্টর ও ক্লজ সংখ্যা ঠিক রেখে খাতায় লিখবে।'
            ]
        );

        GrammarExercise::create([
            'lesson_id' => $l10->id,
            'question' => 'Identify the sentence type: "Although he is rich, he is unhappy."',
            'options' => ['Simple Sentence', 'Complex Sentence', 'Compound Sentence', 'None of these'],
            'correct_answer' => 'Complex Sentence',
            'explanation' => 'এখানে "Although" দ্বারা একটি Subordinate Clause যুক্ত হয়েছে এবং একটি Principal Clause রয়েছে, তাই এটি Complex Sentence।'
        ]);

        GrammarExercise::create([
            'lesson_id' => $l10->id,
            'question' => 'Convert into Compound: "In spite of his working hard, he failed."',
            'options' => [
                'He worked hard so he failed.',
                'Though he worked hard, he failed.',
                'He worked hard but he failed.',
                'Working hard he failed.'
            ],
            'correct_answer' => 'He worked hard but he failed.',
            'explanation' => 'Coordinating Conjunction "but" বসিয়ে বিপরীতমুখী কাজের সংযোগ ঘটানো হয়েছে যা Compound Sentence-এর সঠিক রূপ।'
        ]);
    }
}
