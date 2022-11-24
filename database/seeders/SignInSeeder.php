<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Seeder;
use DB;

class SignInSeeder extends Seeder
{
    public function run()
    {
        $classes = Classes::all();

        foreach ($classes as $class)
        {
            $default_data[] = [
                'lesson_id' => $class->lesson_id,
                'classes_id' => $class->id,
                'user_id' => 1,
                'userId' => 'U16529820b6dd5a52ebd2f8e381759a22'
            ];
        }

        DB::table('sign_in')->insert($default_data);
    }
}
