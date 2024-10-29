<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        // $this->authorize('index-student', $user);

        if ($user->role_id === 1) {
            return response()->json([
                'message' => 'Not authorized to view the data.',
                'status' => 403,
                'data' => null
            ]);
        }
        
        if ($user->role_id === 2) {
            return response()->json([
                'message' => 'Data retrieved successfully.',
                'status' => 200,
                'data' => User::where('role_id', 1)
                ->get()
            ]);
        }

        if ($user->role_id === 3) {
            return response()->json([
                'message' => 'Data retrieved successfully.',
                'status' => 200,
                'data' => User::
                where('role_id', 1)
                ->orWhere('role_id', 2)
                ->get()
            ]);
        }

        if ($user->role_id === 4) {
            return response()->json([
                'message' => 'Data retrieved successfully.',
                'status' => 200,
                'data' => User::
                where('role_id', 1)
                ->orWhere('role_id', 2)
                ->orWhere('role_id', 3)
                ->get()
            ]);
        }

        if ($user->role_id === 5) {
            return response()->json([
                'message' => 'Data retrieved successfully.',
                'status' => 200,
                'data' => User::all()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $this->authorize('index-student', $user);
        
        $validatedData = $request->validate([
            'role_id' => 'required|numeric|exists:courses,id',
            'course_id' => 'required|numeric|exists:courses,id',
            'user_number' => 'required|string|max:255|unique:users,user_number',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // User email
            'password' => 'required|string|min:8|confirmed', // Password confirmation
            'year' => 'required|in:First Year,Second Year,Third Year,Fourth Year',
            'dob' => 'required|date',
            'age' => 'required|integer|min:18|max:100',
            'sex' => 'required|in:Male,Female',
            'c_address' => 'required|string|max:255',
            'h_address' => 'required|string|max:255', 
        ]);    
        
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return response()->json(['message' => 'User created successfully!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // $this->authorize('show-student', $user);
        if ($user->role_id === 1) {
            return response()->json([
                'message' => 'Data retrieved successfully.',
                'status' => 200,
                'data' => $user->makeHidden([
                    'role_id',
                    'email_verified_at',
                    'created_at', 
                    'updated_at']),
            ]);
        } else {
            return response()->json([
                'message' => 'Data retrieved successfully.',
                'status' => 200,
                'data' => $user->makeHidden([
                    'email_verified_at',
                    'created_at', 
                    'updated_at']),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'role_id' => 'required|numeric|exists:courses,id',
            'course_id' => 'required|numeric|exists:courses,id',
            'user_number' => 'required|string|max:255|unique:users,user_number',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // User email
            'password' => 'required|string|min:8|confirmed', // Password confirmation
            'year' => 'required|in:First Year,Second Year,Third Year,Fourth Year',
            'dob' => 'required|date',
            'age' => 'required|integer|min:18|max:100',
            'sex' => 'required|in:Male,Female',
            'c_address' => 'required|string|max:255',
            'h_address' => 'required|string|max:255', 
        ]);    
        
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::update($validatedData);

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
