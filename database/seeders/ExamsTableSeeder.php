<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('exams')->delete();
        
        DB::table('exams')->insert(array (
            0 => 
            array (
                'id' => 1,
                'exam_type_id' => 1,
                'title' => 'TOEIC Listening & Reading',
                'total_duration' => 150,
                'is_active' => 1,
                'deleted_at' => NULL,
                'created_at' => '2026-02-27 16:42:22',
                'updated_at' => '2026-02-27 16:42:22',
            ),
            1 => 
            array (
                'id' => 2,
                'exam_type_id' => 1,
                'title' => 'TOEIC Speaking & Writing',
                'total_duration' => 80,
                'is_active' => 1,
                'deleted_at' => NULL,
                'created_at' => '2026-02-27 16:45:31',
                'updated_at' => '2026-02-27 16:45:31',
            ),
        ));
        
        
    }
}