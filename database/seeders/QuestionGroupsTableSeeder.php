<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_groups')->delete();
        
        DB::table('question_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'subsection_id' => 1,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 2,
                'created_at' => '2026-03-01 03:23:25',
                'updated_at' => '2026-03-01 04:52:25',
            ),
            1 => 
            array (
                'id' => 3,
                'subsection_id' => 1,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:44:25',
                'updated_at' => '2026-03-01 04:52:25',
            ),
            2 => 
            array (
                'id' => 4,
                'subsection_id' => 1,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 5,
                'created_at' => '2026-03-01 04:45:08',
                'updated_at' => '2026-03-01 04:52:25',
            ),
            3 => 
            array (
                'id' => 5,
                'subsection_id' => 1,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 4,
                'created_at' => '2026-03-01 04:50:57',
                'updated_at' => '2026-03-01 04:52:25',
            ),
            4 => 
            array (
                'id' => 6,
                'subsection_id' => 2,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:56:46',
                'updated_at' => '2026-03-01 04:56:46',
            ),
            5 => 
            array (
                'id' => 7,
                'subsection_id' => 2,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:57:32',
                'updated_at' => '2026-03-01 04:57:32',
            ),
            6 => 
            array (
                'id' => 8,
                'subsection_id' => 3,
                'title' => 'Question 41 - 43',
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => 'audios/01KJK4C4JK9VADTCD8F4H2E9YQ.mp3',
                'image_path' => NULL,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:02:16',
                'updated_at' => '2026-03-01 05:02:16',
            ),
            7 => 
            array (
                'id' => 9,
                'subsection_id' => 3,
                'title' => 'Question 44 - 46',
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => 'audios/01KJK4ESZNT35TBEEPDK25W531.mp3',
                'image_path' => NULL,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:03:43',
                'updated_at' => '2026-03-01 05:03:43',
            ),
            8 => 
            array (
                'id' => 10,
                'subsection_id' => 4,
                'title' => 'Question 61 -63',
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => 'audios/01KJK4K0JBW3TX492EXMA0S7NE.mp3',
                'image_path' => NULL,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:06:01',
                'updated_at' => '2026-03-01 05:06:01',
            ),
            9 => 
            array (
                'id' => 11,
                'subsection_id' => 5,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:07:46',
                'updated_at' => '2026-03-01 05:07:46',
            ),
            10 => 
            array (
                'id' => 12,
                'subsection_id' => 5,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:08:23',
                'updated_at' => '2026-03-01 05:08:23',
            ),
            11 => 
            array (
                'id' => 13,
                'subsection_id' => 5,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 3,
                'created_at' => '2026-03-01 05:09:04',
                'updated_at' => '2026-03-01 05:09:04',
            ),
            12 => 
            array (
                'id' => 14,
                'subsection_id' => 6,
                'title' => NULL,
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:11:16',
                'updated_at' => '2026-03-01 05:11:16',
            ),
            13 => 
            array (
                'id' => 15,
                'subsection_id' => 6,
                'title' => NULL,
            'instruction' => 'Tom, Do you think we should go ahead and sign the lease on the State Street office? It is certainly __(1)__ than our current office, but I am concerned about the price. It is almost twice as much as what we\'re paying now. However, we may be able to find a way to pay for it if you really think this is the best space available. The main thing is, I want you to be __(2)__ with it. Also, I know you are tired of looking at new offices every day. I understand that this __(3)__ chore has become a stress. So, if you really believe this is our best option, call the landlord to make an appointment for sometime this week to go over the lease. ',
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => NULL,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            14 => 
            array (
                'id' => 16,
                'subsection_id' => 7,
                'title' => 'Advertisment 1',
                'instruction' => NULL,
                'group_type' => NULL,
                'passage_text' => NULL,
                'audio_path' => NULL,
                'image_path' => 'images/01KJK546BT7WY7H4WNHZ2C7C8Z.png',
                'order_position' => 1,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
        ));
        
        
    }
}