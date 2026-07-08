<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseLesson;
use App\Models\Exam;
use App\Models\Section;
use App\Models\Subsection;
use App\Models\QuestionGroup;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class DemoContentSeeder2 extends Seeder
{
    public function run(): void
    {
        $this->seedCourses();
        $this->seedExams();
        $this->command->info('✅ Demo content batch 2 seeded: 4 Courses, 3 Exams.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  COURSES
    // ══════════════════════════════════════════════════════════════════════

    private function seedCourses(): void
    {
        // ── COURSE 1: TOEFL Speaking Mastery ──────────────────────────────────
        $toeflSpeak = Course::create([
            'title'        => 'TOEFL iBT Speaking — Task Mastery Guide',
            'description'  => '<p>Conquer the <strong>TOEFL iBT Speaking section</strong> with structured templates, model responses, and proven delivery techniques. This course covers all four speaking tasks — from the independent opinion task to complex integrated tasks combining reading and listening.</p><p>Target score: <strong>24+ out of 30</strong>.</p>',
            'target_level' => 'Intermediate',
            'is_published' => true,
            'price'        => 179000,
        ]);

        $ts1 = CourseModule::create([
            'course_id' => $toeflSpeak->id, 'title' => 'Introduction to TOEFL Speaking',
            'description' => 'Overview of the section format, scoring rubric, and key delivery skills.', 'order_position' => 1,
        ]);
        CourseLesson::create([
            'module_id' => $ts1->id, 'title' => 'Course Overview & Scoring Rubric',
            'type' => 'video', 'content_url' => 'https://www.youtube.com/watch?v=OI-To1eUtuU',
            'duration_minutes' => 10, 'order_position' => 1, 'is_previewable' => true,
        ]);
        CourseLesson::create([
            'module_id' => $ts1->id, 'title' => 'The Four Speaking Tasks Explained',
            'type' => 'text',
            'text_content' => '<h2>TOEFL iBT Speaking: 4 Tasks</h2>
<table border="1" cellpadding="8" style="border-collapse:collapse;width:100%">
  <thead><tr><th>Task</th><th>Type</th><th>Prep Time</th><th>Response Time</th></tr></thead>
  <tbody>
    <tr><td><strong>Task 1</strong></td><td>Independent — Express your opinion on a familiar topic</td><td>15 sec</td><td>45 sec</td></tr>
    <tr><td><strong>Task 2</strong></td><td>Integrated — Read + Listen (campus topic), then speak</td><td>30 sec</td><td>60 sec</td></tr>
    <tr><td><strong>Task 3</strong></td><td>Integrated — Read + Listen (academic topic), then speak</td><td>30 sec</td><td>60 sec</td></tr>
    <tr><td><strong>Task 4</strong></td><td>Integrated — Listen only (academic lecture), then speak</td><td>20 sec</td><td>60 sec</td></tr>
  </tbody>
</table>
<h3>Scoring</h3>
<p>Each task is rated <strong>0–4</strong> by AI and human raters on three criteria:</p>
<ul>
  <li><strong>Delivery:</strong> Clear pronunciation, natural pace, no long pauses</li>
  <li><strong>Language Use:</strong> Grammar accuracy, vocabulary range</li>
  <li><strong>Topic Development:</strong> Relevance, coherence, completeness</li>
</ul>',
            'duration_minutes' => 12, 'order_position' => 2, 'is_previewable' => true,
        ]);

        $ts2 = CourseModule::create([
            'course_id' => $toeflSpeak->id, 'title' => 'Task 1: Independent Speaking',
            'description' => 'Templates and practice for giving confident, structured personal opinions.', 'order_position' => 2,
        ]);
        CourseLesson::create([
            'module_id' => $ts2->id, 'title' => 'The PREP Method for Task 1',
            'type' => 'text',
            'text_content' => '<h2>PREP: Your Task 1 Template</h2>
<p>Use the <strong>PREP</strong> framework to structure every independent response:</p>
<ul>
  <li><strong>P — Point:</strong> State your opinion clearly. (5 seconds)</li>
  <li><strong>R — Reason:</strong> Give one main reason. (10 seconds)</li>
  <li><strong>E — Example:</strong> Support with a specific example or experience. (20 seconds)</li>
  <li><strong>P — Point (restate):</strong> Briefly restate your opinion. (5 seconds)</li>
</ul>
<h3>Sample Prompt</h3>
<blockquote>Some people prefer to live in a large city. Others prefer to live in a small town. Which do you prefer, and why?</blockquote>
<h3>Model Response (Score 4/4)</h3>
<blockquote>"I strongly prefer living in a large city, primarily because of the career opportunities it provides. In major cities, there is a far greater concentration of companies, industries, and professional networks that simply don\'t exist in smaller towns. For example, when I was looking for an internship last year, living in the city allowed me to attend multiple job fairs and meet hiring managers directly — something I could never have done in my hometown. So for professional growth, city life is clearly the better choice for me."</blockquote>
<p><em>Word count: ~95 words | Delivery time: ~40 seconds at natural pace</em></p>',
            'duration_minutes' => 15, 'order_position' => 1, 'is_previewable' => false,
        ]);
        CourseLesson::create([
            'module_id' => $ts2->id, 'title' => '10 Common Task 1 Topics & Sample Answers',
            'type' => 'text',
            'text_content' => '<h2>Task 1 Practice Topics</h2>
<p>Prepare responses for these frequently tested opinion categories:</p>
<ol>
  <li>Preference between two options (city vs. town, studying alone vs. group)</li>
  <li>Agree/Disagree statements (e.g., "Technology has made communication less personal.")</li>
  <li>Best choice from a list (e.g., "Which quality is most important in a leader: intelligence, empathy, or decisiveness?")</li>
  <li>Describe and explain (e.g., "Describe a skill you wish you had learned earlier.")</li>
  <li>If you could change one thing (school system, daily routine, your hometown)</li>
</ol>
<h3>Quick Answer: Agree/Disagree Topic</h3>
<blockquote><strong>Prompt:</strong> "Do you agree that children should learn a second language before the age of 10?"</blockquote>
<p><strong>Response outline:</strong></p>
<ol>
  <li><em>Point:</em> Yes, I strongly agree.</li>
  <li><em>Reason:</em> Young children\'s brains are neurologically wired for language acquisition.</li>
  <li><em>Example:</em> Studies show children in bilingual programs by age 7 achieve native-like fluency significantly more often than those who start in high school.</li>
  <li><em>Restate:</em> Early language learning is a cognitive advantage worth pursuing.</li>
</ol>',
            'duration_minutes' => 18, 'order_position' => 2, 'is_previewable' => false,
        ]);

        $ts3 = CourseModule::create([
            'course_id' => $toeflSpeak->id, 'title' => 'Tasks 2–4: Integrated Speaking',
            'description' => 'How to synthesize reading, listening, and speaking effectively.', 'order_position' => 3,
        ]);
        CourseLesson::create([
            'module_id' => $ts3->id, 'title' => 'Task 2: Campus Announcement Strategy',
            'type' => 'text',
            'text_content' => '<h2>Task 2 Strategy: Read → Listen → Speak</h2>
<h3>Step-by-Step Approach</h3>
<ol>
  <li><strong>Reading (45 sec):</strong> Identify the change/proposal and the reason(s) given. Note 1–2 key points.</li>
  <li><strong>Listening (60–90 sec):</strong> Note the speaker\'s opinion (agree/disagree) and their 2 reasons/examples.</li>
  <li><strong>Speaking (60 sec):</strong> Report the speaker\'s opinion — do NOT give your own.</li>
</ol>
<h3>Response Template</h3>
<blockquote>
"The university has announced that [main change]. The man/woman in the conversation [agrees/disagrees] with this change for two reasons.<br><br>
First, he/she points out that [reason 1]. For example, [supporting detail].<br><br>
Second, he/she explains that [reason 2], which means [implication]."
</blockquote>
<p><em>Key tip: Always report what the speaker said — never share your personal opinion in Tasks 2, 3, or 4.</em></p>',
            'duration_minutes' => 20, 'order_position' => 1, 'is_previewable' => false,
        ]);
        CourseLesson::create([
            'module_id' => $ts3->id, 'title' => 'Task 4: Academic Lecture Summary',
            'type' => 'text',
            'text_content' => '<h2>Task 4: Summarizing an Academic Lecture</h2>
<p>In Task 4, you listen to a 60–90 second academic lecture and then explain the concept using the examples from the lecture.</p>
<h3>Note-Taking Template During Listening</h3>
<pre>
Main concept: _______________
Example 1:    _______________
  → Detail:  _______________
Example 2:    _______________
  → Detail:  _______________
</pre>
<h3>Sample Response (Topic: Camouflage in Animals)</h3>
<blockquote>
"The professor discusses camouflage — the ability of animals to blend into their surroundings to avoid predators or ambush prey.<br><br>
The first example is the Arctic fox, which has white fur in winter to blend with snow. In summer, its coat turns brown to match the tundra, making it nearly invisible year-round.<br><br>
The second example is the cuttlefish, which can change both its color and skin texture within milliseconds. The professor explains this is achieved through specialized skin cells called chromatophores, making it one of the most sophisticated camouflage systems in nature."
</blockquote>',
            'duration_minutes' => 22, 'order_position' => 2, 'is_previewable' => true,
        ]);

        // ── COURSE 2: IELTS Listening & Speaking ─────────────────────────────
        $ieltsLS = Course::create([
            'title'        => 'IELTS Listening & Speaking — Band 7 Strategies',
            'description'  => '<p>A targeted preparation course for the two oral skills in IELTS: <strong>Listening</strong> (Band 7+) and <strong>Speaking</strong> (Band 7+). Develop accurate listening comprehension, fluency, and the ability to discuss abstract topics with confidence.</p>',
            'target_level' => 'Intermediate',
            'is_published' => true,
            'price'        => 159000,
        ]);

        $il1 = CourseModule::create([
            'course_id' => $ieltsLS->id, 'title' => 'IELTS Listening: All Question Types',
            'description' => 'Matching, labelling, multiple choice, and short answer strategies.', 'order_position' => 1,
        ]);
        CourseLesson::create([
            'module_id' => $il1->id, 'title' => 'Map & Diagram Labelling Strategy',
            'type' => 'text',
            'text_content' => '<h2>Map & Diagram Labelling</h2>
<p>This question type appears in Parts 1 and 2. You must write a letter (A–H) or a word to label a map, floor plan, or diagram.</p>
<h3>Strategy</h3>
<ol>
  <li>Study the map/diagram during the preparation time — familiarize yourself with all labeled positions.</li>
  <li>Identify <strong>directional language</strong> the speaker will use:<br>
    "on the left/right of...", "next to...", "opposite...", "at the end of...", "in the corner..."</li>
  <li>Track your position on the map as the speaker moves through it.</li>
  <li>Write your answer as soon as you hear the information — do not wait.</li>
</ol>
<h3>Key Directional Vocabulary</h3>
<table border="1" cellpadding="6" style="border-collapse:collapse;width:100%">
  <tr><td>adjacent to</td><td>directly beside</td></tr>
  <tr><td>facing</td><td>opposite, looking toward</td></tr>
  <tr><td>at the far end</td><td>at the most distant point</td></tr>
  <tr><td>in the centre/middle</td><td>centrally located</td></tr>
  <tr><td>to the north/south/east/west</td><td>compass direction</td></tr>
</table>',
            'duration_minutes' => 14, 'order_position' => 1, 'is_previewable' => true,
        ]);
        CourseLesson::create([
            'module_id' => $il1->id, 'title' => 'Multiple Choice & Matching Strategies',
            'type' => 'text',
            'text_content' => '<h2>Multiple Choice (Listening)</h2>
<p>Common traps set by the examiners:</p>
<ul>
  <li><strong>Distractor answers:</strong> The speaker may mention an answer but then correct it. Always wait for the final statement.</li>
  <li><strong>Paraphrase:</strong> The correct answer will rarely use the exact same words as the question — listen for synonyms.</li>
  <li><strong>Negative questions:</strong> "Which of the following is NOT mentioned?" — eliminate options as they are confirmed.</li>
</ul>
<h3>Matching Questions</h3>
<p>In matching tasks, you connect a list of items (e.g., people, places, dates) to a list of descriptions or categories.</p>
<p><strong>Strategy:</strong></p>
<ol>
  <li>Read all options before the audio begins.</li>
  <li>Listen for the name/item to be matched first, then wait for the description.</li>
  <li>Be aware that the same option can sometimes be used more than once.</li>
  <li>Cross out options once used (if they can only be used once).</li>
</ol>',
            'duration_minutes' => 16, 'order_position' => 2, 'is_previewable' => false,
        ]);

        $il2 = CourseModule::create([
            'course_id' => $ieltsLS->id, 'title' => 'IELTS Speaking: Parts 1, 2, and 3',
            'description' => 'Band 7 responses, fluency techniques, and complex topic discussion.', 'order_position' => 2,
        ]);
        CourseLesson::create([
            'module_id' => $il2->id, 'title' => 'Part 1: Short Answer Fluency Techniques',
            'type' => 'text',
            'text_content' => '<h2>IELTS Speaking Part 1</h2>
<p>Part 1 lasts 4–5 minutes. The examiner asks familiar personal questions about topics like home, work, studies, hobbies, and daily routines.</p>
<h3>Band 7 Requirements</h3>
<ul>
  <li>Speak fluently with occasional hesitation — not long, unnatural pauses</li>
  <li>Use a wide range of vocabulary naturally (not forced)</li>
  <li>Produce complex sentences alongside simple ones</li>
</ul>
<h3>Extending Short Answers (AEIOU Method)</h3>
<p>Never give a one-word answer. Use the <strong>AEIOU</strong> technique:</p>
<ul>
  <li><strong>A — Answer:</strong> Directly answer the question.</li>
  <li><strong>E — Explain:</strong> Give a brief reason or explanation.</li>
  <li><strong>I — Illustrate:</strong> Add a specific example.</li>
  <li><strong>O — Opposite:</strong> (Optional) Mention a contrasting point.</li>
  <li><strong>U — Unique angle:</strong> Add something personal or unexpected.</li>
</ul>
<h3>Example</h3>
<p><em>Q: Do you enjoy cooking?</em></p>
<p><em>Band 5:</em> "Yes, I like cooking."</p>
<p><em>Band 7:</em> "I really do, actually. I find it quite therapeutic — there\'s something satisfying about transforming raw ingredients into a proper meal. I especially enjoy making Asian dishes since I grew up eating them. Though I have to admit, on busy weekdays I tend to just order delivery!"</p>',
            'duration_minutes' => 18, 'order_position' => 1, 'is_previewable' => false,
        ]);
        CourseLesson::create([
            'module_id' => $il2->id, 'title' => 'Part 2: The Long Turn — 2-Minute Monologue',
            'type' => 'text',
            'text_content' => '<h2>IELTS Speaking Part 2: Cue Card</h2>
<p>You receive a cue card and have <strong>1 minute</strong> to prepare, then must speak for <strong>1–2 minutes</strong>.</p>
<h3>Note-Taking in 1 Minute</h3>
<ul>
  <li>Read all bullet points on the card — they guide your answer.</li>
  <li>Jot down 3–5 key words per bullet, not full sentences.</li>
  <li>Think of a <em>specific</em> memory or example — concrete details score higher.</li>
</ul>
<h3>Sample Cue Card</h3>
<blockquote>
<strong>Describe a book that had a significant impact on you.</strong><br>
You should say:<br>
— What the book is about<br>
— When and why you read it<br>
— What you learned from it<br>
— And explain why it had such a significant impact on you.
</blockquote>
<h3>Model Response Framework (Band 7+)</h3>
<ol>
  <li><strong>Opening:</strong> "I\'d like to talk about [title], a [genre] book by [author] that I read [when]."</li>
  <li><strong>What it\'s about:</strong> 2–3 sentences summarizing the content.</li>
  <li><strong>Why you read it:</strong> Personal context or recommendation.</li>
  <li><strong>What you learned:</strong> Specific insight, lesson, or change in perspective.</li>
  <li><strong>Impact:</strong> Link it to your life — has it changed your behavior, beliefs, or career path?</li>
  <li><strong>Closing:</strong> "It\'s a book I\'d wholeheartedly recommend to anyone who..."</li>
</ol>',
            'duration_minutes' => 20, 'order_position' => 2, 'is_previewable' => false,
        ]);
        CourseLesson::create([
            'module_id' => $il2->id, 'title' => 'Part 3: Discussing Abstract Topics',
            'type' => 'text',
            'text_content' => '<h2>IELTS Speaking Part 3: Discussion</h2>
<p>Part 3 is a two-way discussion (4–5 minutes) on abstract themes related to your Part 2 topic. The examiner expects more complex language and analytical thinking.</p>
<h3>Advanced Discussion Phrases (Band 7–8)</h3>
<table border="1" cellpadding="6" style="border-collapse:collapse;width:100%">
  <thead><tr><th>Function</th><th>Useful Phrases</th></tr></thead>
  <tbody>
    <tr><td>Introducing a view</td><td>"It could be argued that..." / "There is a strong case for..."</td></tr>
    <tr><td>Conceding a point</td><td>"While it\'s true that..., I would still maintain that..."</td></tr>
    <tr><td>Speculating</td><td>"It seems likely that..." / "I would imagine that..."</td></tr>
    <tr><td>Giving both sides</td><td>"On the one hand... on the other hand..."</td></tr>
    <tr><td>Hedging</td><td>"It depends to some extent on..." / "In most cases, but not all..."</td></tr>
  </tbody>
</table>
<h3>Sample Q&A</h3>
<p><em>Q: Do you think reading habits have changed in recent years?</em></p>
<p>"That\'s an interesting question. I think reading habits have shifted quite dramatically, particularly among younger generations. While people are arguably reading more than ever — through social media, online articles, and digital news — the depth of that reading has diminished. Long-form reading, the kind required for novels or academic texts, has declined as attention spans have shortened. It could be argued that the quality of reading matters more than the quantity, and in that sense, we may actually be in a period of regression despite the abundance of information available to us."</p>',
            'duration_minutes' => 22, 'order_position' => 3, 'is_previewable' => true,
        ]);

        // ── COURSE 3: Business English Communication ──────────────────────────
        $bizEnglish = Course::create([
            'title'        => 'Business English — Professional Communication Skills',
            'description'  => '<p>Develop the <strong>professional English skills</strong> demanded in international business environments. From crafting persuasive presentations to conducting negotiations, this course prepares you for real workplace scenarios with native-level fluency and confidence.</p>',
            'target_level' => 'Advanced',
            'is_published' => true,
            'price'        => 299000,
        ]);

        $be1 = CourseModule::create([
            'course_id' => $bizEnglish->id, 'title' => 'Professional Writing: Reports & Proposals',
            'description' => 'Structure, tone, and language for formal business documents.', 'order_position' => 1,
        ]);
        CourseLesson::create([
            'module_id' => $be1->id, 'title' => 'Writing an Executive Summary',
            'type' => 'text',
            'text_content' => '<h2>The Executive Summary</h2>
<p>An executive summary is a concise overview of a longer business document. Senior readers often read only the executive summary, so it must stand alone as a complete, informative document.</p>
<h3>Structure (max 1 page)</h3>
<ol>
  <li><strong>Purpose:</strong> Why was this report/proposal written?</li>
  <li><strong>Key Findings:</strong> The 2–3 most critical discoveries or data points.</li>
  <li><strong>Conclusions:</strong> What do the findings mean?</li>
  <li><strong>Recommendations:</strong> What action should be taken?</li>
</ol>
<h3>Sample Executive Summary</h3>
<blockquote>
<strong>Subject: Q1 2026 Customer Satisfaction Report — Executive Summary</strong><br><br>
This report analyzes customer satisfaction data collected from 1,200 respondents across five regional offices during Q1 2026. Overall satisfaction scores declined by 8% compared to Q4 2025, with the largest drop recorded in the Northern Region (−14%).<br><br>
Key findings indicate that response time to customer inquiries is the primary driver of dissatisfaction, cited by 67% of low-satisfaction respondents. Product quality ratings, conversely, remained high at 88% positive.<br><br>
We recommend implementing a 24-hour response guarantee for all customer service channels by Q2 2026, and investing in a dedicated customer success team for the Northern Region.
</blockquote>',
            'duration_minutes' => 20, 'order_position' => 1, 'is_previewable' => true,
        ]);
        CourseLesson::create([
            'module_id' => $be1->id, 'title' => 'Business Proposal: Structure & Persuasion',
            'type' => 'text',
            'text_content' => '<h2>Writing a Winning Business Proposal</h2>
<h3>Standard Structure</h3>
<ol>
  <li><strong>Title Page:</strong> Project name, submitted by/to, date</li>
  <li><strong>Executive Summary</strong></li>
  <li><strong>Problem Statement:</strong> Clearly define the problem you are solving</li>
  <li><strong>Proposed Solution:</strong> Your approach, methodology, or product</li>
  <li><strong>Timeline & Deliverables:</strong> What will be delivered and when</li>
  <li><strong>Budget:</strong> Itemized cost breakdown</li>
  <li><strong>Why Us:</strong> Your company\'s qualifications and track record</li>
  <li><strong>Call to Action:</strong> Next steps and contact information</li>
</ol>
<h3>Persuasive Language Toolkit</h3>
<ul>
  <li>"Our solution has been proven to reduce costs by up to 30%..."</li>
  <li>"Unlike competitors who..., we offer..."</li>
  <li>"The return on investment is expected within [X] months..."</li>
  <li>"We are confident that this partnership will..."</li>
  <li>"We would welcome the opportunity to discuss this further at your earliest convenience."</li>
</ul>',
            'duration_minutes' => 22, 'order_position' => 2, 'is_previewable' => false,
        ]);

        $be2 = CourseModule::create([
            'course_id' => $bizEnglish->id, 'title' => 'Presentations & Public Speaking',
            'description' => 'Deliver impactful presentations with confidence and clarity.', 'order_position' => 2,
        ]);
        CourseLesson::create([
            'module_id' => $be2->id, 'title' => 'Structuring a Business Presentation',
            'type' => 'text',
            'text_content' => '<h2>The PEEL Presentation Structure</h2>
<ul>
  <li><strong>P — Preview:</strong> Tell the audience what you\'re going to tell them.</li>
  <li><strong>E — Explain:</strong> Present your main content with supporting data.</li>
  <li><strong>E — Example:</strong> Bring each point to life with a case study or story.</li>
  <li><strong>L — Link & Summary:</strong> Connect back to your main message and summarize.</li>
</ul>
<h3>Powerful Opening Lines</h3>
<ul>
  <li><strong>Question:</strong> "How many of you have experienced [problem]? This presentation will show you how to solve it permanently."</li>
  <li><strong>Statistic:</strong> "A 2024 McKinsey report found that 78% of employees feel disengaged at work. Today we\'ll explore why — and what your company can do about it."</li>
  <li><strong>Story:</strong> "Three years ago, one of our clients faced a crisis that nearly cost them everything. Here\'s what happened, and what they did next..."</li>
</ul>
<h3>Transition Phrases</h3>
<table border="1" cellpadding="6" style="border-collapse:collapse;width:100%">
  <tr><td>Moving to next point</td><td>"Now, let\'s turn to..." / "Building on that..."</td></tr>
  <tr><td>Emphasizing</td><td>"The key takeaway here is..." / "I want to highlight..."</td></tr>
  <tr><td>Summarizing</td><td>"In short..." / "To recap what we\'ve covered..."</td></tr>
  <tr><td>Concluding</td><td>"To bring everything together..." / "The bottom line is..."</td></tr>
</table>',
            'duration_minutes' => 18, 'order_position' => 1, 'is_previewable' => false,
        ]);
        CourseLesson::create([
            'module_id' => $be2->id, 'title' => 'Handling Q&A and Difficult Questions',
            'type' => 'text',
            'text_content' => '<h2>Q&A: Handling Challenging Questions Professionally</h2>
<h3>Useful Phrases for Any Situation</h3>
<table border="1" cellpadding="6" style="border-collapse:collapse;width:100%">
  <thead><tr><th>Situation</th><th>What to Say</th></tr></thead>
  <tbody>
    <tr><td>You don\'t know the answer</td><td>"That\'s a great question. I don\'t have the exact data right now, but I\'ll follow up with you directly after the session."</td></tr>
    <tr><td>The question is off-topic</td><td>"That\'s an interesting point. It\'s slightly outside the scope of today\'s presentation, but I\'d be happy to discuss it offline."</td></tr>
    <tr><td>A hostile question</td><td>"I appreciate you raising that concern. Let me address it directly..."</td></tr>
    <tr><td>You need thinking time</td><td>"Let me make sure I understand your question correctly — are you asking about [restate]?"</td></tr>
    <tr><td>Closing Q&A</td><td>"We have time for one more question... Thank you all — this has been a great discussion."</td></tr>
  </tbody>
</table>',
            'duration_minutes' => 14, 'order_position' => 2, 'is_previewable' => false,
        ]);

        $be3 = CourseModule::create([
            'course_id' => $bizEnglish->id, 'title' => 'Negotiation & Persuasion in English',
            'description' => 'Language and strategies for successful business negotiations.', 'order_position' => 3,
        ]);
        CourseLesson::create([
            'module_id' => $be3->id, 'title' => 'Negotiation Language: Making and Countering Offers',
            'type' => 'text',
            'text_content' => '<h2>Business Negotiation Phrases</h2>
<h3>Opening the Negotiation</h3>
<ul>
  <li>"We\'re hoping to reach a mutually beneficial agreement today."</li>
  <li>"Our position is that [state your key requirement]."</li>
  <li>"We\'d like to understand your priorities before we discuss specifics."</li>
</ul>
<h3>Making an Offer</h3>
<ul>
  <li>"We\'re prepared to offer [X] under the condition that [Y]."</li>
  <li>"Our initial proposal is [X], though we have some flexibility on the timeline."</li>
  <li>"We can commit to [X] if you can meet us on [Y]."</li>
</ul>
<h3>Countering</h3>
<ul>
  <li>"I appreciate the offer, but we were expecting something closer to [X]."</li>
  <li>"That\'s a reasonable starting point. Could you see your way to [improvement]?"</li>
  <li>"If you could move on [Y], we could reconsider our position on [X]."</li>
</ul>
<h3>Reaching Agreement</h3>
<ul>
  <li>"I think we can work with that."</li>
  <li>"Subject to legal review, I\'d say we have a deal."</li>
  <li>"Let\'s put that in writing and move forward."</li>
</ul>',
            'duration_minutes' => 20, 'order_position' => 1, 'is_previewable' => true,
        ]);

        // ── COURSE 4: English for Academic Purposes (EAP) ─────────────────────
        $eap = Course::create([
            'title'        => 'English for Academic Purposes (EAP) — University Preparation',
            'description'  => '<p>Prepare for academic life in an English-speaking university. This course develops the <strong>reading, writing, listening, and critical thinking skills</strong> required for lectures, seminars, essays, and research papers at the undergraduate and postgraduate level.</p>',
            'target_level' => 'Advanced',
            'is_published' => true,
            'price'        => 219000,
        ]);

        $e1 = CourseModule::create([
            'course_id' => $eap->id, 'title' => 'Academic Reading & Critical Analysis',
            'description' => 'How to read academic texts efficiently and think critically about arguments.', 'order_position' => 1,
        ]);
        CourseLesson::create([
            'module_id' => $e1->id, 'title' => 'Evaluating Sources: Credibility & Reliability',
            'type' => 'text',
            'text_content' => '<h2>Evaluating Academic Sources</h2>
<p>Use the <strong>CRAAP Test</strong> to evaluate any source before using it in academic writing:</p>
<table border="1" cellpadding="8" style="border-collapse:collapse;width:100%">
  <thead><tr><th>Criterion</th><th>Questions to Ask</th></tr></thead>
  <tbody>
    <tr><td><strong>C — Currency</strong></td><td>When was it published? Is it up to date for your topic?</td></tr>
    <tr><td><strong>R — Relevance</strong></td><td>Does it relate directly to your research question?</td></tr>
    <tr><td><strong>A — Authority</strong></td><td>Who wrote it? What are their credentials? Is it peer-reviewed?</td></tr>
    <tr><td><strong>A — Accuracy</strong></td><td>Is the information supported by evidence? Are sources cited?</td></tr>
    <tr><td><strong>P — Purpose</strong></td><td>Why was it written? Is there potential bias or conflict of interest?</td></tr>
  </tbody>
</table>
<h3>Source Hierarchy in Academic Writing</h3>
<ol>
  <li>Peer-reviewed journal articles (highest credibility)</li>
  <li>Academic books from established publishers</li>
  <li>Government and institutional reports</li>
  <li>Quality newspaper articles (for current events)</li>
  <li>Websites — use with caution; check authority carefully</li>
</ol>',
            'duration_minutes' => 16, 'order_position' => 1, 'is_previewable' => true,
        ]);
        CourseLesson::create([
            'module_id' => $e1->id, 'title' => 'Identifying Arguments: Claim, Evidence, Warrant',
            'type' => 'text',
            'text_content' => '<h2>The Claim-Evidence-Warrant Model</h2>
<p>Every academic argument consists of three parts (Toulmin\'s model):</p>
<ul>
  <li><strong>Claim:</strong> The main point or conclusion the author is making.</li>
  <li><strong>Evidence:</strong> The data, examples, or facts that support the claim.</li>
  <li><strong>Warrant:</strong> The logical connection that explains why the evidence supports the claim.</li>
</ul>
<h3>Example Analysis</h3>
<blockquote>
"Remote work significantly increases employee productivity <em>(claim)</em>, as demonstrated by a 2021 Stanford study in which home-based workers completed 13% more tasks per hour than their office counterparts <em>(evidence)</em>. This improvement is attributable to the elimination of commuting fatigue and the greater autonomy workers have over their schedules and environment <em>(warrant)</em>."
</blockquote>
<h3>Critical Reading Questions</h3>
<ol>
  <li>What is the author\'s main claim?</li>
  <li>What evidence supports it? Is the evidence sufficient and credible?</li>
  <li>Is there a logical connection between the evidence and the claim?</li>
  <li>What assumptions is the author making?</li>
  <li>What counterarguments are ignored or dismissed?</li>
</ol>',
            'duration_minutes' => 18, 'order_position' => 2, 'is_previewable' => false,
        ]);

        $e2 = CourseModule::create([
            'course_id' => $eap->id, 'title' => 'Academic Writing: Essays & Research Papers',
            'description' => 'From thesis statement to bibliography — writing academically with precision.', 'order_position' => 2,
        ]);
        CourseLesson::create([
            'module_id' => $e2->id, 'title' => 'Thesis Statements: The Foundation of Your Essay',
            'type' => 'text',
            'text_content' => '<h2>Writing a Strong Thesis Statement</h2>
<p>A thesis statement is a <strong>single, arguable sentence</strong> that states your main argument and signals to the reader how the essay is organized. It should appear at the end of your introduction.</p>
<h3>Characteristics of a Strong Thesis</h3>
<ul>
  <li>✅ <strong>Specific:</strong> Not vague or overly broad</li>
  <li>✅ <strong>Arguable:</strong> Someone could reasonably disagree</li>
  <li>✅ <strong>Focused:</strong> Covers only what the essay will address</li>
  <li>✅ <strong>Supported:</strong> Provable with evidence</li>
</ul>
<h3>Weak vs. Strong Thesis</h3>
<table border="1" cellpadding="8" style="border-collapse:collapse;width:100%">
  <tr><td>❌ Weak</td><td>"Social media has changed our lives." (too vague, not arguable)</td></tr>
  <tr><td>✅ Strong</td><td>"The proliferation of social media platforms has contributed to a measurable decline in adolescent mental health by normalizing social comparison and displacing face-to-face interaction."</td></tr>
  <tr><td>❌ Weak</td><td>"Climate change is a problem." (obvious, not arguable)</td></tr>
  <tr><td>✅ Strong</td><td>"Carbon taxes are the most economically efficient policy mechanism for reducing greenhouse gas emissions in industrialized nations, outperforming both cap-and-trade systems and direct regulation."</td></tr>
</table>',
            'duration_minutes' => 16, 'order_position' => 1, 'is_previewable' => false,
        ]);
        CourseLesson::create([
            'module_id' => $e2->id, 'title' => 'Paraphrasing, Summarizing & Avoiding Plagiarism',
            'type' => 'text',
            'text_content' => '<h2>Academic Integrity: Paraphrasing vs. Plagiarism</h2>
<h3>Original Source</h3>
<blockquote>"According to a 2020 WHO report, approximately 1 in 8 people globally live with a mental disorder, yet only a small fraction receive adequate treatment due to systemic underfunding and social stigma."</blockquote>
<h3>❌ Plagiarism (word-for-word, no citation)</h3>
<p>"Approximately 1 in 8 people globally live with a mental disorder, yet only a small fraction receive adequate treatment."</p>
<h3>❌ Inadequate paraphrase (only words changed)</h3>
<p>"About one in eight individuals around the world suffer from a mental illness, but few get proper treatment because of lack of funding and stigma (WHO, 2020)."</p>
<h3>✅ Proper paraphrase</h3>
<p>"Mental health disorders affect a significant proportion of the global population, yet the WHO (2020) notes that access to effective treatment remains severely limited — a consequence of chronic underfunding and widespread social stigma surrounding mental illness."</p>
<h3>Key Paraphrasing Steps</h3>
<ol>
  <li>Read and understand the source fully</li>
  <li>Set it aside and write from memory in your own words</li>
  <li>Change both vocabulary and sentence structure</li>
  <li>Always include an in-text citation</li>
  <li>Compare with the original to ensure you have not reproduced phrasing</li>
</ol>',
            'duration_minutes' => 20, 'order_position' => 2, 'is_previewable' => true,
        ]);

        $e3 = CourseModule::create([
            'course_id' => $eap->id, 'title' => 'Lecture Comprehension & Note-Taking',
            'description' => 'Strategies for following academic lectures and retaining key information.', 'order_position' => 3,
        ]);
        CourseLesson::create([
            'module_id' => $e3->id, 'title' => 'The Cornell Note-Taking System',
            'type' => 'text',
            'text_content' => '<h2>Cornell Notes for Academic Lectures</h2>
<p>The Cornell system divides your page into three sections:</p>
<pre style="background:#f5f5f5;padding:12px;border-radius:4px">
┌─────────────────────┬──────────────────────────────────────┐
│   CUE COLUMN        │         NOTE-TAKING AREA              │
│   (Keywords &       │  • Main ideas from the lecture         │
│   Questions)        │  • Evidence and examples               │
│   Add AFTER lecture │  • Don\'t write everything — key points │
├─────────────────────┴──────────────────────────────────────┤
│   SUMMARY (write within 24 hours)                          │
│   1–2 sentence summary of the main concepts in the section │
└─────────────────────────────────────────────────────────────┘
</pre>
<h3>During the Lecture: Key Abbreviations</h3>
<table border="1" cellpadding="6" style="border-collapse:collapse;width:100%">
  <tr><td>w/</td><td>with</td><td>→</td><td>leads to / therefore</td></tr>
  <tr><td>b/c</td><td>because</td><td>≠</td><td>not equal to / different from</td></tr>
  <tr><td>e.g.</td><td>for example</td><td>∴</td><td>therefore</td></tr>
  <tr><td>cf.</td><td>compare with</td><td>~</td><td>approximately</td></tr>
</table>
<h3>Signal Words to Listen For</h3>
<p>"More importantly..." | "In contrast..." | "To summarize..." | "The key point is..." | "For instance..." | "This is significant because..."</p>',
            'duration_minutes' => 16, 'order_position' => 1, 'is_previewable' => false,
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  EXAMS
    // ══════════════════════════════════════════════════════════════════════

    private function seedExams(): void
    {
        // ── EXAM A: IELTS Academic Writing Practice ───────────────────────────
        // (We simulate as MCQ/objective questions for system compatibility)
        $ieltsVocab = Exam::create([
            'exam_type_id'    => 2, // IELTS
            'title'           => 'IELTS Vocabulary & Grammar — Band 6.5 to 7.5',
            'total_duration'  => 25,
            'mode'            => 'practice',
            'is_active'       => true,
            'is_public'       => true,
            'tokens_required' => 1,
        ]);

        $iv_s1 = Section::create([
            'exam_id' => $ieltsVocab->id, 'title' => 'Academic Vocabulary in Context',
            'duration' => 12, 'description' => 'Select the word or phrase that best fits each sentence.',
            'order_position' => 1,
        ]);
        $iv_sub1 = Subsection::create([
            'section_id' => $iv_s1->id, 'title' => 'Vocabulary Questions',
            'instructions' => 'Choose the word that best completes the sentence in an academic context.',
            'order_position' => 1,
        ]);
        $iv_g1 = QuestionGroup::create([
            'subsection_id' => $iv_sub1->id, 'title' => 'Academic Word List Vocabulary',
            'instruction' => 'Select the most appropriate word for each sentence.', 'group_type' => 'standalone', 'order_position' => 1,
        ]);

        $this->mcq($iv_g1->id, 1, 'The study _____ a significant correlation between sleep deprivation and reduced cognitive performance.',
            ['indicated', 'told', 'said', 'spoke'], 0);
        $this->mcq($iv_g1->id, 2, 'The government implemented new policies to _____ the effects of air pollution in urban areas.',
            ['mitigate', 'magnify', 'generate', 'dismiss'], 0);
        $this->mcq($iv_g1->id, 3, 'Researchers found that the results were not _____ with previous findings in the field.',
            ['consistent', 'combined', 'collected', 'controlled'], 0);
        $this->mcq($iv_g1->id, 4, 'The professor asked students to _____ their arguments with empirical evidence.',
            ['substantiate', 'substitute', 'stimulate', 'suspend'], 0);
        $this->mcq($iv_g1->id, 5, 'Economic inequality has become a _____ issue in many developed nations.',
            ['prominent', 'private', 'peripheral', 'passive'], 0);
        $this->mcq($iv_g1->id, 6, 'The findings of the study _____ the effectiveness of the new treatment method.',
            ['demonstrated', 'demanded', 'declined', 'deferred'], 0);
        $this->mcq($iv_g1->id, 7, 'A _____ review of the literature reveals significant gaps in existing research.',
            ['comprehensive', 'comparative', 'complimentary', 'competitive'], 0);

        $iv_s2 = Section::create([
            'exam_id' => $ieltsVocab->id, 'title' => 'Grammar for Academic Writing',
            'duration' => 13, 'description' => 'Choose the grammatically correct option for academic contexts.',
            'order_position' => 2,
        ]);
        $iv_sub2 = Subsection::create([
            'section_id' => $iv_s2->id, 'title' => 'Grammar Questions',
            'instructions' => 'Select the grammatically correct version of each sentence.',
            'order_position' => 1,
        ]);
        $iv_g2 = QuestionGroup::create([
            'subsection_id' => $iv_sub2->id, 'title' => 'Academic Grammar',
            'instruction' => 'Choose the correct grammatical form.', 'group_type' => 'standalone', 'order_position' => 1,
        ]);

        $this->mcq($iv_g2->id, 1, 'Choose the correct passive construction: "The data _____ before the final report was submitted."',
            ['were analyzed', 'was analyzing', 'analyzed', 'have been analyzing'], 0);
        $this->mcq($iv_g2->id, 2, 'Which sentence uses a relative clause correctly?',
            ['The scientist, whose research focuses on genetics, was awarded the Nobel Prize.',
             'The scientist, which research focuses on genetics, was awarded the Nobel Prize.',
             'The scientist, who\'s research focuses on genetics, was awarded the Nobel Prize.',
             'The scientist, that research focuses on genetics, was awarded the Nobel Prize.'], 0);
        $this->mcq($iv_g2->id, 3, 'Select the correct conditional: "Had the researchers followed the correct protocol, the results _____ more reliable."',
            ['would have been', 'would be', 'will be', 'had been'], 0);
        $this->mcq($iv_g2->id, 4, '"Despite _____ extensively about the topic, the author fails to reach a clear conclusion." Choose the correct form.',
            ['writing', 'written', 'having written', 'have written'], 2);
        $this->mcq($iv_g2->id, 5, 'Which is the most formal and academically appropriate phrasing?',
            ['It seems that the hypothesis is incorrect.',
             'The hypothesis appears to be unsupported by the available evidence.',
             'I think the hypothesis is wrong.',
             'The hypothesis doesn\'t really work.'], 1);
        $this->mcq($iv_g2->id, 6, 'Choose the correct article usage: "_____ research published in Nature suggests that _____ cure may be found within a decade."',
            ['The / a', 'A / the', 'A / a', 'The / the'], 0);

        // ── EXAM B: TOEFL Listening Comprehension Practice ────────────────────
        $toeflListen = Exam::create([
            'exam_type_id'    => 3, // TOEFL
            'title'           => 'TOEFL iBT Listening — Academic Lectures Practice',
            'total_duration'  => 30,
            'mode'            => 'practice',
            'is_active'       => true,
            'is_public'       => true,
            'tokens_required' => 1,
        ]);

        $tl_s1 = Section::create([
            'exam_id' => $toeflListen->id, 'title' => 'Lecture 1: Environmental Science',
            'duration' => 15, 'description' => 'Questions based on an academic lecture about ocean acidification.',
            'order_position' => 1,
        ]);
        $tl_sub1 = Subsection::create([
            'section_id' => $tl_s1->id, 'title' => 'Ocean Acidification',
            'instructions' => 'Answer questions 1–6 based on the lecture content summarized below. In the actual exam, you would listen to the audio.',
            'order_position' => 1,
        ]);
        $tl_g1 = QuestionGroup::create([
            'subsection_id' => $tl_sub1->id, 'title' => 'Lecture: Ocean Acidification and Marine Ecosystems',
            'instruction' => 'Answer all questions based on what was stated or implied in the lecture.',
            'group_type' => 'passage',
            'passage_text' => '[Lecture Transcript Summary — Environmental Science]

Professor: Today we\'re continuing our unit on climate change, and I want to focus on a process that doesn\'t get as much attention as global warming but is equally alarming: ocean acidification.

So, the ocean absorbs about 30% of the carbon dioxide we release into the atmosphere. Now, this sounds like a good thing — the ocean is helping us out, right? Well, not quite. When CO₂ dissolves in seawater, it forms carbonic acid. This increases the acidity of the ocean — and since pre-industrial times, average ocean pH has already dropped from 8.2 to 8.1. That\'s a 26% increase in acidity, because pH is a logarithmic scale.

Now, why does this matter? Shell-forming organisms — corals, oysters, mussels, sea urchins — they build their shells and skeletons from calcium carbonate. But as the ocean becomes more acidic, carbonate ions become less available, making it harder and harder for these organisms to build and maintain their structures. At very high acidity levels, shells can actually begin to dissolve.

This has cascading effects through the food chain. Pteropods — tiny free-swimming sea snails — are a critical food source for salmon, herring, and many other commercially important fish. Lab studies have shown their shells dissolving within 45 days in water with acidity levels projected for the end of this century.

The economic implications are enormous. The global shellfish aquaculture industry is worth approximately $19 billion annually, and coral reefs support an estimated $375 billion in goods and services each year — including fisheries, tourism, and coastal protection.

The good news, if there is any, is that reducing CO₂ emissions will slow ocean acidification. But the ocean responds slowly — even if we stopped emitting today, existing CO₂ already dissolved would continue driving acidification for decades.',
            'order_position' => 1,
        ]);

        $this->mcq($tl_g1->id, 1, 'What is the professor\'s main purpose in this lecture?',
            ['To compare ocean acidification with global warming in terms of severity',
             'To explain the process and consequences of ocean acidification',
             'To argue that the ocean\'s absorption of CO₂ is beneficial',
             'To describe new government policies on carbon emissions'], 1);
        $this->mcq($tl_g1->id, 2, 'Why does the professor say the 0.1 pH drop represents a 26% increase in acidity?',
            ['Because the ocean has lost 26% of its carbonate ions',
             'Because pH is measured on a logarithmic scale',
             'Because 26% of marine organisms have already died',
             'Because the professor made an error — it should be 10%'], 1);
        $this->mcq($tl_g1->id, 3, 'What happens to shell-forming organisms in more acidic water?',
            ['They reproduce faster to compensate for shell loss',
             'They migrate to cooler, less acidic regions of the ocean',
             'They struggle to build and maintain their calcium carbonate structures',
             'They switch to silicon-based shell formation'], 2);
        $this->mcq($tl_g1->id, 4, 'Why does the professor mention pteropods?',
            ['To give an example of an organism that thrives in acidic water',
             'To illustrate the cascading impact on the food chain',
             'To compare them with coral reef organisms',
             'To show that lab studies are unreliable'], 1);
        $this->mcq($tl_g1->id, 5, 'What can be inferred from the professor\'s final statement?',
            ['Ocean acidification can be reversed quickly if emissions stop now',
             'There is no hope of stopping ocean acidification',
             'Reducing emissions will help, but the ocean\'s response is slow',
             'The professor believes existing solutions are sufficient'], 2);
        $this->mcq($tl_g1->id, 6, 'What is the estimated annual value of coral reef goods and services mentioned in the lecture?',
            ['$19 billion', '$375 billion', '$45 billion', '$300 billion'], 1);

        $tl_s2 = Section::create([
            'exam_id' => $toeflListen->id, 'title' => 'Lecture 2: Psychology',
            'duration' => 15, 'description' => 'Questions based on a psychology lecture about cognitive biases.',
            'order_position' => 2,
        ]);
        $tl_sub2 = Subsection::create([
            'section_id' => $tl_s2->id, 'title' => 'Cognitive Biases',
            'instructions' => 'Answer questions 7–12 based on the lecture content summarized below.',
            'order_position' => 1,
        ]);
        $tl_g2 = QuestionGroup::create([
            'subsection_id' => $tl_sub2->id, 'title' => 'Lecture: Cognitive Biases in Decision-Making',
            'instruction' => 'Answer all questions based on the lecture.',
            'group_type' => 'passage',
            'passage_text' => '[Lecture Transcript Summary — Psychology]

Professor: Last week we covered heuristics — the mental shortcuts our brains use to make quick decisions. Today I want to extend that into the territory of cognitive biases — the systematic errors in thinking that result from these shortcuts.

Let\'s start with the confirmation bias. This is probably the most pervasive cognitive bias there is. It refers to our tendency to search for, interpret, and remember information in a way that confirms our existing beliefs. If you believe that a particular medication works, you\'ll notice and remember the times it seemed to help, and explain away the times it didn\'t. This is one reason why anecdotal evidence is so unreliable — we\'re all unconsciously curating our own experience.

Next, anchoring bias. This occurs when we rely too heavily on the first piece of information we receive. Classic experiment: participants were asked to estimate the percentage of African nations in the UN. But first, a random number was spun on a wheel in front of them — 10 or 65. Participants who saw 65 gave estimates around 45%. Those who saw 10 gave estimates around 25%. A random number had a significant effect on their judgment.

The third one I want to cover today is the availability heuristic — or availability bias. We judge the probability of events based on how easily examples come to mind. After seeing news coverage of a plane crash, people massively overestimate the risk of flying, even though statistically, driving is far more dangerous. The ease with which we recall an event makes us think it\'s more common than it is.

Understanding these biases is valuable not just academically — it has real implications for medicine, law, finance, and public policy. Recognizing when our thinking might be biased is the first step toward making better decisions.',
            'order_position' => 1,
        ]);

        $this->mcq($tl_g2->id, 1, 'What is the professor\'s main topic in this lecture?',
            ['How heuristics help us make faster decisions', 'Common cognitive biases and their effects on decision-making',
             'Why anecdotal evidence should be used in research', 'The history of psychological research on memory'], 1);
        $this->mcq($tl_g2->id, 2, 'According to the professor, what is confirmation bias?',
            ['The tendency to change our beliefs when presented with contradicting evidence',
             'The tendency to seek and remember information that confirms our existing beliefs',
             'The tendency to make decisions based on the first number we see',
             'The tendency to misjudge probability based on memorable events'], 1);
        $this->mcq($tl_g2->id, 3, 'What does the UN/wheel experiment demonstrate?',
            ['That people cannot estimate percentages accurately',
             'That African nations are underrepresented in the UN',
             'That an unrelated number can significantly influence our judgments',
             'That random sampling produces better results'], 2);
        $this->mcq($tl_g2->id, 4, 'What example does the professor use to illustrate the availability bias?',
            ['People overestimating car accident rates after seeing a crash',
             'People overestimating flight risk after seeing news coverage of a plane crash',
             'People underestimating the effectiveness of medication',
             'People ignoring statistics about financial risk'], 1);
        $this->mcq($tl_g2->id, 5, 'What does the professor imply about cognitive biases?',
            ['They are impossible to overcome once formed',
             'They only affect people with poor education',
             'Being aware of them is an important first step toward better decision-making',
             'They are beneficial in professional settings'], 2);
        $this->mcq($tl_g2->id, 6, 'Which of the following is NOT mentioned as a field affected by cognitive biases?',
            ['Medicine', 'Law', 'Engineering', 'Finance'], 2);

        // ── EXAM C: TOEIC Vocabulary & Grammar Simulation ────────────────────
        $toeicGram = Exam::create([
            'exam_type_id'    => 1, // TOEIC
            'title'           => 'TOEIC Part 5 & 6 — Vocabulary & Grammar Simulation',
            'total_duration'  => 25,
            'mode'            => 'practice',
            'is_active'       => true,
            'is_public'       => true,
            'tokens_required' => 1,
        ]);

        $tg_s1 = Section::create([
            'exam_id' => $toeicGram->id, 'title' => 'Part 5: Incomplete Sentences',
            'duration' => 13, 'description' => 'Choose the word or phrase that best completes each sentence.',
            'order_position' => 1,
        ]);
        $tg_sub1 = Subsection::create([
            'section_id' => $tg_s1->id, 'title' => 'TOEIC Part 5 Questions',
            'instructions' => 'Choose the word or phrase that best completes each sentence.',
            'order_position' => 1,
        ]);
        $tg_g1 = QuestionGroup::create([
            'subsection_id' => $tg_sub1->id, 'title' => 'Incomplete Sentences',
            'instruction' => 'Select the best word or phrase to complete each sentence.', 'group_type' => 'standalone', 'order_position' => 1,
        ]);

        $this->mcq($tg_g1->id, 1, 'The annual report will be _____ to all shareholders by the end of this month.',
            ['distributed', 'distributing', 'distribution', 'distribute'], 0);
        $this->mcq($tg_g1->id, 2, 'Please ensure that all equipment is _____ stored at the end of each shift.',
            ['proper', 'properly', 'propriety', 'properties'], 1);
        $this->mcq($tg_g1->id, 3, 'The new product launch was _____ due to supply chain disruptions.',
            ['postponed', 'postponing', 'postpone', 'postponement'], 0);
        $this->mcq($tg_g1->id, 4, 'Ms. Kim has been _____ for the regional manager position since last quarter.',
            ['considered', 'consideration', 'considerable', 'considering'], 0);
        $this->mcq($tg_g1->id, 5, '_____ the budget constraints, the team managed to deliver an exceptional final product.',
            ['Despite', 'Although', 'However', 'Nevertheless'], 0);
        $this->mcq($tg_g1->id, 6, 'The client was _____ impressed by the quality of the presentation.',
            ['particularly', 'particular', 'particulars', 'particulate'], 0);
        $this->mcq($tg_g1->id, 7, 'Our company _____ its operations to Southeast Asia over the next two years.',
            ['will expand', 'expanded', 'expanding', 'has expanded'], 0);
        $this->mcq($tg_g1->id, 8, 'All staff members are required to _____ a mandatory safety training session.',
            ['attend', 'attending', 'attendance', 'attends'], 0);

        $tg_s2 = Section::create([
            'exam_id' => $toeicGram->id, 'title' => 'Part 6: Text Completion',
            'duration' => 12, 'description' => 'Read the email and choose the best word for each blank.',
            'order_position' => 2,
        ]);
        $tg_sub2 = Subsection::create([
            'section_id' => $tg_s2->id, 'title' => 'TOEIC Part 6 Questions',
            'instructions' => 'Read the following business text and select the best answer for each numbered blank.',
            'order_position' => 1,
        ]);
        $tg_g2 = QuestionGroup::create([
            'subsection_id' => $tg_sub2->id, 'title' => 'Business Email Completion',
            'instruction' => 'Choose the best word or phrase for each blank in the email.',
            'group_type' => 'passage',
            'passage_text' => 'To: All Department Heads
From: Sarah Whitmore, HR Director
Subject: Upcoming Performance Review Cycle

Dear Team,

I am writing to inform you that the annual performance review cycle will (1)_____ on July 1st and conclude on July 31st. All department heads are (2)_____ to complete evaluations for each member of their team within this period.

Please note that the new performance management platform has been (3)_____ updated, and all reviews must be submitted digitally this year. Paper submissions will no longer be accepted. Training sessions on the new system will be held on June 20th and June 22nd in Conference Room B.

If you have any questions or require (4)_____ support with the platform, please do not hesitate to contact the HR department directly.

We appreciate your (5)_____ in this important process.

Best regards,
Sarah Whitmore',
            'order_position' => 1,
        ]);

        $this->mcq($tg_g2->id, 1, 'Choose the best word for blank (1): "...will (1)_____ on July 1st"',
            ['commence', 'finish', 'cancel', 'postpone'], 0);
        $this->mcq($tg_g2->id, 2, 'Choose the best word for blank (2): "All department heads are (2)_____ to complete evaluations"',
            ['required', 'optional', 'suggested', 'encouraged'], 0);
        $this->mcq($tg_g2->id, 3, 'Choose the best word for blank (3): "the new platform has been (3)_____ updated"',
            ['recently', 'rarely', 'temporarily', 'seldom'], 0);
        $this->mcq($tg_g2->id, 4, 'Choose the best word for blank (4): "require (4)_____ support"',
            ['additional', 'addition', 'add', 'adding'], 0);
        $this->mcq($tg_g2->id, 5, 'Choose the best word for blank (5): "We appreciate your (5)_____ in this important process."',
            ['cooperation', 'cooperate', 'cooperating', 'cooperative'], 0);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  HELPER
    // ══════════════════════════════════════════════════════════════════════

    private function mcq(int $groupId, int $order, string $questionText, array $options, int $correctIndex): void
    {
        $question = Question::create([
            'question_group_id' => $groupId,
            'type'              => 'multiple_choice',
            'question_text'     => $questionText,
            'points'            => 1,
            'order_position'    => $order,
        ]);
        foreach ($options as $i => $text) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $text,
                'is_correct'  => $i === $correctIndex,
            ]);
        }
    }
}
