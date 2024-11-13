<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CourseDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = User::with(['role', 'student', 'student.courseDepartment'])
        ->where('id', $id)
        ->get()
        ->map(function ($user) {
            return [
                // 'id' => $user->id,
                'role' => $user->role->role,
                'student_number' => $user->student->student_number,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'department' => $user->student->courseDepartment->department->department,
                'course' => $user->student->courseDepartment->course->course,
                'year' => $user->student->year,
                'email' => $user->email,
                'dob' => $user->dob,
                'age' => $user->age,
                'sex' => $user->sex,
                'c_address' => $user->c_address,
                'h_address' => $user->h_address,            ];
        });

        return response()->json([
            'message' => 'Data retrieved successfully.',
            'data' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $validatedData, $id, $auth_user)
    {
        // Fetch existing user details
        $user = User::findOrFail($id);
        $student = $user->student; // Eager loading the student if exists

        // Handle role changes for super admin only
        if ($auth_user->isSuperAdmin() && isset($validatedData['role'])) {
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

        if (!$courseDepartment)
            return response()->json(['message' => 'The selected department and course is not match.'], 422);

        // Begin transaction for user and related entity updates
        DB::transaction(function () use ($validatedData, $user, $courseDepartment, $student, $auth_user) {
            // Update basic user details
            $user->update([
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                // 'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password, // Update password if provided
                // 'course_department_id' => $courseDepartment->id,
                // 'year' => $validatedData['year'],
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
        });

        return response()->json(['message' => 'User updated successfully!'], 200);
    }

        // // Method for validating the update request
        // private function validateRequest(Request $request, User $user, $student)
        // {
        //     return $request->validate([
        //         'role' => 'string|exists:roles,role',
        //         'student_number' => [
        //             'string',
        //             'max:10',
        //             'unique:students,student_number,' . $student->id,
        //             // Rule::unique('students', 'student_number')->ignore($student->student_number),
        //         ],
        //         'first_name' => 'string|max:255',
        //         'middle_name' => 'nullable|string|max:255',
        //         'last_name' => 'string|max:255',
        //         'email' => [
        //             'email',
        //             'unique:users,email,' . $user->id,
        //         ],
        //         // 'password' => 'nullable|string|min:8|confirmed',
        //         'course' => 'string|exists:courses,course',
        //         'department' => 'string|exists:departments,department',
        //         'year' => 'in:First Year,Second Year,Third Year,Fourth Year',
        //         'dob' => 'date',
        //         'age' => 'integer|min:18|max:100',
        //         'sex' => 'in:Male,Female',
        //         'c_address' => 'string|max:255',
        //         'h_address' => 'string|max:255',
        //     ]);
        // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
