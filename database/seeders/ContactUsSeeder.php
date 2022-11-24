<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ContactUsSeeder extends Seeder
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
                'title' => 'header',
                'content' => '秘密積地',
                'description' => '訊息標題' ,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'place',
                'content' => '桃園市平鎮區南京路 109 號 4 樓',
                'description' => '地址' ,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'tel',
                'content' => '0953-178-798 邱老師',
                'description' => '電話及聯絡人' ,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'time1',
                'content' => '一 ~ 五 17:00 後',
                'description' => '開課時間一' ,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'time2',
                'content' => '六、日 09:00~21:00 可開課',
                'description' => '開課時間二' ,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'map_uri',
                'content' => 'https://goo.gl/maps/B14rsbC53o68cAxm6',
                'description' => 'Google Map 地址連結' ,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        DB::table('contact_us')->insert($default_data);
    }
}
