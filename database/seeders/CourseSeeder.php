<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            'BS in Computer Science',
            'BS in Information Technology - Mobile Development',
            'BS in Information Technology - Network Administration',
            'BS in Electronics and Communications Engineering',
            'BS in Information Technology',
            'BS in Computer Engineering',
            'BS in Hospitality Management',
            'BS in Criminology',
            'BS in Business Administration',
            'BS in Accountancy',
            'BS in Hotel and Restaurant Management',
            'BS in Customs Administration',
            'BS in Psychology',
            'BS in Civil Engineering',
            'BS in Mechanical Engineering',
            'BS in Electrical Engineering',
            'BS in Information Systems',
            'BS in Marketing Management',
            'BS in Human Resource Management',
            'BS in Entrepreneurship',
            'BS in Agricultural Engineering',
            'BS in Business Analytics',
            'BS in Fine Arts',
            'BS in Social Work',
            'BS in Education',
            'BS in Physical Education',
        ];

        foreach ($courses as $course) {
            Course::create([
                'course' => $course
            ]);
        }
    }
}
