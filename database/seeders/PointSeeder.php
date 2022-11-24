<?php

namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Seeder;
use App\Models\User;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();

        foreach ($user_ids as $user_id)
        {
            $point = new Point();
            $point->user_id = $user_id;
            $point->save();
        }
    }
}
