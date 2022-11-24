<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $default = [
            ['name' => '認識基本零件、正確拆裝與簡單機械原理', 'created_at' => '2022-11-19 00:00:00'],
            ['name' => '積木進階技巧、馬達使用', 'created_at' => '2022-11-19 00:00:00'],
            ['name' => '電控自動機構、基礎機關', 'created_at' => '2022-11-19 00:00:00'],
            ['name' => '進階機關與串聯技巧、綠能-水力與液壓', 'created_at' => '2022-11-19 00:00:00'],
            ['name' => '認識Micro:bit、簡易程式控制', 'created_at' => '2022-11-19 00:00:00'],
            ['name' => '實物仿作與程控專題', 'created_at' => '2022-11-19 00:00:00'],
        ];

        DB::table('courses')->insert($default);
    }
}
