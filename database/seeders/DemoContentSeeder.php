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

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCourses();
        $this->seedExams();
        $this->command->info('✅ Demo content seeded: 3 Courses, 3 Exams with questions.');
    }

    // ══════════════════════════════════════════════════════
    //  COURSES
    // ══════════════════════════════════════════════════════

    private function seedCourses(): void
    {
        // ── COURSE A: IELTS Academic Preparation ──────────────────────────────
        $ielts = Course::create([
            'title'        => 'IELTS Academic — Band 7+ Complete Preparation',
            'description'  => '<p>A comprehensive preparation course for the <strong>IELTS Academic</strong> test. Learn proven strategies for all four skills — Listening, Reading, Writing, and Speaking — and target a <strong>Band 7 or higher</strong>.</p><p>Each module mirrors real exam conditions with authentic practice materials and detailed explanations.</p>',
            'target_level' => 'Intermediate',
            'is_published' => true,
            'price'        => 199000,
        ]);

        // Module 1
        $a1 = CourseModule::create([
            'course_id'      => $ielts->id,
            'title'          => 'Understanding the IELTS Academic Test',
            'description'    => 'Overview of the test format, scoring bands, and study strategy.',
            'order_position' => 1,
        ]);
        CourseLesson::create([
            'module_id'        => $a1->id,
            'title'            => 'Course Introduction & Study Plan',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=7_G9t4eLkrE',
            'duration_minutes' => 10,
            'order_position'   => 1,
            'is_previewable'   => true,
        ]);
        CourseLesson::create([
            'module_id'        => $a1->id,
            'title'            => 'IELTS Band Descriptors Explained',
            'type'             => 'text',
            'text_content'     => '<h2>How IELTS Bands Work</h2>
<p>IELTS uses a <strong>9-band scale</strong> to report results. Each band corresponds to a specific level of English competence.</p>
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%">
  <thead><tr><th>Band</th><th>Level</th><th>Description</th></tr></thead>
  <tbody>
    <tr><td>9</td><td>Expert User</td><td>Full operational command of the language.</td></tr>
    <tr><td>8</td><td>Very Good User</td><td>Fully operational command with only occasional unsystematic inaccuracies.</td></tr>
    <tr><td>7</td><td>Good User</td><td>Operational command with occasional inaccuracies in unfamiliar situations.</td></tr>
    <tr><td>6</td><td>Competent User</td><td>Generally effective command despite some inaccuracies and misunderstandings.</td></tr>
    <tr><td>5</td><td>Modest User</td><td>Partial command; copes with overall meaning in most situations.</td></tr>
  </tbody>
</table>
<h3>Score Calculation</h3>
<p>Your overall band score is the <strong>average of the four section scores</strong>, rounded to the nearest 0.5.</p>
<blockquote>Example: L=7.5 | R=7.0 | W=6.5 | S=7.0 → Average = 7.0</blockquote>',
            'duration_minutes' => 12,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);

        // Module 2
        $a2 = CourseModule::create([
            'course_id'      => $ielts->id,
            'title'          => 'IELTS Listening Strategies',
            'description'    => 'Master the four listening sections with effective note-taking and prediction techniques.',
            'order_position' => 2,
        ]);
        CourseLesson::create([
            'module_id'        => $a2->id,
            'title'            => 'Listening Section: Format & Question Types',
            'type'             => 'text',
            'text_content'     => '<h2>IELTS Listening: Structure</h2>
<p>The Listening section has <strong>4 parts, 40 questions</strong>, and lasts approximately <strong>30 minutes</strong> (+ 10 minutes transfer time).</p>
<ul>
  <li><strong>Part 1:</strong> Conversation between two speakers in a social context (e.g., booking, enquiries).</li>
  <li><strong>Part 2:</strong> Monologue in a social context (e.g., a speech or announcement).</li>
  <li><strong>Part 3:</strong> Conversation between up to four people in an educational or training context.</li>
  <li><strong>Part 4:</strong> Academic monologue (e.g., a university lecture).</li>
</ul>
<h3>Top 5 Listening Strategies</h3>
<ol>
  <li>Read the questions <em>before</em> you listen to predict what information to listen for.</li>
  <li>Use abbreviations in your notes (e.g., w/ = with, → = leads to, # = number).</li>
  <li>Answer as you listen — do not wait until the audio ends.</li>
  <li>Check spelling carefully during the transfer time.</li>
  <li>Do not leave blank answers; a wrong answer costs nothing.</li>
</ol>',
            'duration_minutes' => 14,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);
        CourseLesson::create([
            'module_id'        => $a2->id,
            'title'            => 'Practice: Completing Notes & Forms',
            'type'             => 'text',
            'text_content'     => '<h2>Note Completion Practice</h2>
<p>Note completion requires you to fill in missing information from what you hear. The answers are always in the order they appear in the audio.</p>
<h3>Sample Task</h3>
<blockquote>
<strong>Library Membership Form</strong><br>
Name: Jane _____ (1)<br>
Membership type: _____ (2)<br>
Start date: _____ March (3)<br>
Annual fee: £ _____ (4)
</blockquote>
<p><em>Tip: Predict the type of answer — (1) is likely a surname, (2) is a category, (3) is a number, (4) is a price.</em></p>
<p><strong>Answer Key:</strong> (1) Wilkinson &nbsp;|&nbsp; (2) Student &nbsp;|&nbsp; (3) 15th &nbsp;|&nbsp; (4) 35</p>',
            'duration_minutes' => 20,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        // Module 3
        $a3 = CourseModule::create([
            'course_id'      => $ielts->id,
            'title'          => 'IELTS Reading Techniques',
            'description'    => 'Time management, passage navigation, and tackling all 14 question types.',
            'order_position' => 3,
        ]);
        CourseLesson::create([
            'module_id'        => $a3->id,
            'title'            => 'True / False / Not Given — The Key Differences',
            'type'             => 'text',
            'text_content'     => '<h2>True / False / Not Given</h2>
<p>This is one of the most commonly misunderstood question types. Here is the clear distinction:</p>
<ul>
  <li><strong>TRUE:</strong> The statement agrees with the information in the passage.</li>
  <li><strong>FALSE:</strong> The statement contradicts the information in the passage.</li>
  <li><strong>NOT GIVEN:</strong> The information is not mentioned at all in the passage.</li>
</ul>
<h3>Example</h3>
<p><em>Passage excerpt:</em> "The Amazon rainforest absorbs approximately 2 billion tonnes of CO₂ per year."</p>
<table border="1" cellpadding="6" style="border-collapse:collapse;width:100%">
  <tr><td>The Amazon helps reduce atmospheric carbon.</td><td><strong>TRUE</strong> ✅</td></tr>
  <tr><td>The Amazon releases more CO₂ than it absorbs.</td><td><strong>FALSE</strong> ❌</td></tr>
  <tr><td>The Amazon covers 60% of South America.</td><td><strong>NOT GIVEN</strong> ❓</td></tr>
</table>',
            'duration_minutes' => 15,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);
        CourseLesson::create([
            'module_id'        => $a3->id,
            'title'            => 'Reading Practice: Technology & Society',
            'type'             => 'text',
            'text_content'     => '<h2>Reading Passage: The Digital Divide</h2>
<p>The term "digital divide" refers to the gap between individuals and communities that have access to modern information and communication technologies and those that do not. This disparity is particularly evident between developed and developing nations, but it also exists within countries — between urban and rural populations, between different age groups, and across socioeconomic lines.</p>
<p>Access to the internet has become increasingly important for education, employment, healthcare, and civic participation. Studies suggest that individuals without reliable internet connectivity are significantly disadvantaged in the job market, as an estimated 80% of job applications now require some form of online submission. Furthermore, students without home internet access are twice as likely to fall behind academically compared to their connected peers.</p>
<p>Governments and NGOs have proposed various solutions, including subsidized broadband programs, community Wi-Fi initiatives, and digital literacy training. However, critics argue that simply providing access is insufficient if individuals lack the skills to use technology effectively.</p>
<h3>Practice Questions</h3>
<ol>
  <li>The digital divide only exists between nations. <strong>[FALSE]</strong></li>
  <li>Internet access affects job application success. <strong>[TRUE]</strong></li>
  <li>The majority of governments have funded broadband programs. <strong>[NOT GIVEN]</strong></li>
</ol>',
            'duration_minutes' => 25,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        // Module 4
        $a4 = CourseModule::create([
            'course_id'      => $ielts->id,
            'title'          => 'IELTS Writing — Task 1 & Task 2',
            'description'    => 'Structured templates and model answers for both writing tasks.',
            'order_position' => 4,
        ]);
        CourseLesson::create([
            'module_id'        => $a4->id,
            'title'            => 'Task 1: Describing a Bar Chart',
            'type'             => 'text',
            'text_content'     => '<h2>Task 1: Bar Chart Model Answer</h2>
<h3>Task Prompt</h3>
<p><em>The chart below shows the percentage of students choosing different subjects at a UK university in 2010 and 2020. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</em></p>
<h3>Model Answer (Band 7+)</h3>
<p>The bar chart compares the proportion of students enrolled in five academic subjects at a UK university across two years, 2010 and 2020.</p>
<p>Overall, Business and Computer Science saw the most significant growth over the decade, while the popularity of the Arts declined considerably. Engineering remained relatively stable throughout the period.</p>
<p>In 2010, the Arts attracted the highest proportion of students at 35%, followed by Business at 28%. By 2020, however, Business had overtaken all other subjects, rising sharply to 42%. Computer Science similarly surged from 10% to 25%, reflecting the growing demand for technology-related careers.</p>
<p>In contrast, the percentage of students studying the Arts fell dramatically from 35% to just 18%. Science experienced a more modest decline, dropping from 20% to 15%, while Engineering held steady at approximately 12% in both years.</p>
<p><em>Word count: ~155 words</em></p>',
            'duration_minutes' => 20,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);
        CourseLesson::create([
            'module_id'        => $a4->id,
            'title'            => 'Task 2: Discussion Essay — Band 7 Template',
            'type'             => 'text',
            'text_content'     => '<h2>Task 2: Discussion Essay Template</h2>
<h3>Structure (4 paragraphs, 250–280 words)</h3>
<ol>
  <li><strong>Introduction:</strong> Paraphrase the topic + state that you will discuss both views + your opinion.</li>
  <li><strong>Body 1:</strong> First view — topic sentence + reason + example + link back.</li>
  <li><strong>Body 2:</strong> Second view — topic sentence + reason + example + link back.</li>
  <li><strong>Conclusion:</strong> Summary of both views + restate your opinion.</li>
</ol>
<h3>Sample Prompt</h3>
<blockquote>Some people believe that technology has made us more productive. Others think it has caused more distractions. Discuss both views and give your own opinion.</blockquote>
<h3>Introduction Template</h3>
<blockquote>In recent years, the role of technology in everyday life has sparked considerable debate. While some argue that digital tools significantly enhance individual productivity, others contend that the constant connectivity that technology enables is a source of considerable distraction. This essay will examine both perspectives before concluding that, on balance, technology is more beneficial than harmful when used with discipline.</blockquote>
<p><em>Tip: Aim for 3 sentences in the introduction. Never copy the question word-for-word.</em></p>',
            'duration_minutes' => 18,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);

        // ── COURSE B: TOEFL iBT Complete Course ───────────────────────────────
        $toefl = Course::create([
            'title'        => 'TOEFL iBT — Score 90+ Complete Preparation',
            'description'  => '<p>Master every section of the <strong>TOEFL iBT</strong> with structured video lessons, academic reading passages, note-taking drills, and integrated writing practice. Designed for learners targeting a total score of <strong>90 or above</strong>.</p>',
            'target_level' => 'Intermediate',
            'is_published' => true,
            'price'        => 249000,
        ]);

        $b1 = CourseModule::create([
            'course_id'      => $toefl->id,
            'title'          => 'TOEFL iBT: Format, Registration & Strategy',
            'description'    => 'Everything you need to know before you start preparing.',
            'order_position' => 1,
        ]);
        CourseLesson::create([
            'module_id'        => $b1->id,
            'title'            => 'Welcome to the TOEFL iBT Course',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=7_G9t4eLkrE',
            'duration_minutes' => 8,
            'order_position'   => 1,
            'is_previewable'   => true,
        ]);
        CourseLesson::create([
            'module_id'        => $b1->id,
            'title'            => 'TOEFL iBT Test Structure Overview',
            'type'             => 'text',
            'text_content'     => '<h2>TOEFL iBT: At a Glance</h2>
<table border="1" cellpadding="8" style="border-collapse:collapse;width:100%">
  <thead><tr><th>Section</th><th>Duration</th><th>Questions/Tasks</th><th>Score</th></tr></thead>
  <tbody>
    <tr><td>Reading</td><td>~35 min</td><td>2 passages, 10 questions each</td><td>0–30</td></tr>
    <tr><td>Listening</td><td>~36 min</td><td>3 lectures + 2 conversations</td><td>0–30</td></tr>
    <tr><td>Speaking</td><td>~16 min</td><td>4 tasks (1 independent + 3 integrated)</td><td>0–30</td></tr>
    <tr><td>Writing</td><td>~29 min</td><td>2 tasks (integrated + academic discussion)</td><td>0–30</td></tr>
  </tbody>
</table>
<h3>Score Ranges & University Requirements</h3>
<ul>
  <li><strong>90–100:</strong> Accepted by most competitive universities worldwide.</li>
  <li><strong>80–89:</strong> Sufficient for many graduate programs.</li>
  <li><strong>60–79:</strong> Minimum for undergraduate programs at some institutions.</li>
</ul>
<p>The TOEFL iBT is offered year-round at test centers and as a <strong>TOEFL iBT Home Edition</strong>.</p>',
            'duration_minutes' => 10,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);

        $b2 = CourseModule::create([
            'course_id'      => $toefl->id,
            'title'          => 'TOEFL Reading: Academic Passage Mastery',
            'description'    => 'Understand academic texts and answer all question types confidently.',
            'order_position' => 2,
        ]);
        CourseLesson::create([
            'module_id'        => $b2->id,
            'title'            => 'Reading Question Types: A Complete Guide',
            'type'             => 'text',
            'text_content'     => '<h2>TOEFL Reading Question Types</h2>
<p>There are <strong>10 question types</strong> in the TOEFL Reading section. Here are the most common:</p>
<ol>
  <li><strong>Factual Information:</strong> "According to paragraph 2, what is…?" — Find specific details in the text.</li>
  <li><strong>Negative Factual:</strong> "Which of the following is NOT mentioned…?" — Eliminate three true statements.</li>
  <li><strong>Inference:</strong> "What can be inferred about…?" — Draw logical conclusions from implied information.</li>
  <li><strong>Vocabulary:</strong> "The word X in paragraph 3 is closest in meaning to…?" — Use context clues.</li>
  <li><strong>Reference:</strong> "The word \'it\' in paragraph 4 refers to…?" — Identify pronoun antecedents.</li>
  <li><strong>Sentence Simplification:</strong> Choose a sentence that has the same essential information.</li>
  <li><strong>Insert a Sentence:</strong> Where would the following sentence best fit in the passage?</li>
  <li><strong>Prose Summary:</strong> Select 3 of 6 statements that summarize the main points (worth 2 points).</li>
</ol>
<p><em>Pro tip: The Prose Summary question is worth the most points — never skip it!</em></p>',
            'duration_minutes' => 18,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);
        CourseLesson::create([
            'module_id'        => $b2->id,
            'title'            => 'Academic Passage: Plate Tectonics',
            'type'             => 'text',
            'text_content'     => '<h2>Reading Passage: Plate Tectonics</h2>
<p>The theory of plate tectonics, which describes the large-scale motion of Earth\'s lithospheric plates, represents one of the most significant advances in the history of Earth science. Proposed in its modern form in the 1960s, the theory unified several previously separate fields of geological inquiry, including the study of earthquakes, volcanoes, and mountain building.</p>
<p>Earth\'s outer shell, the lithosphere, is divided into several large and many smaller plates that float on the semi-fluid asthenosphere beneath. These plates move at rates of a few centimetres per year — roughly the speed at which human fingernails grow. At divergent boundaries, plates move apart, and new oceanic crust is formed as magma rises from below. At convergent boundaries, one plate is forced beneath another in a process called subduction, which is responsible for deep ocean trenches and volcanic arcs. Transform boundaries, where plates slide horizontally past each other, are the site of major earthquakes such as those along the San Andreas Fault in California.</p>
<h3>Practice Question</h3>
<p><strong>Q:</strong> The word "unified" in paragraph 1 is closest in meaning to:</p>
<ul>
  <li>(A) separated</li>
  <li>(B) combined ✅</li>
  <li>(C) improved</li>
  <li>(D) described</li>
</ul>',
            'duration_minutes' => 22,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        $b3 = CourseModule::create([
            'course_id'      => $toefl->id,
            'title'          => 'TOEFL Writing: Integrated & Academic Discussion',
            'description'    => 'Templates and scored sample responses for both writing tasks.',
            'order_position' => 3,
        ]);
        CourseLesson::create([
            'module_id'        => $b3->id,
            'title'            => 'Integrated Writing: Read, Listen, Synthesize',
            'type'             => 'text',
            'text_content'     => '<h2>Integrated Writing Task Guide</h2>
<h3>What You Will Do</h3>
<ol>
  <li>Read a passage (3 minutes) on an academic topic.</li>
  <li>Listen to a lecture (2–3 minutes) that relates to the passage.</li>
  <li>Write a 150–225 word response summarizing how the lecture <strong>supports or challenges</strong> the reading.</li>
</ol>
<h3>Response Template</h3>
<blockquote>
The reading passage argues that [main claim of passage]. However, the lecture casts doubt on this by [main counter-point of lecture].<br><br>
First, the reading claims that [point 1 from reading]. The lecturer refutes this by pointing out that [counter-argument 1].<br><br>
Second, while the passage states [point 2 from reading], the professor challenges this idea, explaining that [counter-argument 2].<br><br>
Finally, the reading suggests [point 3 from reading]. The lecture, however, provides evidence that [counter-argument 3].
</blockquote>
<p><em>Important: Do NOT include your own opinion in the integrated task. Summarize only what the reading and lecture say.</em></p>',
            'duration_minutes' => 20,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);
        CourseLesson::create([
            'module_id'        => $b3->id,
            'title'            => 'Academic Discussion Writing: Tips & Sample',
            'type'             => 'text',
            'text_content'     => '<h2>Academic Discussion Writing Task</h2>
<p>You will read an online classroom discussion between a professor and two students, then add your own response (minimum 100 words) that clearly expresses and supports your opinion.</p>
<h3>Scoring Criteria</h3>
<ul>
  <li><strong>Relevant contribution:</strong> Does your response directly address the discussion topic?</li>
  <li><strong>Coherent argument:</strong> Is your reasoning logical and well-supported?</li>
  <li><strong>Language precision:</strong> Is your language clear, varied, and grammatically accurate?</li>
</ul>
<h3>Sample Prompt</h3>
<blockquote>
<em>Professor: This week, we are discussing remote work. Do you think working remotely is more productive than working in an office? Why or why not?</em>
</blockquote>
<h3>Sample Response (Score 4/5)</h3>
<p>I believe remote work can be significantly more productive than traditional office settings, primarily because it eliminates commuting time and allows individuals to create a personalized work environment. Research from Stanford University found that remote employees were 13% more productive than their office counterparts. Furthermore, flexible hours enable people to work during their peak performance times. However, I acknowledge Michael\'s point that collaboration can suffer — this is why effective remote teams rely on regular video meetings and digital communication tools to maintain cohesion.</p>',
            'duration_minutes' => 18,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);

        // ── COURSE C: Everyday English Communication ───────────────────────────
        $everyday = Course::create([
            'title'        => 'Everyday English Communication — From Beginner to Confident',
            'description'  => '<p>Build real-world English communication skills from the ground up. This course covers practical vocabulary, grammar essentials, and conversation strategies you can use immediately in daily life, travel, and the workplace.</p>',
            'target_level' => 'Beginner',
            'is_published' => true,
            'price'        => 99000,
        ]);

        $c1 = CourseModule::create([
            'course_id'      => $everyday->id,
            'title'          => 'Essential Vocabulary for Daily Life',
            'description'    => 'Core vocabulary sets for shopping, transport, health, and work.',
            'order_position' => 1,
        ]);
        CourseLesson::create([
            'module_id'        => $c1->id,
            'title'            => 'Welcome & How to Use This Course',
            'type'             => 'video',
            'content_url'      => 'https://www.youtube.com/watch?v=7_G9t4eLkrE',
            'duration_minutes' => 5,
            'order_position'   => 1,
            'is_previewable'   => true,
        ]);
        CourseLesson::create([
            'module_id'        => $c1->id,
            'title'            => 'Shopping Vocabulary: In a Store',
            'type'             => 'text',
            'text_content'     => '<h2>Shopping English — Essential Phrases</h2>
<h3>Key Vocabulary</h3>
<table border="1" cellpadding="8" style="border-collapse:collapse;width:100%">
  <thead><tr><th>English</th><th>Example Sentence</th></tr></thead>
  <tbody>
    <tr><td>receipt</td><td>"Could I have a receipt, please?"</td></tr>
    <tr><td>discount</td><td>"Is there a discount on this item?"</td></tr>
    <tr><td>refund</td><td>"I\'d like a refund for this product."</td></tr>
    <tr><td>fitting room</td><td>"Where is the fitting room?"</td></tr>
    <tr><td>out of stock</td><td>"I\'m sorry, this size is out of stock."</td></tr>
  </tbody>
</table>
<h3>Common Dialogues</h3>
<p><strong>Customer:</strong> "Excuse me, do you have this in a medium?"<br>
<strong>Staff:</strong> "Let me check the stockroom for you."<br>
<strong>Customer:</strong> "Great, thank you. And is this on sale?"<br>
<strong>Staff:</strong> "Yes, it\'s 20% off this week!"</p>',
            'duration_minutes' => 12,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);
        CourseLesson::create([
            'module_id'        => $c1->id,
            'title'            => 'Health & Medical Vocabulary',
            'type'             => 'text',
            'text_content'     => '<h2>Health English — Talking to a Doctor</h2>
<h3>Describing Symptoms</h3>
<ul>
  <li>"I have a headache." / "I have a stomachache."</li>
  <li>"I feel dizzy." / "I feel nauseous."</li>
  <li>"I have been coughing for three days."</li>
  <li>"My throat is sore."</li>
  <li>"I have a high fever — 39 degrees."</li>
</ul>
<h3>At the Pharmacy</h3>
<p><strong>Patient:</strong> "I have a bad cold. What do you recommend?"<br>
<strong>Pharmacist:</strong> "I suggest a decongestant and some vitamin C tablets. Take two tablets every eight hours with food."<br>
<strong>Patient:</strong> "Do I need a prescription for this?"<br>
<strong>Pharmacist:</strong> "No, these are available over the counter."</p>
<h3>Key Words</h3>
<p>prescription | over-the-counter | dosage | side effects | allergic | symptom | diagnosis | treatment</p>',
            'duration_minutes' => 15,
            'order_position'   => 3,
            'is_previewable'   => false,
        ]);

        $c2 = CourseModule::create([
            'course_id'      => $everyday->id,
            'title'          => 'Grammar for Communication',
            'description'    => 'The most important grammar rules explained simply with practical examples.',
            'order_position' => 2,
        ]);
        CourseLesson::create([
            'module_id'        => $c2->id,
            'title'            => 'Present Tenses: Simple vs Continuous',
            'type'             => 'text',
            'text_content'     => '<h2>Present Simple vs Present Continuous</h2>
<h3>Present Simple — for habits & facts</h3>
<p>Use the present simple for <strong>routines, habits, and general truths</strong>.</p>
<ul>
  <li>"She <strong>works</strong> in a hospital." (permanent job)</li>
  <li>"Water <strong>boils</strong> at 100°C." (scientific fact)</li>
  <li>"I <strong>drink</strong> coffee every morning." (habit)</li>
</ul>
<h3>Present Continuous — for now & temporary</h3>
<p>Use the present continuous for <strong>actions happening right now or around this time</strong>.</p>
<ul>
  <li>"She <strong>is working</strong> from home this week." (temporary)</li>
  <li>"I <strong>am studying</strong> for my exam right now." (this moment)</li>
  <li>"They <strong>are building</strong> a new shopping center near my house." (in progress)</li>
</ul>
<h3>Quick Test</h3>
<p>Choose the correct form:</p>
<ol>
  <li>He _____ (play/is playing) tennis every Sunday. → <strong>plays</strong></li>
  <li>Listen! The baby _____ (cry/is crying). → <strong>is crying</strong></li>
  <li>Water _____ (freeze/is freezing) at 0°C. → <strong>freezes</strong></li>
</ol>',
            'duration_minutes' => 18,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);
        CourseLesson::create([
            'module_id'        => $c2->id,
            'title'            => 'Modal Verbs: can, could, should, must',
            'type'             => 'text',
            'text_content'     => '<h2>Modal Verbs: Usage Guide</h2>
<table border="1" cellpadding="8" style="border-collapse:collapse;width:100%">
  <thead><tr><th>Modal</th><th>Use</th><th>Example</th></tr></thead>
  <tbody>
    <tr><td><strong>can</strong></td><td>Ability (present)</td><td>"I can speak three languages."</td></tr>
    <tr><td><strong>could</strong></td><td>Ability (past) / Polite request</td><td>"Could you help me, please?"</td></tr>
    <tr><td><strong>should</strong></td><td>Advice / Recommendation</td><td>"You should see a doctor."</td></tr>
    <tr><td><strong>must</strong></td><td>Strong obligation / Necessity</td><td>"You must wear a seatbelt."</td></tr>
    <tr><td><strong>might</strong></td><td>Possibility</td><td>"It might rain tomorrow."</td></tr>
    <tr><td><strong>would</strong></td><td>Polite offer / Conditional</td><td>"I would like a coffee, please."</td></tr>
  </tbody>
</table>
<h3>Common Mistakes</h3>
<ul>
  <li>❌ "You must to study." → ✅ "You must study." (No "to" after modals)</li>
  <li>❌ "She cans swim." → ✅ "She can swim." (No -s after modals)</li>
</ul>',
            'duration_minutes' => 16,
            'order_position'   => 2,
            'is_previewable'   => false,
        ]);

        $c3 = CourseModule::create([
            'course_id'      => $everyday->id,
            'title'          => 'Workplace & Professional English',
            'description'    => 'Emails, meetings, presentations, and office communication.',
            'order_position' => 3,
        ]);
        CourseLesson::create([
            'module_id'        => $c3->id,
            'title'            => 'Writing Professional Emails',
            'type'             => 'text',
            'text_content'     => '<h2>Professional Email Guide</h2>
<h3>Email Structure</h3>
<ol>
  <li><strong>Subject Line:</strong> Clear and specific (e.g., "Meeting Request — Project Alpha, June 20")</li>
  <li><strong>Greeting:</strong> "Dear Mr./Ms. [Last Name]," or "Dear [First Name]," (for informal)</li>
  <li><strong>Opening:</strong> "I hope this email finds you well." / "Thank you for your quick response."</li>
  <li><strong>Body:</strong> State your purpose clearly. One idea per paragraph.</li>
  <li><strong>Call to Action:</strong> "Please let me know if you have any questions." / "I look forward to your reply."</li>
  <li><strong>Closing:</strong> "Best regards," / "Sincerely," / "Kind regards,"</li>
</ol>
<h3>Sample Email</h3>
<blockquote>
Subject: Request for Project Update — Q2 Report<br><br>
Dear Ms. Johnson,<br><br>
I hope you are doing well. I am writing to request an update on the Q2 sales report, which was scheduled for submission by June 10th.<br><br>
Could you please let me know the current status and whether you anticipate any delays? This information is needed for our management presentation on June 18th.<br><br>
Thank you for your time. I look forward to hearing from you.<br><br>
Best regards,<br>
David Lee<br>
Marketing Manager
</blockquote>',
            'duration_minutes' => 20,
            'order_position'   => 1,
            'is_previewable'   => false,
        ]);
        CourseLesson::create([
            'module_id'        => $c3->id,
            'title'            => 'Participating in Meetings: Key Phrases',
            'type'             => 'text',
            'text_content'     => '<h2>Meeting English: Essential Phrases</h2>
<h3>Opening a Meeting</h3>
<ul>
  <li>"Let\'s get started, shall we?"</li>
  <li>"The purpose of today\'s meeting is to discuss..."</li>
  <li>"We have about an hour, so let\'s make the most of it."</li>
</ul>
<h3>Giving Your Opinion</h3>
<ul>
  <li>"In my opinion..." / "From my perspective..."</li>
  <li>"I strongly believe that..." / "I tend to think that..."</li>
  <li>"To be honest, I\'m not sure about this because..."</li>
</ul>
<h3>Interrupting Politely</h3>
<ul>
  <li>"Sorry to interrupt, but could I add something here?"</li>
  <li>"If I could just jump in for a moment..."</li>
</ul>
<h3>Reaching Agreement</h3>
<ul>
  <li>"That\'s a great point." / "I completely agree."</li>
  <li>"I think we\'re all on the same page."</li>
  <li>"Let\'s go with that approach."</li>
</ul>',
            'duration_minutes' => 14,
            'order_position'   => 2,
            'is_previewable'   => true,
        ]);
    }

    // ══════════════════════════════════════════════════════
    //  EXAMS
    // ══════════════════════════════════════════════════════

    private function seedExams(): void
    {
        // ── EXAM 1: IELTS Academic Reading Practice ─────────────────────────
        $ieltsExam = Exam::create([
            'exam_type_id'    => 2, // IELTS
            'title'           => 'IELTS Academic Reading — Practice Test 1',
            'total_duration'  => 60,
            'mode'            => 'practice',
            'is_active'       => true,
            'is_public'       => true,
            'tokens_required' => 1,
        ]);

        $s1 = Section::create([
            'exam_id'        => $ieltsExam->id,
            'title'          => 'Reading Passage 1: Science & Technology',
            'duration'       => 20,
            'description'    => 'Questions 1–14 based on a passage about artificial intelligence in healthcare.',
            'order_position' => 1,
        ]);
        $sub1 = Subsection::create([
            'section_id'     => $s1->id,
            'title'          => 'AI in Modern Healthcare',
            'instructions'   => 'Read the passage below and answer Questions 1–14. Choose the correct answer (A, B, C or D) unless otherwise instructed.',
            'order_position' => 1,
        ]);
        $g1 = QuestionGroup::create([
            'subsection_id'  => $sub1->id,
            'title'          => 'Artificial Intelligence in Modern Healthcare',
            'instruction'    => 'Read the following passage and answer the questions.',
            'group_type'     => 'passage',
            'passage_text'   => 'Artificial intelligence (AI) is rapidly transforming the healthcare industry. From diagnosing diseases to personalizing treatment plans, AI systems are demonstrating capabilities that rival and sometimes exceed those of experienced physicians. Machine learning algorithms, trained on millions of patient records and medical images, can detect subtle patterns invisible to the human eye.

One of the most celebrated applications is in medical imaging. Researchers at Stanford University developed an AI model capable of diagnosing skin cancer from photographs with an accuracy matching that of dermatologists. Similarly, Google\'s DeepMind created an AI system that identifies over 50 eye diseases from retinal scans with 94% accuracy. These systems do not replace doctors; rather, they serve as a powerful second opinion, particularly in regions where specialist access is limited.

However, the adoption of AI in healthcare is not without controversy. Critics raise concerns about algorithmic bias — the risk that AI systems, trained predominantly on data from certain populations, may perform less accurately for underrepresented groups. A 2019 study found that a widely used healthcare algorithm favored white patients over Black patients of equal health status, allocating fewer resources to the latter group. Addressing such bias requires diverse training datasets and rigorous testing across different demographic groups.

Privacy is another critical concern. AI systems require vast amounts of patient data to function effectively. Ensuring that this data is stored securely, used ethically, and protected from unauthorized access is paramount. Patients must be informed about how their data is used and must have meaningful control over it.

Despite these challenges, the potential of AI in healthcare is enormous. Predictive analytics can identify patients at risk of chronic diseases before symptoms appear, enabling early intervention. In drug discovery, AI has reduced the time required to identify promising molecular compounds from years to weeks. The World Health Organization estimates that AI could save up to 10 million lives per year by 2030 if deployed responsibly.',
            'order_position' => 1,
        ]);

        $this->addMCQ($g1->id, 1, 'According to paragraph 2, what is the primary role of AI in medical diagnosis?',
            ['To completely replace human doctors', 'To provide an additional perspective for clinicians', 'To manage hospital administrative tasks', 'To train new medical students'],
            1
        );
        $this->addMCQ($g1->id, 2, 'The word "subtle" in paragraph 1 is closest in meaning to:',
            ['obvious', 'dangerous', 'not immediately noticeable', 'frequently occurring'],
            2
        );
        $this->addMCQ($g1->id, 3, 'What is the main concern raised about algorithmic bias?',
            ['AI systems are too expensive to develop', 'AI may perform unequally across different population groups', 'Doctors refuse to use AI tools', 'AI systems require internet connectivity'],
            1
        );
        $this->addMCQ($g1->id, 4, 'Based on the passage, which statement about patient data is true?',
            ['Patients have no rights over their medical data', 'Large datasets are unnecessary for AI systems', 'Data security and patient consent are important considerations', 'All healthcare data is already publicly available'],
            2
        );
        $this->addMCQ($g1->id, 5, 'What benefit of AI in drug discovery is mentioned?',
            ['Eliminating the need for clinical trials', 'Significantly accelerating the identification of potential compounds', 'Reducing medication costs by 50%', 'Replacing pharmaceutical scientists'],
            1
        );

        // Section 2
        $s2 = Section::create([
            'exam_id'        => $ieltsExam->id,
            'title'          => 'Reading Passage 2: Environment & Society',
            'duration'       => 20,
            'description'    => 'Questions 15–28 based on a passage about urban green spaces.',
            'order_position' => 2,
        ]);
        $sub2 = Subsection::create([
            'section_id'     => $s2->id,
            'title'          => 'Urban Green Spaces',
            'instructions'   => 'Read the passage and answer Questions 15–28.',
            'order_position' => 1,
        ]);
        $g2 = QuestionGroup::create([
            'subsection_id'  => $sub2->id,
            'title'          => 'The Value of Urban Green Spaces',
            'instruction'    => 'Read the passage and choose the best answer.',
            'group_type'     => 'passage',
            'passage_text'   => 'Urban green spaces — parks, gardens, street trees, and green roofs — are increasingly recognized as essential infrastructure in modern cities. Once viewed primarily as aesthetic luxuries, they are now understood to deliver measurable benefits to human health, urban ecology, and city economics.

Research consistently shows that access to parks and natural environments reduces stress, anxiety, and symptoms of depression. A landmark study published in the journal Landscape and Urban Planning found that residents living within 300 meters of a park reported significantly lower levels of psychological distress than those living further away. The effect was particularly pronounced among low-income residents, suggesting that green spaces can help reduce health inequalities.

Green spaces also play a vital role in urban climate regulation. Trees and vegetation mitigate the urban heat island effect — a phenomenon in which cities experience higher temperatures than surrounding rural areas due to the concentration of buildings, roads, and vehicles. A mature urban tree can reduce ambient temperatures by up to 8°C in its immediate vicinity through the combined effects of shade and evapotranspiration. Cities with high tree canopy cover have been shown to reduce peak summer temperatures city-wide.

Furthermore, urban green spaces support biodiversity. Even small urban parks can serve as refuges for pollinating insects, birds, and small mammals that would otherwise struggle to survive in heavily built-up environments. Green corridors — strips of vegetation connecting isolated green areas — allow wildlife to move through cities, supporting healthier and more resilient populations.

Economically, green spaces add value. Studies in North American and European cities consistently find that proximity to parks increases residential property values by between 5% and 20%. Moreover, cities with well-maintained green infrastructure attract businesses and tourists, contributing to local economic vitality. The economic case for investing in urban nature is therefore compelling alongside the environmental and social arguments.',
            'order_position' => 1,
        ]);

        $this->addMCQ($g2->id, 1, 'What has changed in how urban green spaces are perceived?',
            ['They are now seen as unnecessary expenses', 'They are viewed as providers of measurable benefits beyond aesthetics', 'They have become less popular with city planners', 'They are now used primarily for agricultural purposes'],
            1
        );
        $this->addMCQ($g2->id, 2, 'The study mentioned in paragraph 2 suggests that green spaces most benefit:',
            ['elderly residents', 'wealthier neighborhoods', 'lower-income residents', 'children under ten'],
            2
        );
        $this->addMCQ($g2->id, 3, 'How do urban trees help regulate temperature?',
            ['By reflecting sunlight back into space', 'Through shade and the process of evapotranspiration', 'By absorbing heat stored in road surfaces', 'By increasing wind speed through city centers'],
            1
        );
        $this->addMCQ($g2->id, 4, 'What is the purpose of "green corridors" as described in the passage?',
            ['To provide cycling routes for city residents', 'To connect parks for increased tourism', 'To allow wildlife to move between isolated green areas', 'To reduce vehicle traffic in city centers'],
            2
        );
        $this->addMCQ($g2->id, 5, 'According to the passage, what economic benefit do green spaces provide?',
            ['They reduce city maintenance costs significantly', 'They increase nearby property values', 'They eliminate the need for urban air conditioning', 'They create direct employment in the agriculture sector'],
            1
        );

        // ── EXAM 2: TOEFL iBT Reading Practice ─────────────────────────────
        $toeflExam = Exam::create([
            'exam_type_id'    => 3, // TOEFL
            'title'           => 'TOEFL iBT Reading — Practice Test 1',
            'total_duration'  => 35,
            'mode'            => 'practice',
            'is_active'       => true,
            'is_public'       => true,
            'tokens_required' => 1,
        ]);

        $ts1 = Section::create([
            'exam_id'        => $toeflExam->id,
            'title'          => 'Passage 1: The Evolution of Cities',
            'duration'       => 18,
            'description'    => 'Questions 1–10 based on an academic passage about urban development.',
            'order_position' => 1,
        ]);
        $tsub1 = Subsection::create([
            'section_id'     => $ts1->id,
            'title'          => 'The Evolution of Cities',
            'instructions'   => 'Read the passage. Then answer questions 1–10 on the basis of what is stated or implied in the passage.',
            'order_position' => 1,
        ]);
        $tg1 = QuestionGroup::create([
            'subsection_id'  => $tsub1->id,
            'title'          => 'The Evolution of Cities',
            'instruction'    => 'Read the passage carefully and answer all questions.',
            'group_type'     => 'passage',
            'passage_text'   => 'The city, as a form of human settlement, has undergone dramatic transformations since its earliest manifestations in ancient Mesopotamia roughly 5,000 years ago. What began as concentrated agricultural communities evolved into complex administrative, commercial, and cultural centers that have defined human civilization.

The earliest cities emerged in river valleys — the Tigris-Euphrates in Mesopotamia, the Nile in Egypt, the Indus in South Asia — where fertile soil, reliable water supplies, and navigable waterways supported large, dense populations. Surplus food production was the essential precondition: once agricultural yields exceeded what individual families needed, people could specialize in other roles — as merchants, artisans, priests, and administrators. This specialization, in turn, demanded a centralized location where goods, services, and governance could be organized.

Urban growth throughout history has been closely linked to technological change. The Industrial Revolution of the 18th and 19th centuries triggered an unprecedented wave of urbanization. Mechanized production drew millions of workers from rural areas to industrial cities such as Manchester, Birmingham, and Chicago. By 1900, for the first time in history, more than 10% of the global population lived in urban areas.

The 20th century saw this process accelerate dramatically. By 2007, for the first time, the majority of the world\'s population — over 50% — lived in cities. Today that figure stands at approximately 56%, and the United Nations projects it will reach 68% by 2050. Much of this growth is occurring in Asia and Africa, where rapidly expanding megacities such as Lagos, Dhaka, and Jakarta are absorbing millions of rural migrants each year.

Contemporary urban planners face challenges that their predecessors could not have imagined: climate change adaptation, digital infrastructure, housing affordability, and social inequality. The cities of the future will need to be smarter, greener, and more equitable if they are to remain viable homes for an increasingly urban humanity.',
            'order_position' => 1,
        ]);

        $this->addMCQ($tg1->id, 1, 'According to paragraph 2, what was the essential precondition for the emergence of cities?',
            ['The invention of writing and record-keeping', 'Agricultural yields that exceeded family needs', 'The discovery of river systems suitable for navigation', 'The development of long-distance trade routes'],
            1
        );
        $this->addMCQ($tg1->id, 2, 'The word "unprecedented" in paragraph 3 is closest in meaning to:',
            ['unexpected', 'gradual', 'never seen before', 'well-documented'],
            2
        );
        $this->addMCQ($tg1->id, 3, 'Which of the following can be inferred about urbanization in Asia and Africa?',
            ['Urban populations there are expected to decline', 'These regions are currently the fastest-growing urban areas', 'They have already reached the 68% urbanization target', 'Urban migration in these regions has slowed recently'],
            1
        );
        $this->addMCQ($tg1->id, 4, 'Why does the author mention Manchester, Birmingham, and Chicago?',
            ['To compare different industrial techniques', 'To provide examples of cities shaped by the Industrial Revolution', 'To identify the largest cities in the 18th century', 'To suggest these cities had the best living conditions'],
            1
        );
        $this->addMCQ($tg1->id, 5, 'What is the main idea of the passage?',
            ['River valleys are the only suitable locations for large cities', 'Cities have continuously evolved in response to human needs and technological change', 'The Industrial Revolution was the most important event in urban history', 'Future cities will be impossible to manage without new technology'],
            1
        );

        $ts2 = Section::create([
            'exam_id'        => $toeflExam->id,
            'title'          => 'Passage 2: The Science of Sleep',
            'duration'       => 17,
            'description'    => 'Questions 11–20 based on an academic passage about human sleep.',
            'order_position' => 2,
        ]);
        $tsub2 = Subsection::create([
            'section_id'     => $ts2->id,
            'title'          => 'The Science of Sleep',
            'instructions'   => 'Read the passage and answer Questions 11–20.',
            'order_position' => 1,
        ]);
        $tg2 = QuestionGroup::create([
            'subsection_id'  => $tsub2->id,
            'title'          => 'The Science of Sleep',
            'instruction'    => 'Answer all questions based on information stated or implied in the passage.',
            'group_type'     => 'passage',
            'passage_text'   => 'Sleep is one of the most fundamental biological processes in the animal kingdom, yet for centuries it remained poorly understood. Modern neuroscience has begun to unravel the mechanisms behind sleep and reveal its profound importance for physical health, cognitive function, and emotional regulation.

Human sleep is organized into cycles of approximately 90 minutes, each consisting of several distinct stages. The early stages involve light sleep, during which the body begins to relax and brain activity slows. This is followed by deep sleep, also called slow-wave sleep, which is when the body undertakes the majority of its physical repair — releasing growth hormone, consolidating muscle tissue, and strengthening the immune system. The final stage of each cycle is Rapid Eye Movement (REM) sleep, characterized by intense brain activity resembling the waking state. REM sleep is strongly associated with dreaming and plays a critical role in emotional processing and memory consolidation.

The consequences of sleep deprivation are severe and wide-ranging. After just one night of poor sleep, cognitive performance — including attention, working memory, and decision-making — deteriorates markedly. Chronic sleep deprivation has been linked to increased risks of cardiovascular disease, obesity, type 2 diabetes, and mental health disorders such as anxiety and depression. Research published in the journal Science in 2019 demonstrated that during sleep, the brain\'s glymphatic system — a waste-clearance network — becomes significantly more active, flushing out toxic proteins including those associated with Alzheimer\'s disease.

Modern society, however, is experiencing a widespread sleep crisis. Artificial lighting, digital screens, shift work, and increasingly demanding schedules have disrupted natural sleep patterns for millions of people. The average adult in industrialized nations sleeps approximately 6.5 hours per night — well below the 7–9 hours recommended by health authorities.

Sleep researchers advocate for systemic changes: later school start times for adolescents, whose natural sleep cycles shift during puberty; workplace policies that discourage late-night email and promote recovery time; and greater public awareness of sleep\'s essential role in maintaining health and productivity.',
            'order_position' => 1,
        ]);

        $this->addMCQ($tg2->id, 1, 'According to paragraph 2, which stage of sleep is most associated with physical recovery?',
            ['Light sleep (early stages)', 'Deep / slow-wave sleep', 'REM sleep', 'The transition between cycles'],
            1
        );
        $this->addMCQ($tg2->id, 2, 'What does the author suggest about the glymphatic system?',
            ['It only functions during waking hours', 'It removes harmful proteins from the brain during sleep', 'It controls the duration of REM cycles', 'It was only recently discovered to exist in humans'],
            1
        );
        $this->addMCQ($tg2->id, 3, 'The word "deteriorates" in paragraph 3 is closest in meaning to:',
            ['improves', 'worsens', 'stabilizes', 'varies'],
            1
        );
        $this->addMCQ($tg2->id, 4, 'What can be inferred about adolescent sleep patterns?',
            ['Teenagers naturally prefer to sleep and wake earlier than adults', 'Puberty causes a biological shift that makes later sleep times natural', 'Teenagers require less sleep than adults', 'School schedules have no effect on adolescent health'],
            1
        );
        $this->addMCQ($tg2->id, 5, 'Which of the following best states the main idea of the passage?',
            ['Sleep deprivation is primarily caused by digital technology', 'REM sleep is the most important sleep stage for physical health', 'Sleep is a critical biological process that modern society increasingly disrupts', 'Scientists fully understand all aspects of human sleep'],
            2
        );

        // ── EXAM 3: General English Proficiency Quiz ─────────────────────────
        $quizExam = Exam::create([
            'exam_type_id'    => 4, // Quiz
            'title'           => 'General English Proficiency Test — Intermediate Level',
            'total_duration'  => 30,
            'mode'            => 'practice',
            'is_active'       => true,
            'is_public'       => true,
            'tokens_required' => 0,
        ]);

        $qs1 = Section::create([
            'exam_id'        => $quizExam->id,
            'title'          => 'Part 1: Grammar & Structure',
            'duration'       => 10,
            'description'    => 'Test your knowledge of English grammar rules.',
            'order_position' => 1,
        ]);
        $qsub1 = Subsection::create([
            'section_id'     => $qs1->id,
            'title'          => 'Grammar Questions',
            'instructions'   => 'Choose the word or phrase that best completes each sentence.',
            'order_position' => 1,
        ]);
        $qg1 = QuestionGroup::create([
            'subsection_id'  => $qsub1->id,
            'title'          => 'Grammar & Sentence Structure',
            'instruction'    => 'Select the correct answer for each grammar question.',
            'group_type'     => 'standalone',
            'order_position' => 1,
        ]);

        $this->addMCQ($qg1->id, 1, 'She _____ to the library every day before the exams started.',
            ['goes', 'went', 'is going', 'will go'],
            1
        );
        $this->addMCQ($qg1->id, 2, 'By the time he arrived, the meeting _____ already.',
            ['has ended', 'had ended', 'was ending', 'ended'],
            1
        );
        $this->addMCQ($qg1->id, 3, 'If I _____ more time, I would learn another language.',
            ['have', 'had', 'will have', 'having'],
            1
        );
        $this->addMCQ($qg1->id, 4, 'The report _____ by the team before the deadline.',
            ['was completed', 'completed', 'has completing', 'were completed'],
            0
        );
        $this->addMCQ($qg1->id, 5, 'Neither the manager nor the employees _____ aware of the policy change.',
            ['was', 'were', 'is', 'has been'],
            1
        );
        $this->addMCQ($qg1->id, 6, 'She asked me where _____ the previous day.',
            ['did I go', 'I had gone', 'have I gone', 'I will go'],
            1
        );
        $this->addMCQ($qg1->id, 7, 'The number of students who fail the exam _____ decreasing each year.',
            ['are', 'is', 'were', 'have been'],
            1
        );

        $qs2 = Section::create([
            'exam_id'        => $quizExam->id,
            'title'          => 'Part 2: Vocabulary',
            'duration'       => 10,
            'description'    => 'Test your English vocabulary knowledge.',
            'order_position' => 2,
        ]);
        $qsub2 = Subsection::create([
            'section_id'     => $qs2->id,
            'title'          => 'Vocabulary in Context',
            'instructions'   => 'Choose the word closest in meaning to the underlined word, or the best word to complete the sentence.',
            'order_position' => 1,
        ]);
        $qg2 = QuestionGroup::create([
            'subsection_id'  => $qsub2->id,
            'title'          => 'Vocabulary Questions',
            'instruction'    => 'Select the best answer based on meaning and context.',
            'group_type'     => 'standalone',
            'order_position' => 1,
        ]);

        $this->addMCQ($qg2->id, 1, 'The scientist\'s findings were groundbreaking. The word "groundbreaking" means:',
            ['controversial', 'innovative and significant', 'difficult to understand', 'published in a journal'],
            1
        );
        $this->addMCQ($qg2->id, 2, 'Choose the correct word: "The two sides reached a _____ after hours of negotiation."',
            ['consequence', 'compromise', 'conflict', 'complaint'],
            1
        );
        $this->addMCQ($qg2->id, 3, 'The opposite of "abundant" is:',
            ['plentiful', 'scarce', 'excessive', 'common'],
            1
        );
        $this->addMCQ($qg2->id, 4, '"She gave an _____ explanation — everyone understood immediately." Choose the best word.',
            ['ambiguous', 'vague', 'elaborate', 'lucid'],
            3
        );
        $this->addMCQ($qg2->id, 5, 'Choose the correct collocation: "make a _____" (= a formal public statement)',
            ['speech', 'announcement', 'statement', 'declaration'],
            3
        );
        $this->addMCQ($qg2->id, 6, 'The word "alleviate" means:',
            ['to increase', 'to reduce or lessen', 'to completely remove', 'to delay'],
            1
        );
        $this->addMCQ($qg2->id, 7, '"The professor _____ her point clearly before moving on." Choose the correct verb.',
            ['made', 'told', 'said', 'spoke'],
            0
        );

        $qs3 = Section::create([
            'exam_id'        => $quizExam->id,
            'title'          => 'Part 3: Reading Comprehension',
            'duration'       => 10,
            'description'    => 'Read a short passage and answer comprehension questions.',
            'order_position' => 3,
        ]);
        $qsub3 = Subsection::create([
            'section_id'     => $qs3->id,
            'title'          => 'Short Reading Comprehension',
            'instructions'   => 'Read the passage carefully, then answer the questions that follow.',
            'order_position' => 1,
        ]);
        $qg3 = QuestionGroup::create([
            'subsection_id'  => $qsub3->id,
            'title'          => 'Reading: The Benefits of Bilingualism',
            'instruction'    => 'Answer questions based on the passage.',
            'group_type'     => 'passage',
            'passage_text'   => 'Learning a second language has long been associated with cognitive benefits, but recent neuroscientific research has provided more concrete evidence of its positive effects on the brain. Studies conducted at universities in Canada and Spain found that bilingual individuals consistently outperform monolinguals on tasks requiring attention control, task-switching, and the ability to filter out irrelevant information — a set of abilities collectively known as executive function.

Researchers attribute these advantages to the constant mental exercise involved in managing two language systems. Bilinguals must continuously suppress one language while using another, a process that strengthens the prefrontal cortex — the region of the brain responsible for complex decision-making and impulse control. This regular cognitive workout may also delay the onset of dementia by an average of four to five years, according to a study of over 200 bilingual patients at a Toronto hospital.

The benefits are not limited to cognitive gains. Bilingualism opens doors professionally: employers in international businesses, diplomacy, healthcare, and education increasingly value candidates who can communicate across language barriers. Additionally, learning another language deepens cultural understanding and empathy, as language is inseparable from the worldview of its speakers.',
            'order_position' => 1,
        ]);

        $this->addMCQ($qg3->id, 1, 'What do researchers say causes the cognitive benefits of bilingualism?',
            ['Reading more academic texts in two languages', 'The constant mental effort of managing two language systems', 'Growing up in a multilingual household', 'Formal grammar instruction in both languages'],
            1
        );
        $this->addMCQ($qg3->id, 2, 'According to the passage, what is "executive function"?',
            ['The management role in bilingual schools', 'Skills including attention, task-switching, and filtering irrelevant information', 'The ability to speak two languages simultaneously', 'A specific region of the brain'],
            1
        );
        $this->addMCQ($qg3->id, 3, 'The word "suppress" in paragraph 2 is closest in meaning to:',
            ['activate', 'strengthen', 'hold back', 'translate'],
            2
        );
        $this->addMCQ($qg3->id, 4, 'Which of the following is NOT mentioned as a professional field that values bilingualism?',
            ['Diplomacy', 'Engineering', 'Healthcare', 'Education'],
            1
        );
        $this->addMCQ($qg3->id, 5, 'What is the author\'s overall attitude toward bilingualism?',
            ['Neutral — the author presents only factual research without any evaluation', 'Positive — the author presents evidence suggesting bilingualism has multiple advantages', 'Skeptical — the author questions the reliability of the studies cited', 'Negative — the author warns about the difficulties of learning two languages'],
            1
        );
    }

    // ══════════════════════════════════════════════════════
    //  HELPER
    // ══════════════════════════════════════════════════════

    /**
     * Add a multiple-choice question with 4 options.
     *
     * @param int    $groupId
     * @param int    $order
     * @param string $questionText
     * @param array  $options       Array of 4 option texts
     * @param int    $correctIndex  0-based index of the correct option
     */
    private function addMCQ(int $groupId, int $order, string $questionText, array $options, int $correctIndex): void
    {
        $question = Question::create([
            'question_group_id' => $groupId,
            'type'              => 'multiple_choice',
            'question_text'     => $questionText,
            'points'            => 1,
            'order_position'    => $order,
        ]);

        foreach ($options as $index => $optionText) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'is_correct'  => $index === $correctIndex,
            ]);
        }
    }
}
