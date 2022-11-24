<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AboutUsSeeder extends Seeder
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
                'content' => "*關於工作室的介紹文字內容*",
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        DB::table('about_us')->insert($default_data);
    }
}
