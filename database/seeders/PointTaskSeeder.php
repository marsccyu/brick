<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PointTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_data = [
            [
                'name' => 'bind_account',
                'description' => '綁定 Line 帳號完成',
                'point' => '10'
            ],
            [
                'name' => 'sign_in',
                'description' => '完成課程',
                'point' => '5'
            ],
            [
                'name' => 'exchange-5',
                'description' => '兌換一項物品',
                'point' => '-5'
            ],
        ];

        DB::table('point_tasks')->insert($default_data);
    }
}
