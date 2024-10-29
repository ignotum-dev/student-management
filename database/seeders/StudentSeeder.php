<?php

namespace Database\Seeders;

use App\Models\CourseDepartment;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', 1)->get(); // Get users with role_id 1
    
        foreach ($users as $user) {
            Student::create([
                'user_id' => $user->id,
                'student_number' => (string) fake()->unique()->numerify('01223#####'),
                'course_department_id' => CourseDepartment::inRandomOrder()->first()->id,
                'year' => fake()->randomElement(['First Year', 'Second Year', 'Third Year', 'Fourth Year']),
            ]);
        }
    }
}
