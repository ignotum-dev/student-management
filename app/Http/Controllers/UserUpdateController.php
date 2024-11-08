<?php

namespace App\Http\Controllers;

use App\Models\Dean;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Department;
use App\Models\ProgramChair;
use App\Models\CourseDepartment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserUpdateController extends Controller
{
    public function update(Request $request, $id)
    {
        $auth_user = auth()->user();
        
        // Check if the current user is allowed to update the role
        if ($request->has('role') && !$auth_user->isSuperAdmin()) {
            return response()->json(['error' => 'Not authorized to edit the role.'], 403);
        }

        // Prevent student and program chair can't update their own student number
        if ($request->has('student_number') && ($auth_user->isStudent() || $auth_user->isProgramChair())) {
            return response()->json(['error' => 'Not authorized to edit the student number.'], 403);
        }

        // Fetch existing user details
        $user = User::findOrFail($id);
        $student = $user->student; // Eager loading the student if exists

        // Validate incoming request
        $validatedData = $this->validateRequest($request, $user, $student);

        // Handle role changes for super admin only
        if ($auth_user->isSuperAdmin() && $request->has('role')) {
            $role = Role::where('role', $validatedData['role'])->first();
            $user->role()->associate($role);  // Update user role
        }

        // Find the department and course based on input
        $department = Department::where('department', $validatedData['department'])->first();
        $course = Course::where('course', $validatedData['course'])->first();
        $courseDepartment = CourseDepartment::where([
            ['department_id', $department->id],
            ['course_id', $course->id],
        ])->first();

        // Begin transaction for user and related entity updates
        DB::transaction(function () use ($validatedData, $user, $department, $courseDepartment, $student, $auth_user) {
            // Update basic user details
            $user->update([
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                // 'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password, // Update password if provided
                'dob' => $validatedData['dob'],
                'age' => $validatedData['age'],
                'sex' => $validatedData['sex'],
                'c_address' => $validatedData['c_address'],
                'h_address' => $validatedData['h_address'],
            ]);

            if ($user->isStudent()) {
                $student = $user->student;
                if (!$auth_user->isStudent() && !$auth_user->isProgramChair())
                    $student->update([
                        'student_number' => $validatedData['student_number'],
                        'course_department_id' => $courseDepartment->id,
                        'year' => $validatedData['year'],
                    ]);
                else 
                    $student->update([
                        'course_department_id' => $courseDepartment->id,
                        'year' => $validatedData['year'],
                    ]);
            }

            // Update program chair details if applicable
            if ($user->isProgramChair()) {
                $programChair = $user->programChair;
                $programChair->update([
                    'course_department_id' => $courseDepartment->id,
                ]);
            }

            // Update dean details if applicable
            if ($user->isDean()) {
                $dean = $user->dean;
                $dean->update([
                    'department_id' => $department->id,
                ]);
            }
        });

        return response()->json(['message' => 'User updated successfully!'], 200);
    }

    // Method for validating the update request
    private function validateRequest(Request $request, User $user, $student)
    {
        return $request->validate([
            'role' => 'string|exists:roles,role',
            'student_number' => [
                'string',
                'max:10',
                'unique:students,student_number,' . $student->id,
                // Rule::unique('students', 'student_number')->ignore($student->student_number),
            ],
            'first_name' => 'string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'string|max:255',
            'email' => [
                'email',
                'unique:users,email,' . $user->id,
            ],
            // 'password' => 'nullable|string|min:8|confirmed',
            'course' => 'string|exists:courses,course',
            'department' => 'string|exists:departments,department',
            'year' => 'in:First Year,Second Year,Third Year,Fourth Year',
            'dob' => 'date',
            'age' => 'integer|min:18|max:100',
            'sex' => 'in:Male,Female',
            'c_address' => 'string|max:255',
            'h_address' => 'string|max:255',
        ]);
    }
}

