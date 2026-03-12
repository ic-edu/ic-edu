<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionOptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('question_options')->delete();
        
        DB::table('question_options')->insert(array (
            0 => 
            array (
                'id' => 1,
                'question_id' => 1,
                'option_text' => 'A',
                'is_correct' => 0,
                'created_at' => '2026-03-01 03:23:25',
                'updated_at' => '2026-03-01 03:23:25',
            ),
            1 => 
            array (
                'id' => 2,
                'question_id' => 1,
                'option_text' => 'B',
                'is_correct' => 0,
                'created_at' => '2026-03-01 03:23:25',
                'updated_at' => '2026-03-01 03:23:25',
            ),
            2 => 
            array (
                'id' => 3,
                'question_id' => 1,
                'option_text' => 'C',
                'is_correct' => 1,
                'created_at' => '2026-03-01 03:23:25',
                'updated_at' => '2026-03-01 04:47:50',
            ),
            3 => 
            array (
                'id' => 4,
                'question_id' => 1,
                'option_text' => 'D',
                'is_correct' => 0,
                'created_at' => '2026-03-01 03:23:25',
                'updated_at' => '2026-03-01 03:23:25',
            ),
            4 => 
            array (
                'id' => 9,
                'question_id' => 3,
                'option_text' => 'A',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:44:25',
                'updated_at' => '2026-03-01 04:44:25',
            ),
            5 => 
            array (
                'id' => 10,
                'question_id' => 3,
                'option_text' => 'B',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:44:25',
                'updated_at' => '2026-03-01 04:44:25',
            ),
            6 => 
            array (
                'id' => 11,
                'question_id' => 3,
                'option_text' => 'C',
                'is_correct' => 1,
                'created_at' => '2026-03-01 04:44:25',
                'updated_at' => '2026-03-01 04:48:52',
            ),
            7 => 
            array (
                'id' => 12,
                'question_id' => 3,
                'option_text' => 'D',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:44:25',
                'updated_at' => '2026-03-01 04:44:25',
            ),
            8 => 
            array (
                'id' => 13,
                'question_id' => 4,
                'option_text' => 'A',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:45:08',
                'updated_at' => '2026-03-01 04:45:08',
            ),
            9 => 
            array (
                'id' => 14,
                'question_id' => 4,
                'option_text' => 'B',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:45:08',
                'updated_at' => '2026-03-01 04:45:08',
            ),
            10 => 
            array (
                'id' => 15,
                'question_id' => 4,
                'option_text' => 'C',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:45:08',
                'updated_at' => '2026-03-01 04:45:08',
            ),
            11 => 
            array (
                'id' => 16,
                'question_id' => 4,
                'option_text' => 'D',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:45:08',
                'updated_at' => '2026-03-01 04:45:08',
            ),
            12 => 
            array (
                'id' => 17,
                'question_id' => 5,
                'option_text' => 'A',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:50:57',
                'updated_at' => '2026-03-01 04:50:57',
            ),
            13 => 
            array (
                'id' => 18,
                'question_id' => 5,
                'option_text' => 'B',
                'is_correct' => 1,
                'created_at' => '2026-03-01 04:50:58',
                'updated_at' => '2026-03-01 04:50:58',
            ),
            14 => 
            array (
                'id' => 19,
                'question_id' => 5,
                'option_text' => 'C',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:50:58',
                'updated_at' => '2026-03-01 04:50:58',
            ),
            15 => 
            array (
                'id' => 20,
                'question_id' => 5,
                'option_text' => 'D',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:50:58',
                'updated_at' => '2026-03-01 04:50:58',
            ),
            16 => 
            array (
                'id' => 21,
                'question_id' => 6,
                'option_text' => 'A',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:56:46',
                'updated_at' => '2026-03-01 04:56:46',
            ),
            17 => 
            array (
                'id' => 22,
                'question_id' => 6,
                'option_text' => 'B',
                'is_correct' => 1,
                'created_at' => '2026-03-01 04:56:46',
                'updated_at' => '2026-03-01 04:56:46',
            ),
            18 => 
            array (
                'id' => 23,
                'question_id' => 6,
                'option_text' => 'C',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:56:46',
                'updated_at' => '2026-03-01 04:56:46',
            ),
            19 => 
            array (
                'id' => 24,
                'question_id' => 6,
                'option_text' => 'D',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:56:46',
                'updated_at' => '2026-03-01 04:56:46',
            ),
            20 => 
            array (
                'id' => 25,
                'question_id' => 7,
                'option_text' => 'A',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:57:32',
                'updated_at' => '2026-03-01 04:57:32',
            ),
            21 => 
            array (
                'id' => 26,
                'question_id' => 7,
                'option_text' => 'B',
                'is_correct' => 0,
                'created_at' => '2026-03-01 04:57:32',
                'updated_at' => '2026-03-01 04:57:32',
            ),
            22 => 
            array (
                'id' => 27,
                'question_id' => 7,
                'option_text' => 'C',
                'is_correct' => 1,
                'created_at' => '2026-03-01 04:57:32',
                'updated_at' => '2026-03-01 04:57:32',
            ),
            23 => 
            array (
                'id' => 28,
                'question_id' => 17,
                'option_text' => 'bags ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:07:46',
                'updated_at' => '2026-03-01 05:07:46',
            ),
            24 => 
            array (
                'id' => 29,
                'question_id' => 17,
                'option_text' => 'envelopes ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:07:46',
                'updated_at' => '2026-03-01 05:07:46',
            ),
            25 => 
            array (
                'id' => 30,
                'question_id' => 17,
                'option_text' => 'cans ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:07:46',
                'updated_at' => '2026-03-01 05:07:46',
            ),
            26 => 
            array (
                'id' => 31,
                'question_id' => 17,
                'option_text' => 'boxes',
                'is_correct' => 1,
                'created_at' => '2026-03-01 05:07:46',
                'updated_at' => '2026-03-01 05:07:46',
            ),
            27 => 
            array (
                'id' => 32,
                'question_id' => 18,
                'option_text' => 'timing ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:08:23',
                'updated_at' => '2026-03-01 05:08:23',
            ),
            28 => 
            array (
                'id' => 33,
                'question_id' => 18,
                'option_text' => 'era ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:08:23',
                'updated_at' => '2026-03-01 05:08:23',
            ),
            29 => 
            array (
                'id' => 34,
                'question_id' => 18,
                'option_text' => 'period ',
                'is_correct' => 1,
                'created_at' => '2026-03-01 05:08:23',
                'updated_at' => '2026-03-01 05:08:23',
            ),
            30 => 
            array (
                'id' => 35,
                'question_id' => 18,
                'option_text' => 'sequence',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:08:23',
                'updated_at' => '2026-03-01 05:08:23',
            ),
            31 => 
            array (
                'id' => 36,
                'question_id' => 19,
                'option_text' => 'account ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:09:04',
                'updated_at' => '2026-03-01 05:09:04',
            ),
            32 => 
            array (
                'id' => 37,
                'question_id' => 19,
                'option_text' => 'accountant ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:09:04',
                'updated_at' => '2026-03-01 05:09:04',
            ),
            33 => 
            array (
                'id' => 38,
                'question_id' => 19,
                'option_text' => 'accountable ',
                'is_correct' => 1,
                'created_at' => '2026-03-01 05:09:04',
                'updated_at' => '2026-03-01 05:09:04',
            ),
            34 => 
            array (
                'id' => 39,
                'question_id' => 19,
                'option_text' => 'accountability',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:09:04',
                'updated_at' => '2026-03-01 05:09:04',
            ),
            35 => 
            array (
                'id' => 40,
                'question_id' => 20,
                'option_text' => 'has been ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:11:16',
                'updated_at' => '2026-03-01 05:11:16',
            ),
            36 => 
            array (
                'id' => 41,
                'question_id' => 20,
                'option_text' => 'have been ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:11:16',
                'updated_at' => '2026-03-01 05:11:16',
            ),
            37 => 
            array (
                'id' => 42,
                'question_id' => 20,
                'option_text' => 'were ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:11:16',
                'updated_at' => '2026-03-01 05:11:16',
            ),
            38 => 
            array (
                'id' => 43,
                'question_id' => 20,
                'option_text' => 'are ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:11:16',
                'updated_at' => '2026-03-01 05:11:16',
            ),
            39 => 
            array (
                'id' => 44,
                'question_id' => 21,
                'option_text' => 'big ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            40 => 
            array (
                'id' => 45,
                'question_id' => 21,
                'option_text' => 'bigger ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            41 => 
            array (
                'id' => 46,
                'question_id' => 21,
                'option_text' => 'biggest ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            42 => 
            array (
                'id' => 47,
                'question_id' => 21,
                'option_text' => 'the biggest ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            43 => 
            array (
                'id' => 48,
                'question_id' => 22,
                'option_text' => 'satisfy ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            44 => 
            array (
                'id' => 49,
                'question_id' => 22,
                'option_text' => 'satisfied ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            45 => 
            array (
                'id' => 50,
                'question_id' => 22,
                'option_text' => 'satisfying ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            46 => 
            array (
                'id' => 51,
                'question_id' => 22,
                'option_text' => 'satisfaction ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            47 => 
            array (
                'id' => 52,
                'question_id' => 23,
                'option_text' => 'Business supplies ',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
            48 => 
            array (
                'id' => 53,
                'question_id' => 23,
                'option_text' => 'Clothes',
                'is_correct' => 1,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
            49 => 
            array (
                'id' => 54,
                'question_id' => 24,
                'option_text' => 'Men',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
            50 => 
            array (
                'id' => 55,
                'question_id' => 24,
                'option_text' => 'Women',
                'is_correct' => 0,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
            51 => 
            array (
                'id' => 56,
                'question_id' => 24,
                'option_text' => 'Both men and women ',
                'is_correct' => 1,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
        ));
        
        
    }
}