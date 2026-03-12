<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('sections')->delete();
        
        DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'exam_id' => 1,
                'title' => 'Listening',
                'duration' => 45,
                'description' => NULL,
                'order_position' => 1,
                'deleted_at' => NULL,
                'created_at' => '2026-02-27 16:48:35',
                'updated_at' => '2026-02-27 16:48:35',
            ),
            1 => 
            array (
                'id' => 2,
                'exam_id' => 1,
                'title' => 'Reading',
                'duration' => 75,
                'description' => NULL,
                'order_position' => 2,
                'deleted_at' => NULL,
                'created_at' => '2026-02-27 16:50:34',
                'updated_at' => '2026-02-27 16:50:34',
            ),
        ));
        
        
    }
}