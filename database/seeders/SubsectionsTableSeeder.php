<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubsectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('subsections')->delete();
        
        DB::table('subsections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'section_id' => 1,
                'title' => 'Photographs',
                'instructions' => 'Test takers look at a photograph and listen to four statements describing it. They must choose the statement that best describes what they see in the picture.',
                'order_position' => 1,
                'created_at' => '2026-02-27 16:52:03',
                'updated_at' => '2026-02-27 16:52:03',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'section_id' => 1,
                'title' => 'Question–Response',
                'instructions' => 'Test takers listen to a question or statement followed by three possible responses. They must select the response that best answers the question or is the most appropriate reply.',
                'order_position' => 2,
                'created_at' => '2026-02-27 16:52:12',
                'updated_at' => '2026-02-27 16:52:12',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'section_id' => 1,
                'title' => 'Conversations',
                'instructions' => 'Test takers listen to short conversations between two or more speakers and answer multiple questions based on what they have heard. Questions may refer to details, purpose, or implied meaning.',
                'order_position' => 3,
                'created_at' => '2026-02-27 16:52:24',
                'updated_at' => '2026-02-27 16:52:24',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'section_id' => 1,
                'title' => 'Talks',
                'instructions' => 'Test takers listen to short talks, such as announcements, advertisements, or recorded messages, and answer multiple questions based on the information provided.',
                'order_position' => 4,
                'created_at' => '2026-02-27 16:52:39',
                'updated_at' => '2026-02-27 16:52:39',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'section_id' => 2,
                'title' => 'Incomplete Sentences',
                'instructions' => 'Test takers read incomplete sentences and choose the word or phrase that best completes each sentence.',
                'order_position' => 1,
                'created_at' => '2026-02-27 16:56:39',
                'updated_at' => '2026-02-27 16:56:39',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'section_id' => 2,
                'title' => 'Text Completion',
                'instructions' => 'Test takers read short passages with missing words or sentences and select the best option to complete the text appropriately.',
                'order_position' => 2,
                'created_at' => '2026-02-27 16:57:09',
                'updated_at' => '2026-02-27 16:57:09',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'section_id' => 2,
                'title' => 'Reading Comprehension',
                'instructions' => 'Test takers read a variety of texts, such as emails, articles, advertisements, and notices, then answer multiple-choice questions based on the information provided.',
                'order_position' => 3,
                'created_at' => '2026-02-27 16:57:24',
                'updated_at' => '2026-02-27 16:57:24',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}