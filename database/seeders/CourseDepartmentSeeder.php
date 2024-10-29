<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;
use App\Models\CourseDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the course-to-department mapping
        $courseDepartmentMap = [
            'BS in Computer Science' => 'College of Computing and Information Sciences',
            'BS in Information Technology - Mobile Development' => 'College of Computing and Information Sciences',
            'BS in Information Technology - Network Administration' => 'College of Computing and Information Sciences',
            'BS in Information Technology' => 'College of Computing and Information Sciences',
            'BS in Computer Engineering' => 'College of Engineering',
            'BS in Hospitality Management' => 'College of Hospitality and Tourism Management',
            'BS in Criminology' => 'College of Criminology',
            'BS in Business Administration' => 'College of Business',
            'BS in Accountancy' => 'College of Business',
            'BS in Hotel and Restaurant Management' => 'College of Hospitality and Tourism Management',
            'BS in Customs Administration' => 'College of Business',
            'BS in Electrical Engineering' => 'College of Engineering',
            'BS in Information Systems' => 'College of Computing and Information Sciences',
            'BS in Marketing Management' => 'College of Business',
            'BS in Human Resource Management' => 'College of Business',
            'BS in Entrepreneurship' => 'College of Business',
            'BS in Fine Arts' => 'College of Arts and Social Sciences and Education',
            'BS in Social Work' => 'College of Arts and Social Sciences and Education',
            'BS in Education' => 'College of Arts and Social Sciences and Education',
            'BS in Physical Education' => 'College of Arts and Social Sciences and Education',
        ];

        // Loop through the mapping and create CourseDepartment records
        foreach ($courseDepartmentMap as $courseName => $departmentName) {
            $course = Course::where('course', $courseName)->first();
            $department = Department::where('department', $departmentName)->first();

            if ($course && $department) {
                CourseDepartment::create([
                    'course_id' => $course->id,
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
