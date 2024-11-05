<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
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
                'id' => $user->id,
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

        $programChairs = User::with(['role', 'programChair', 'programChair.courseDepartment'])
        ->where('role_id', 2)
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
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

        $deans = User::with(['role', 'dean', 'dean.department'])
        ->where('role_id', 3)
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'role' => $user->role->role,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'department' => $user->dean->department->department,
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
            'data' => [
                'students' => $students,
                'program_chairs' => $programChairs,
                'deans' => $deans]
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}