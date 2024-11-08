<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CourseDepartment;
use Illuminate\Support\Facades\DB;

class ProgramChairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::with(['role', 'student', 'student.courseDepartment'])
        ->where('role_id', 1)
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
                'h_address' => $user->h_address,
            ];
        });

        return response()->json([
            'message' => 'Data retrieved successfully.',
            'data' => ['students' => $students]
        ]);
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
        $user_search = User::with(['role', 'programChair', 'programChair.courseDepartment'])
        ->where('id', $id)
        ->get()
        ->map(function ($user) {
            return [
                // 'id' => $user->id,
                'role' => $user->role->role,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'department' => $user->programChair->courseDepartment->department->department,
                'course' => $user->programChair->courseDepartment->course->course,
                'email' => $user->email,
                'dob' => $user->dob,
                'age' => $user->age,
                'sex' => $user->sex,
                'c_address' => $user->c_address,
                'h_address' => $user->h_address,
            ];
        });

        return response()->json([
            'message' => 'Data retrieved successfully.',
            'data' => $user_search
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $validatedData, $id, $auth_user)
    {
         // Fetch existing user details
         $user = User::findOrFail($id);
         $programChair = $user->programChair; 

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
         DB::transaction(function () use ($validatedData, $user, $courseDepartment, $programChair) {
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

            $programChair->update([
                'course_department_id' => $courseDepartment->id,
            ]);
         });
 
         return response()->json(['message' => 'User updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
