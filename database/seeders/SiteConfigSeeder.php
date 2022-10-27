<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site_config;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = new Site_config();
        $config->key = config('site_config.FLEX_MEMBER_WELCOME_JOIN_MEMBER_MSG');
        $config->value = "測試用的請加入會員訊息";
        $config->description = "測試用的請加入會員訊息";
        $config->save();
    }
}
