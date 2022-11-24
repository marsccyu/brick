<?php

namespace Database\Seeders;

use http\Client\Curl\User;
use Illuminate\Database\Seeder;
use App\Models\Site_config;
use DB;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_config = [
            [
                'key' => config('site_config.TITLE'),
                'value' => '秘密積地',
                'description' => '工作室名稱',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'key' => config('site_config.FLEX_MEMBER_WELCOME_JOIN_MEMBER_MSG'),
                'value' => '尚未綁定會員資料, 請點擊下面連結進行綁定',
                'description' => '會員綁定提示訊息',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'key' => config('site_config.FLEX_MEMBER_MSG'),
                'value' => '歡迎使用會員功能',
                'description' => '會員功能提示訊息',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'key' => config('site_config.POINT_FEATURE'),
                'value' => '1',
                'description' => '積分功能開關',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'key' => config('site_config.SIGN_IN_FEATURE'),
                'value' => '1',
                'description' => '簽到功能開關',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        DB::table('site_configs')->insert($default_config);
    }
}
