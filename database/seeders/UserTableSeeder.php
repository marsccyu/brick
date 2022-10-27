<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->user_id = 'U16529820b6dd5a52ebd2f8e381759a22';
        $user->type = 'parents';
        $user->name = 'Mars';
        $user->email = 'bcawosxy@gmail.com';
        $user->telephone = '0912345678';
        $user->age = 20;
        $user->save();
    }
}
