<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LessonsCardSeeder extends Seeder
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
                'title' => '初階課程',
                'subtitle' => '科學結構 / 邏輯編程',
                'display' => 1,
                'image' => 'images/lessons/f-level-1.png',
                'content' => '*初階課程介紹文字*',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => '中階課程',
                'subtitle' => '動力機械 / 單體機關 ',
                'display' => 1,
                'image' => 'images/lessons/f-level-2.png',
                'content' => '*中階課程介紹文字*',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => '進階課程',
                'subtitle' => '機關串聯 / 程式控制',
                'display' => 1,
                'image' => 'images/lessons/f-level-3.png',
                'content' => '*高階課程介紹文字*',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        DB::table('lesson_cards')->insert($default_data);
    }
}
