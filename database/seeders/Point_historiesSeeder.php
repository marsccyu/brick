<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class Point_historiesSeeder extends Seeder
{
    public function run()
    {
        $default = [
            [
                'point_task_id' => 2,
                'user_id' => 1,
                'before' => 0,
                'change' => 5,
                'after' => 5,
                'description' => 'add 5',
                'comment' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'point_task_id' => 2,
                'user_id' => 1,
                'before' => 5,
                'change' => 5,
                'after' => 10,
                'description' => 'add 5',
                'comment' => '',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('point_histories')->insert($default);
    }
}
