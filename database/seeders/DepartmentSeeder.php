<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'College of Arts and Social Sciences and Education',
            'College of Business',
            'College of Computing and Information Sciences',
            'College of Criminology',
            'College of Engineering',
            'College of Hospitality and Tourism Management',
            'College of Nursing',
            'College of Engineering'
        ];
        
        foreach ($departments as $department) {
            Department::create([
                'department' => $department
            ]);
        }
    }
}
