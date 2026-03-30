<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('questions')->delete();
        
        DB::table('questions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'question_group_id' => 1,
                'type' => 'multiple_choice',
                'question_text' => '1',
                'image_path' => 'questions/images/01KJJYQ4P4M8E54KF0448J1F9B.png',
                'audio_path' => 'questions/audios/01KJJYQ4P0Z8T07TKJ4876G6E3.MP3',
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 03:23:25',
                'updated_at' => '2026-03-01 03:23:25',
            ),
            1 => 
            array (
                'id' => 3,
                'question_group_id' => 3,
                'type' => 'multiple_choice',
                'question_text' => '3',
                'image_path' => 'questions/images/01KJK3BEYCJ91Q3DQQ4H75R0PH.png',
                'audio_path' => 'questions/audios/01KJK3BEY2QHQ6Z0MC01H3AFNW.MP3',
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:44:25',
                'updated_at' => '2026-03-01 04:44:25',
            ),
            2 => 
            array (
                'id' => 4,
                'question_group_id' => 4,
                'type' => 'multiple_choice',
                'question_text' => '4',
                'image_path' => 'questions/images/01KJK3FTN65C776D4GVP50SPZY.png',
                'audio_path' => 'questions/audios/01KJK3CS8V90HW37FMVY7A7DBV.MP3',
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:45:08',
                'updated_at' => '2026-03-01 04:46:48',
            ),
            3 => 
            array (
                'id' => 5,
                'question_group_id' => 5,
                'type' => 'multiple_choice',
                'question_text' => '5',
                'image_path' => 'questions/images/01KJK3QECRZZV3A7CY64KCBAV0.png',
                'audio_path' => 'questions/audios/01KJK3QECJZ0XRZECKHDVDXE3Z.MP3',
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:50:57',
                'updated_at' => '2026-03-01 04:50:57',
            ),
            4 => 
            array (
                'id' => 6,
                'question_group_id' => 6,
                'type' => 'multiple_choice',
                'question_text' => '11',
                'image_path' => NULL,
                'audio_path' => 'questions/audios/01KJK422QBWMCDWMW3FT4QXH2F.mp3',
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:56:46',
                'updated_at' => '2026-03-01 04:56:46',
            ),
            5 => 
            array (
                'id' => 7,
                'question_group_id' => 7,
                'type' => 'multiple_choice',
                'question_text' => '12',
                'image_path' => NULL,
                'audio_path' => 'questions/audios/01KJK43FFSYFP1695FACNMWACH.mp3',
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 04:57:32',
                'updated_at' => '2026-03-01 04:57:32',
            ),
            6 => 
            array (
                'id' => 8,
                'question_group_id' => 8,
                'type' => 'short_answer',
                'question_text' => '41',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:02:16',
                'updated_at' => '2026-03-01 05:02:16',
            ),
            7 => 
            array (
                'id' => 9,
                'question_group_id' => 8,
                'type' => 'essay',
                'question_text' => '42',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:02:16',
                'updated_at' => '2026-03-01 05:02:16',
            ),
            8 => 
            array (
                'id' => 10,
                'question_group_id' => 8,
                'type' => 'short_answer',
                'question_text' => '43',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 3,
                'created_at' => '2026-03-01 05:02:16',
                'updated_at' => '2026-03-01 05:02:16',
            ),
            9 => 
            array (
                'id' => 11,
                'question_group_id' => 9,
                'type' => 'essay',
                'question_text' => '44',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:03:43',
                'updated_at' => '2026-03-01 05:03:43',
            ),
            10 => 
            array (
                'id' => 12,
                'question_group_id' => 9,
                'type' => 'short_answer',
                'question_text' => '45',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:03:43',
                'updated_at' => '2026-03-01 05:03:43',
            ),
            11 => 
            array (
                'id' => 13,
                'question_group_id' => 9,
                'type' => 'essay',
                'question_text' => '46',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 3,
                'created_at' => '2026-03-01 05:03:43',
                'updated_at' => '2026-03-01 05:03:43',
            ),
            12 => 
            array (
                'id' => 14,
                'question_group_id' => 10,
                'type' => 'record',
                'question_text' => '61',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:06:01',
                'updated_at' => '2026-03-01 05:06:01',
            ),
            13 => 
            array (
                'id' => 15,
                'question_group_id' => 10,
                'type' => 'essay',
                'question_text' => '62',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:06:01',
                'updated_at' => '2026-03-01 05:06:01',
            ),
            14 => 
            array (
                'id' => 16,
                'question_group_id' => 10,
                'type' => 'record',
                'question_text' => '63',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 3,
                'created_at' => '2026-03-01 05:06:01',
                'updated_at' => '2026-03-01 05:06:01',
            ),
            15 => 
            array (
                'id' => 17,
                'question_group_id' => 11,
                'type' => 'multiple_choice',
                'question_text' => 'Has anybody seen the ______ of toner that just arrived for the copy machine? ',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:07:46',
                'updated_at' => '2026-03-01 05:07:46',
            ),
            16 => 
            array (
                'id' => 18,
                'question_group_id' => 12,
                'type' => 'multiple_choice',
                'question_text' => 'There is a three-month probation ______ for all new employees. ',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:08:23',
                'updated_at' => '2026-03-01 05:08:23',
            ),
            17 => 
            array (
                'id' => 19,
                'question_group_id' => 13,
                'type' => 'multiple_choice',
                'question_text' => 'All staff members are ______ for the accuracy of their time cards. ',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:09:04',
                'updated_at' => '2026-03-01 05:09:04',
            ),
            18 => 
            array (
                'id' => 20,
                'question_group_id' => 14,
                'type' => 'multiple_choice',
                'question_text' => 'We expect to finish renovations on the building by the end of the month. In fact, work on the first and second floor offices ______ completed. ',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:11:16',
                'updated_at' => '2026-03-01 05:11:16',
            ),
            19 => 
            array (
                'id' => 21,
                'question_group_id' => 15,
                'type' => 'multiple_choice',
                'question_text' => '1',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            20 => 
            array (
                'id' => 22,
                'question_group_id' => 15,
                'type' => 'multiple_choice',
                'question_text' => '2',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:12:24',
                'updated_at' => '2026-03-01 05:12:24',
            ),
            21 => 
            array (
                'id' => 23,
                'question_group_id' => 16,
                'type' => 'multiple_choice',
                'question_text' => 'What is on sale?',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 1,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
            22 => 
            array (
                'id' => 24,
                'question_group_id' => 16,
                'type' => 'multiple_choice',
                'question_text' => 'Who is the sale for? ',
                'image_path' => NULL,
                'audio_path' => NULL,
                'points' => 1,
                'order_position' => 2,
                'created_at' => '2026-03-01 05:15:24',
                'updated_at' => '2026-03-01 05:15:24',
            ),
        ));
        
        
    }
}