<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\ProgramChair;
use Illuminate\Database\Seeder;
use App\Models\CourseDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramChairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $users = User::where('role_id', 2)->get(); // Get users with role_id 2

    foreach ($users as $user) {
        $course = Course::inRandomOrder()->first(); // Get a random course

        ProgramChair::create([
            'user_id' => $user->id,
            'course_department_id' => CourseDepartment::inRandomOrder()->first()->id,
        ]);
    }
}
}
