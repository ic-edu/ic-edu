<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Section;
use App\Models\Subsection;
use App\Models\QuestionGroup;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil Ujian TOEIC yang sudah ada (ID 1)
        $exam = Exam::with('sections.subsections')->find(1);

        if (!$exam) {
            $this->command->error("Ujian TOEIC (ID 1) tidak ditemukan. Pastikan sudah ada data di database.");
            return;
        }

        $exam->update(['mode' => 'strict']);

        $this->command->info("Menambahkan soal simulasi pada Ujian: {$exam->title}");

        // Looping semua sections yang ada
        foreach ($exam->sections as $section) {
            $this->command->info("Memproses Section: {$section->title}");

            // Looping semua subsections dalam section tersebut
            foreach ($section->subsections as $subsection) {
                // 2. Buat 1 QuestionGroup untuk tiap subsection (anggap sebagai instruksi kelompok soal)
                $qGroup = QuestionGroup::create([
                    'subsection_id' => $subsection->id,
                    'title' => "Simulasi Group Soal untuk " . $subsection->title,
                    'instruction' => "Bacalah dengan seksama lalu jawab pertanyaan yang mengikutinya.",
                    'passage_text' => "<p>Ini adalah bacaan panjang untuk dianalisis oleh peserta ujian.</p>",
                    'order_position' => 1,
                ]);

                // 3. Masukkan 3 Tipe Soal Berbeda ke dalam Group ini
                
                // Soal 1: Pilihan Ganda (Multiple Choice)
                $mcQuestion = Question::create([
                    'question_group_id' => $qGroup->id,
                    'type' => 'multiple_choice',
                    'question_text' => "Ini adalah soal Pilihan Ganda ujicoba pada sub-topik {$subsection->title}. Manakah jawaban yang paling tepat?",
                    'points' => 10,
                    'order_position' => 1,
                ]);

                // Buat 4 Opsi (A,B,C,D) dimana Opsi B adalah yang benar
                $options = ['A. Kurang Tepat', 'B. Jawaban Paling Benar', 'C. Salah Total', 'D. Mengecoh'];
                foreach ($options as $idx => $opt) {
                    QuestionOption::create([
                        'question_id' => $mcQuestion->id,
                        'option_text' => $opt,
                        'is_correct' => ($idx === 1) ? true : false,
                    ]);
                }

                // Jika subsection terkait Reading, tambahkan Short Answer & Essay
                if (str_contains(strtolower($section->title), 'reading')) {
                    // Soal 2: Short Answer
                    Question::create([
                        'question_group_id' => $qGroup->id,
                        'type' => 'short_answer',
                        'question_text' => "Sebutkan satu kata benda dari bacaan di atas!",
                        'points' => 10,
                        'order_position' => 2,
                    ]);

                    // Soal 3: Essay
                    Question::create([
                        'question_group_id' => $qGroup->id,
                        'type' => 'essay',
                        'question_text' => "Jelaskan dengan panjang lebar mengenai pendapat Anda tentang hal ini.",
                        'points' => 20,
                        'order_position' => 3,
                    ]);
                }

                // Jika subsection terkait Listening, tambahkan Audio Recording type
                if (str_contains(strtolower($section->title), 'listening')) {
                    Question::create([
                        'question_group_id' => $qGroup->id,
                        'type' => 'record',
                        'question_text' => "Tolong ucapkan kalimat berikut: 'The quick brown fox jumps over the lazy dog'",
                        'points' => 15,
                        'order_position' => 2,
                    ]);
                }
            }
        }

        $this->command->info("Seeder selesai! Soal simulasi berhasil disisipkan ke dalam Exam TOEIC.");
    }
}
