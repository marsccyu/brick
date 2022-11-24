<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Lesson;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = Lesson::where('id', '<', 21)->get();

        foreach ($lessons as $lesson) {
            $classes[] = [
                'course_id' => $lesson->course_id,
                'lesson_id' => $lesson->id,
                'title' => sprintf("%s [假日班]", $lesson->title),
                'description' => sprintf("班級介紹 %s [%s]", $lesson->title, $lesson->content),
                'start' => date('Y-m-d 00:00:00'),
                'end' => date('Y-m-d 23:59:59'),
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $default_classes = $classes;

        DB::table('classes')->insert($default_classes);
    }
}
