<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('exam_types')->delete();
        
        DB::table('exam_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'TOEIC',
            'description' => 'TOEIC (Test of English for International Communication) is an internationally recognized standardized test designed to measure English language proficiency in professional and workplace contexts. It evaluates key communication skills, particularly Listening and Reading, that are commonly used in global business environments. TOEIC scores are widely used by companies and institutions to assess an individual’s English competency for career advancement and academic purposes.',
                'deleted_at' => NULL,
                'created_at' => '2026-02-27 16:40:01',
                'updated_at' => '2026-02-27 16:40:01',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'IELTS',
            'description' => 'IELTS (International English Language Testing System) is a globally recognized English proficiency test designed to assess language skills for academic, professional, and migration purposes. It evaluates four key abilities: Listening, Reading, Writing, and Speaking. IELTS is widely accepted by universities, employers, and immigration authorities in many English-speaking countries.',
                'deleted_at' => NULL,
                'created_at' => '2026-02-27 16:40:49',
                'updated_at' => '2026-02-27 16:40:49',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'TOEFL',
            'description' => 'TOEFL (Test of English as a Foreign Language) is a standardized test that measures English language proficiency in an academic setting, particularly for non-native speakers who plan to study abroad. It assesses four main skills: Reading, Listening, Speaking, and Writing, with a strong focus on English used in university environments. TOEFL scores are accepted by thousands of universities and institutions worldwide.',
                'deleted_at' => NULL,
                'created_at' => '2026-02-27 16:40:59',
                'updated_at' => '2026-02-27 16:40:59',
            ),
        ));
        
        
    }
}