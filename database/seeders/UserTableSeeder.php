<?php

namespace Database\Seeders;

use App\Models\Point_history;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $default = [
            [
                'userId' => 'U16529820b6dd5a52ebd2f8e381759a22',
                'password' => 'U16529820b6dd5a52ebd2f8e381759a22b',
                'type' => 'parents',
                'name' => 'Test',
                'email' => 'test@mail.com',
                'telephone' => '0912345678',
                'age' => 20,
            ],
            [
                'userId' => 'Ub0fc501c96142753beadf6bd74a3d8d8',
                'password' => 'Ub0fc501c96142753beadf6bd74a3d8d8',
                'type' => 'parents',
                'name' => '邱泓宇',
                'email' => 'silence5842@gmail.com',
                'telephone' => '0953178798',
                'age' => 10,
            ],
        ];

        DB::table('users')->insert($default);

    }
}
