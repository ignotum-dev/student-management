<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $programChairController;
    protected $deanController;
    protected $adminController;
    protected $superAdminController;
    

    public function __construct(ProgramChairController $programChairController, DeanController $deanController, AdminController $adminController, SuperAdminController $superAdminController)
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(User::class, 'user');
        $this->programChairController = $programChairController;
        $this->deanController = $deanController;
        $this->adminController = $adminController;
        $this->superAdminController = $superAdminController;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {      
        $user = auth()->user();
        // $this->authorize('index-student', $user);
        
        if ($user->isProgramChair()) {
            return $this->programChairController->index();
        }

        if ($user->isDean()) {
            return $this->deanController->index();
        }

        if ($user->isAdmin()) {
            return $this->adminController->index();
        }

        if ($user->isSuperAdmin()) {
            return $this->superAdminController->index();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = auth()->user();

        // $this->authorize('index-student', $user);
        
        $validatedData = $request->validate([
            'role_id' => 'required|numeric|exists:roles,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // User email
            'password' => 'required|string|min:8|confirmed', // Password confirmation
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
                'data' => $user->makeHidden([
                    'role_id',
                    'email_verified_at',
                    'created_at', 
                    'updated_at']),
            ]);
        } else {
            return response()->json([
                'message' => 'Data retrieved successfully.',
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
            'role_id' => 'required|numeric|exists:roles,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // User email
            'password' => 'required|string|min:8|confirmed', // Password confirmation
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
