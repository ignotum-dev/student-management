<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            'student',
            'program chair',
            'dean',
            'admin',
            'super_admin'
        ];

        foreach ($courses as $course) {
            Role::create([
                'role' => $course
            ]);
        }
    }
}
