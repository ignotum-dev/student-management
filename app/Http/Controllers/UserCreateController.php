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
use Illuminate\Support\Facades\Hash;

class UserCreateController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        $role = Role::where('role', $validatedData['role'])->first();
        $department_id = Department::where('department', $validatedData['department'])->first()->id;
        $course_id = Course::where('course', $validatedData['course'])->first()->id;
        $course_departments = CourseDepartment::where([
            ['department_id', $department_id],
            ['course_id', $course_id],
        ])->first();

<<<<<<< HEAD
        if (!$course_departments)
             return response()->json(['message' => 'The selected department and course is not match.'], 422);

=======
>>>>>>> d3f1ffb5e7265c7b67bee239ff3fbc563bf4d133
        DB::transaction(function () use ($validatedData, $role, $department_id, $course_departments) {
            $user = User::create([
                'role_id' => $role->id,
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'dob' => $validatedData['dob'],
                'age' => $validatedData['age'],
                'sex' => $validatedData['sex'],
                'c_address' => $validatedData['c_address'],
                'h_address' => $validatedData['h_address'],
            ]);

            if ($user->isStudent())
                Student::create([
                    'user_id' => $user->id,
                    'student_number' => $validatedData['student_number'],
                    'course_department_id' => $course_departments->id,
                    'year' => $validatedData['year'],
                ]);
            
            if ($user->isProgramChair())
                ProgramChair::create([
                    'user_id' => $user->id,
                    'course_department_id' => $course_departments->id,
                ]);

            if ($user->isDean())
                Dean::create([
                    'user_id' => $user->id,
                    'department_id' => $department_id
                ]);
        });

        return response()->json(['message' => 'User created successfully!'], 201);
    }

    // Moved validation logic to a separate method
    private function validateRequest(Request $request)
    {
        $validatedData = [
            'role' => 'required|string|exists:roles,role',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'dob' => 'required|date',
            'age' => 'required|integer|min:18|max:100',
            'sex' => 'required|in:Male,Female',
            'c_address' => 'required|string|max:255',
            'h_address' => 'required|string|max:255',
        ];

        if ($request->role == 'student')
            $validatedData['student_number'] = 'required|string|max:10|unique:students,student_number';
            $validatedData['course'] = 'required|string|exists:courses,course';
            $validatedData['department'] = 'required|string|exists:departments,department';
            $validatedData['year'] = 'required|in:First Year,Second Year,Third Year,Fourth Year';

        if ($request->role == 'program chair')
            $validatedData['course'] = 'required|string|exists:courses,course';
            $validatedData['department'] = 'required|string|exists:departments,department';

        if ($request->role == 'dean')
            $validatedData['department'] = 'required|string|exists:departments,department';

        return $request->validate($validatedData);
    }
}