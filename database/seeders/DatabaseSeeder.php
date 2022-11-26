<?php

namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
//            UserTableSeeder::class,
            SiteConfigSeeder::class,
            AboutUsSeeder::class,
            ContactUsSeeder::class,
            PointTaskSeeder::class,
//            PointSeeder::class,
            LessonsCardSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
//            ClassesSeeder::class,
//            SignInSeeder::class,
//            Point_historiesSeeder::class,
        ]);
    }
}
