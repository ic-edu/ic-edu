<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseLesson;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        // ──────────────────────────────────────────────
        // COURSE 1: TOEFL iBT Preparation
        // ──────────────────────────────────────────────
        $toefl = Course::create([
            'title'          => 'TOEFL iBT Preparation — Complete Course',
            'description'    => '<p>Master all four sections of the TOEFL iBT exam: <strong>Reading, Listening, Speaking, and Writing</strong>. This comprehensive course includes video lectures, practice exercises, and proven strategies to achieve your target score.</p><p>Designed for students aiming for scores <strong>80+</strong> on the TOEFL iBT.</p>',
            'target_level'   => 'Intermediate',
            'is_published'   => true,
        ]);

        // Module 1: Introduction
        $m1 = CourseModule::create([
            'course_id'      => $toefl->id,
            'title'          => 'Introduction to TOEFL iBT',
            'description'    => 'Understanding the TOEFL iBT format, scoring system, and preparation strategies.',
            'order_position' => 1,
        ]);

        CourseLesson::create([
            'module_id'        => $m1->id,
            'title'            => 'Welcome & Course Overview',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_minutes' => 8,
            'order_position'   => 1,
            'is_previewable'   => true,
        ]);

        CourseLesson::create([
            'module_id'        => $m1->id,
            'title'            => 'Understanding the TOEFL iBT Format',
            'type'             => 'text',
            'text_content'     => '<h2>TOEFL iBT Test Format</h2>
<p>The TOEFL iBT test consists of <strong>four sections</strong>:</p>
<ol>
    <li><strong>Reading</strong> (54-72 minutes) — 3-4 passages, 10 questions each</li>
    <li><strong>Listening</strong> (41-57 minutes) — 3-4 lectures, 2-3 conversations</li>
    <li><strong>Speaking</strong> (17 minutes) — 4 tasks (1 independent, 3 integrated)</li>
    <li><strong>Writing</strong> (50 minutes) — 1 integrated task, 1 independent essay</li>
</ol>
<h3>Scoring</h3>
<p>Each section is scored <strong>0-30</strong>, giving a total score range of <strong>0-120</strong>.</p>
<blockquote>Most universities require a minimum score between <strong>80-100</strong> for admission.</blockquote>
<h3>Key Tips</h3>
<ul>
    <li>Practice note-taking — you will need it for Listening, Speaking, and Writing.</li>
    <li>Build academic vocabulary — the test uses university-level content.</li>
    <li>Time management is crucial — practice under timed conditions.</li>
</ul>',
            'duration_minutes' => 12,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);

        CourseLesson::create([
            'module_id'        => $m1->id,
            'title'            => 'Official ETS TOEFL Guide (PDF)',
            'type'             => 'link',
            'content_url'      => 'https://www.ets.org/toefl/test-takers/ibt/about',
            'duration_minutes' => 15,
            'order_position'   => 3,
            'is_previewable'   => false,
        ]);

        // Module 2: Reading Section
        $m2 = CourseModule::create([
            'course_id'      => $toefl->id,
            'title'          => 'Reading Section Mastery',
            'description'    => 'Strategies and practice for the TOEFL iBT Reading section.',
            'order_position' => 2,
        ]);

        CourseLesson::create([
            'module_id'        => $m2->id,
            'title'            => 'Reading Question Types Explained',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_minutes' => 22,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);

        CourseLesson::create([
            'module_id'        => $m2->id,
            'title'            => 'Skimming & Scanning Techniques',
            'type'             => 'text',
            'text_content'     => '<h2>Skimming & Scanning</h2>
<p>These two techniques are essential for the Reading section:</p>
<h3>Skimming</h3>
<p>Read quickly to get the <strong>main idea</strong> of a passage. Focus on:</p>
<ul>
    <li>First and last sentences of each paragraph</li>
    <li>Topic sentences and transition words</li>
    <li>Bold or italicized words</li>
</ul>
<h3>Scanning</h3>
<p>Search for <strong>specific information</strong> like names, dates, and keywords without reading every word.</p>
<p><em>Practice Tip: Set a timer for 20 minutes and try to answer all 10 questions for one passage.</em></p>',
            'duration_minutes' => 10,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        CourseLesson::create([
            'module_id'        => $m2->id,
            'title'            => 'Reading Practice Set #1',
            'type'             => 'text',
            'text_content'     => '<h2>Practice Passage: The Origins of Agriculture</h2>
<p>Agriculture did not develop simultaneously across the world. The earliest evidence of farming dates back approximately 10,000 years to the Fertile Crescent, a region in the Middle East...</p>
<p><strong>Instructions:</strong> Read the passage above, then attempt the practice questions in the next exam simulation module.</p>',
            'duration_minutes' => 25,
            'order_position'   => 3,
            'is_previewable'   => false,
        ]);

        // Module 3: Listening Section
        $m3 = CourseModule::create([
            'course_id'      => $toefl->id,
            'title'          => 'Listening Section Strategies',
            'description'    => 'Note-taking skills and comprehension strategies for TOEFL Listening.',
            'order_position' => 3,
        ]);

        CourseLesson::create([
            'module_id'        => $m3->id,
            'title'            => 'Effective Note-Taking for Listening',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_minutes' => 18,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);

        CourseLesson::create([
            'module_id'        => $m3->id,
            'title'            => 'Sample Lecture: Marine Biology',
            'type'             => 'audio',
            'content_url'      => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
            'duration_minutes' => 6,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        CourseLesson::create([
            'module_id'        => $m3->id,
            'title'            => 'Listening Comprehension Tips',
            'type'             => 'text',
            'text_content'     => '<h2>Key Listening Strategies</h2>
<ul>
    <li><strong>Focus on the main idea</strong> — Don\'t try to catch every word.</li>
    <li><strong>Listen for signal words</strong> — "however", "on the other hand", "for example".</li>
    <li><strong>Note the speaker\'s attitude</strong> — Pay attention to tone and emphasis.</li>
    <li><strong>Predict answers</strong> — Before looking at choices, think about what the answer might be.</li>
</ul>',
            'duration_minutes' => 8,
            'order_position'   => 3,
            'is_previewable'   => false,
        ]);

        // ──────────────────────────────────────────────
        // COURSE 2: IELTS Academic Writing
        // ──────────────────────────────────────────────
        $ielts = Course::create([
            'title'          => 'IELTS Academic Writing — Band 7+ Guide',
            'description'    => '<p>A focused course on achieving <strong>Band 7+</strong> in IELTS Academic Writing. Covers Task 1 (data description) and Task 2 (essay writing) with templates, sample answers, and examiner insights.</p>',
            'target_level'   => 'Advanced',
            'is_published'   => true,
        ]);

        // Module 1: Task 1
        $im1 = CourseModule::create([
            'course_id'      => $ielts->id,
            'title'          => 'Task 1: Describing Visual Data',
            'description'    => 'How to describe graphs, charts, tables, maps, and processes.',
            'order_position' => 1,
        ]);

        CourseLesson::create([
            'module_id'        => $im1->id,
            'title'            => 'Task 1 Overview & Band Descriptors',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_minutes' => 15,
            'order_position'   => 1,
            'is_previewable'   => true,
        ]);

        CourseLesson::create([
            'module_id'        => $im1->id,
            'title'            => 'Writing a Strong Overview',
            'type'             => 'text',
            'text_content'     => '<h2>The Overview Paragraph</h2>
<p>The <strong>overview</strong> is the most important part of your Task 1 response. It summarizes the <strong>key trends, differences, or stages</strong> without including specific data.</p>
<h3>Template</h3>
<blockquote>"Overall, it is clear that [main trend 1]. Additionally, [main trend 2]."</blockquote>
<h3>Common Mistakes</h3>
<ul>
    <li>❌ Including specific numbers in the overview</li>
    <li>❌ Writing more than 2-3 sentences</li>
    <li>❌ Skipping the overview entirely (this alone can drop you to Band 5)</li>
</ul>',
            'duration_minutes' => 10,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        CourseLesson::create([
            'module_id'        => $im1->id,
            'title'            => 'Useful Vocabulary for Data Description',
            'type'             => 'text',
            'text_content'     => '<h2>Vocabulary for Trends</h2>
<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%;">
    <thead><tr><th>Trend</th><th>Verbs</th><th>Nouns</th></tr></thead>
    <tbody>
        <tr><td>⬆️ Increase</td><td>rose, climbed, surged, soared</td><td>a rise, an increase, a surge</td></tr>
        <tr><td>⬇️ Decrease</td><td>fell, dropped, declined, plummeted</td><td>a fall, a decline, a drop</td></tr>
        <tr><td>➡️ Stable</td><td>remained steady, leveled off, plateaued</td><td>a plateau, stability</td></tr>
        <tr><td>🔀 Fluctuate</td><td>fluctuated, varied, oscillated</td><td>a fluctuation</td></tr>
    </tbody>
</table>',
            'duration_minutes' => 8,
            'order_position'   => 3,
            'is_previewable'   => false,
        ]);

        // Module 2: Task 2
        $im2 = CourseModule::create([
            'course_id'      => $ielts->id,
            'title'          => 'Task 2: Essay Writing Mastery',
            'description'    => 'Structures, templates, and strategies for different essay types.',
            'order_position' => 2,
        ]);

        CourseLesson::create([
            'module_id'        => $im2->id,
            'title'            => 'Understanding the 5 Essay Types',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_minutes' => 20,
            'order_position'   => 1,
            'is_previewable'   => true,
        ]);

        CourseLesson::create([
            'module_id'        => $im2->id,
            'title'            => 'Opinion Essay Template & Sample',
            'type'             => 'text',
            'text_content'     => '<h2>Opinion Essay (Agree/Disagree)</h2>
<h3>Structure</h3>
<ol>
    <li><strong>Introduction</strong> — Paraphrase the question + state your opinion</li>
    <li><strong>Body Paragraph 1</strong> — Main reason + explanation + example</li>
    <li><strong>Body Paragraph 2</strong> — Second reason + explanation + example</li>
    <li><strong>Conclusion</strong> — Restate opinion in different words</li>
</ol>
<h3>Sample Prompt</h3>
<blockquote>"Some people think that universities should provide graduates with the knowledge and skills needed in the workplace. Others think that the true function of a university should be to give access to knowledge for its own sake. Discuss both views and give your opinion."</blockquote>
<p><em>Target: 250-280 words, completed in 40 minutes.</em></p>',
            'duration_minutes' => 15,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        CourseLesson::create([
            'module_id'        => $im2->id,
            'title'            => 'Common Grammar Mistakes in IELTS Writing',
            'type'             => 'text',
            'text_content'     => '<h2>Top Grammar Mistakes to Avoid</h2>
<ol>
    <li><strong>Subject-verb agreement:</strong> "The number of students <s>have</s> → <strong>has</strong> increased."</li>
    <li><strong>Run-on sentences:</strong> Break long sentences into two. Use connectors properly.</li>
    <li><strong>Articles:</strong> "The government should invest in <s>the</s> education" → "...in education."</li>
    <li><strong>Comma splices:</strong> "Many people agree, <s>however</s> others disagree." → Use a period or semicolon.</li>
    <li><strong>Word form:</strong> "This has a <s>significantly</s> impact" → "<strong>significant</strong> impact."</li>
</ol>',
            'duration_minutes' => 10,
            'order_position'   => 3,
            'is_previewable'   => false,
        ]);

        // Module 3: Exam Strategies
        $im3 = CourseModule::create([
            'course_id'      => $ielts->id,
            'title'          => 'Exam Day Strategies & Time Management',
            'description'    => 'Practical tips for maximizing your score on test day.',
            'order_position' => 3,
        ]);

        CourseLesson::create([
            'module_id'        => $im3->id,
            'title'            => 'Time Management on Exam Day',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_minutes' => 12,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);

        CourseLesson::create([
            'module_id'        => $im3->id,
            'title'            => 'IELTS Writing Checklist',
            'type'             => 'text',
            'text_content'     => '<h2>Pre-Submit Checklist</h2>
<p>Before you submit, check for:</p>
<ul>
    <li>✅ Word count (Task 1: 150+, Task 2: 250+)</li>
    <li>✅ Clear paragraphing with topic sentences</li>
    <li>✅ Overview present in Task 1</li>
    <li>✅ Opinion clearly stated in Task 2</li>
    <li>✅ Grammar variety (mix simple, compound, complex)</li>
    <li>✅ Vocabulary range (avoid repetition)</li>
    <li>✅ Spelling checked (especially common errors)</li>
</ul>',
            'duration_minutes' => 5,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);

        $this->command->info('✅ LMS sample data seeded: 2 Courses, 6 Modules, 15 Lessons');
    }
}
