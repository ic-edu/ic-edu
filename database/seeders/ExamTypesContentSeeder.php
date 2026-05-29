<?php

namespace Database\Seeders;

use App\Models\ExamType;
use Illuminate\Database\Seeder;

class ExamTypesContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. TOEIC
        $toeic = ExamType::where('name', 'TOEIC')->first();
        if ($toeic) {
            $toeic->update([
                'page_content' => [
                    'slug' => 'toeic',
                    'hero_title' => "Reach Your TOEIC Goals\nwith IC Edu",
                    'hero_subtitle' => "Evaluate and improve the communication skills required for global business and workplace environments. Get ready to score high with our mock tests!",
                    'what_is_title' => "What is TOEIC?",
                    'what_is_description' => [
                        "The Test of English for International Communication (TOEIC) is an international standardized English proficiency assessment designed to evaluate communication skills used in workplace and professional settings. TOEIC is commonly used by global companies, institutions, and organizations to measure English abilities for career development, recruitment, and professional certification.",
                        "The test focuses on practical English used in everyday business situations, including meetings, presentations, emails, and workplace conversations. TOEIC is widely recognized across Asia and various international industries as a benchmark for professional English proficiency."
                    ],
                    'features' => [
                        "Duration: Around 2 hours (Listening & Reading), 1 hour 20 mins (Speaking & Writing)",
                        "Score Range: 10 - 990 for Listening & Reading, 0 - 200 each for Speaking & Writing",
                        "Tests can be taken as combined packages or separately",
                        "Official test conducted at authorized test centers",
                        "Internationally recognized certification for professional workplace communication"
                    ],
                    'bubbles' => ["Listening", "Reading", "Speaking", "Writing"],
                    'accordion_items' => [
                        [
                            'title' => "1: Listening Section (45 minutes)",
                            'subtitle' => "This section takes around 45 minutes with 100 questions",
                            'bullets' => [
                                "Photographs: 6 questions - Choose the statement that best describes the picture.",
                                "Question-Response: 25 questions - Respond to questions with the most appropriate answer.",
                                "Conversations: 39 questions - Listen to short conversations between two people and answer questions.",
                                "Short Talks: 30 questions - Listen to short talks or announcements and answer questions."
                            ]
                        ],
                        [
                            'title' => "2: Reading Section (75 minutes)",
                            'subtitle' => "This section takes around 75 minutes with 100 questions",
                            'bullets' => [
                                "Incomplete Sentences: 30 questions - Fill in the blank with the correct grammar or vocabulary word.",
                                "Text Completion: 16 questions - Choose the best words or sentences to complete short texts.",
                                "Single Passages: 29 questions - Read single texts (articles, emails, etc.) and answer questions.",
                                "Multiple Passages: 25 questions - Read and compare multiple related texts and answer questions."
                            ]
                        ],
                        [
                            'title' => "3: Speaking Section (20 minutes)",
                            'subtitle' => "This section takes around 20 minutes with 11 questions",
                            'bullets' => [
                                "Read a Text Aloud: 2 questions - Read a short text showing clear pronunciation and intonation.",
                                "Describe a Picture: 2 questions - Describe a photo in detail, focusing on vocabulary and grammar.",
                                "Respond to Questions: 3 questions - Provide quick, structured answers to everyday topics.",
                                "Respond to Questions using Information Provided: 3 questions - Read a schedule or agenda and answer related questions.",
                                "Express an Opinion: 1 question - State and defend your opinion about a workplace scenario."
                            ]
                        ],
                        [
                            'title' => "4: Writing Section (60 minutes)",
                            'subtitle' => "This section takes around 60 minutes with 8 questions",
                            'bullets' => [
                                "Write a Sentence Based on a Picture: 5 questions - Create grammatically correct sentences using given key terms.",
                                "Respond to a Written Request: 2 questions - Write professional emails responding to client or manager requests.",
                                "Write an Opinion Essay: 1 question - Plan and write an essay supporting a perspective in at least 300 words."
                            ]
                        ]
                    ],
                    'practice_route' => 'test_taker.exam.index'
                ]
            ]);
        }

        // 2. TOEFL
        $toefl = ExamType::where('name', 'TOEFL')->first();
        if ($toefl) {
            $toefl->update([
                'page_content' => [
                    'slug' => 'toefl',
                    'hero_title' => "Reach Your TOEFL Goals\nwith IC Edu",
                    'hero_subtitle' => "Prepare to crush the TOEFL with our personalized and easy-to-use prep tools! With in-depth practice tests and interactive lessons, IC.Edu has everything you need to boost your score.",
                    'what_is_title' => "What is TOEFL?",
                    'what_is_description' => [
                        "The Test of English as a Foreign Language (TOEFL) is a standardized test that measures English language proficiency in an academic setting, particularly for non-native speakers who plan to study abroad. It evaluates your ability to combine your reading, listening, speaking, and writing skills to perform academic tasks.",
                        "TOEFL is widely accepted by universities, colleges, and licensing agencies in more than 160 countries. The TOEFL iBT test is administered online at secure, authorized test centers or from home."
                    ],
                    'features' => [
                        "Duration: Around 2 hours for all sections",
                        "Score Range: 0 - 120 (TOEFL iBT)",
                        "Sections: Reading, Listening, Speaking, and Writing",
                        "Official test conducted online at authorized test centers",
                        "Internationally recognized certification for academic admissions"
                    ],
                    'bubbles' => ["Reading", "Listening", "Speaking", "Writing"],
                    'accordion_items' => [
                        [
                            'title' => "1: Reading Section (35 minutes)",
                            'subtitle' => "This section takes around 35 minutes with 20 questions",
                            'bullets' => [
                                "Academic Passages: Read 2 academic passages (approx. 700 words each) from university textbooks.",
                                "Question Types: Answer 10 questions per passage testing comprehension, vocabulary, and details."
                            ]
                        ],
                        [
                            'title' => "2: Listening Section (36 minutes)",
                            'subtitle' => "This section takes around 36 minutes with 28 questions",
                            'bullets' => [
                                "Lectures: Listen to 3 academic lectures (some with classroom discussions) and answer 6 questions each.",
                                "Conversations: Listen to 2 conversations between students and campus staff, and answer 5 questions each."
                            ]
                        ],
                        [
                            'title' => "3: Speaking Section (16 minutes)",
                            'subtitle' => "This section takes around 16 minutes with 4 tasks",
                            'bullets' => [
                                "Independent Task: Express an opinion on a familiar campus-related topic based on personal experience.",
                                "Integrated Tasks: Combine reading, listening, and speaking skills to discuss academic and campus topics."
                            ]
                        ],
                        [
                            'title' => "4: Writing Section (29 minutes)",
                            'subtitle' => "This section takes around 29 minutes with 2 tasks",
                            'bullets' => [
                                "Integrated Writing Task: Read a passage, listen to a lecture, and write a summary explaining the relationship.",
                                "Academic Discussion Task: Read an online classroom discussion post and write a response contributing to it."
                            ]
                        ]
                    ],
                    'practice_route' => 'test_taker.exam.index'
                ]
            ]);
        }

        // 3. IELTS
        $ielts = ExamType::where('name', 'IELTS')->first();
        if ($ielts) {
            $ielts->update([
                'page_content' => [
                    'slug' => 'ielts',
                    'hero_title' => "Reach Your IELTS Goals\nwith IC Edu",
                    'hero_subtitle' => "Master the IELTS Academic or General Training test with our top-tier preparation modules and mock exams. Boost your band score today!",
                    'what_is_title' => "What is IELTS?",
                    'what_is_description' => [
                        "The International English Language Testing System (IELTS) is the world's most popular English language proficiency test for higher education and global migration. It assesses your English abilities across all four core skills: Listening, Reading, Writing, and Speaking.",
                        "IELTS is recognized by more than 11,000 organizations worldwide, including educational institutions, employers, professional associations, and governments. The test is available in two formats: IELTS Academic (for university study) and IELTS General Training (for migration and work)."
                    ],
                    'features' => [
                        "Duration: Around 2 hours and 45 minutes",
                        "Score Range: Band Score 0 - 9.0 (with half-band increments)",
                        "Accepted in UK, Australia, Canada, New Zealand, and USA",
                        "Available in computer-delivered and paper-based formats",
                        "Official test conducted at British Council or IDP centers"
                    ],
                    'bubbles' => ["Listening", "Reading", "Writing", "Speaking"],
                    'accordion_items' => [
                        [
                            'title' => "1: Listening Section (30 minutes)",
                            'subtitle' => "This section takes around 30 minutes with 40 questions",
                            'bullets' => [
                                "Part 1 & 2: Social contexts (conversations and monologues about daily life).",
                                "Part 3 & 4: Educational and training contexts (conversations and lectures)."
                            ]
                        ],
                        [
                            'title' => "2: Reading Section (60 minutes)",
                            'subtitle' => "This section takes around 60 minutes with 40 questions",
                            'bullets' => [
                                "Passages: 3 long academic texts taken from books, journals, magazines, and newspapers.",
                                "Question Types: Multiple choice, matching headings, sentence completion, and true/false/not given."
                            ]
                        ],
                        [
                            'title' => "3: Writing Section (60 minutes)",
                            'subtitle' => "This section takes around 60 minutes with 2 tasks",
                            'bullets' => [
                                "Task 1: Describe a chart, graph, table, or diagram in at least 150 words (20 minutes).",
                                "Task 2: Write an essay in response to a point of view, argument, or problem in at least 250 words (40 minutes)."
                            ]
                        ],
                        [
                            'title' => "4: Speaking Section (11-14 minutes)",
                            'subtitle' => "This section is a face-to-face interview with 3 parts",
                            'bullets' => [
                                "Part 1: General questions about yourself, family, studies, and interests (4-5 minutes).",
                                "Part 2: Speak on a given topic (using a cue card) for 1 to 2 minutes after 1 minute of preparation.",
                                "Part 3: Discussion with the examiner exploring abstract issues related to Part 2 (4-5 minutes)."
                            ]
                        ]
                    ],
                    'practice_route' => 'test_taker.exam.index'
                ]
            ]);
        }
    }
}
