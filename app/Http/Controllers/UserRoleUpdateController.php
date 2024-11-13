<?php

namespace App\Http\Controllers;

use App\Models\Dean;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Department;
use App\Models\ProgramChair;
use Illuminate\Http\Request;

use App\Models\CourseDepartment;
use Illuminate\Support\Facades\DB;

class UserRoleUpdateController extends Controller
{
    public function update($validatedData, $user)
    {
        DB::beginTransaction();
        try {
            // Find the new role, department, and course
            $dataRole = Role::where('role', $validatedData['role'])->first();
            $department = Department::where('department', $validatedData['department'])->first();
            $course = Course::where('course', $validatedData['course'])->first();

            // Validate course-department alignment
            $courseDepartment = CourseDepartment::where([
                ['department_id', $department->id],
                ['course_id', $course->id],
            ])->first();

            if (!$courseDepartment) {
                return response()->json(['message' => 'The selected department and course do not match.'], 422);
            }

            // Update role if it has changed
            if ($dataRole->id != $user->role_id) {
                // Remove existing role data
                if ($user->isStudent())
                    Student::where('user_id', $user->id)->delete();
                if ($user->isProgramChair()) 
                    ProgramChair::where('user_id', $user->id)->delete();
                if ($user->isDean()) 
                    Dean::where('user_id', $user->id)->delete();
                

                // Assign new role data based on the new role
                if ($dataRole->id == 1) { // Student
                    Student::create([
                        'user_id' => $user->id,
                        'student_number' => $validatedData['student_number'],
                        'course_department_id' => $courseDepartment->id,
                        'year' => $validatedData['year'],
                    ]);
                } elseif ($dataRole->id == 2) { // Program Chair
                    ProgramChair::create([
                        'user_id' => $user->id,
                        'course_department_id' => $courseDepartment->id,
                    ]);
                } elseif ($dataRole->id == 3) { // Dean
                    Dean::create([
                        'user_id' => $user->id,
                        'department_id' => $department->id,
                    ]);
                }

                // $role = Role::where('role', $validatedData['role'])->first();
                // $user->role()->associate($role);  // Update user role
                
                // Associate and save new role for user
                $user->role_id = $dataRole->id;
                $user->save();
            }

            DB::commit();

            return response()->json(['message' => 'User role updated successfully.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating the user role.'], 500);
        }
    }
}
