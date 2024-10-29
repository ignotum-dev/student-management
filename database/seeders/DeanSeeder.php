<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', 3)->get(); // Get users with role_id 2
    
        foreach ($users as $user) {
            $department = Department::inRandomOrder()->first(); // Get a random department
    
            Dean::create([
                'user_id' => $user->id,
                'department_id' => $department->id,
            ]);
        }
    }    
}
