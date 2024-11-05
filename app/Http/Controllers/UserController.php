<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $studentController;
    protected $programChairController;
    protected $deanController;
    protected $adminController;
    protected $superAdminController;
    

    public function __construct(StudentController $studentController, ProgramChairController $programChairController, DeanController $deanController, AdminController $adminController, SuperAdminController $superAdminController)
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(User::class, 'user');
        $this->studentController = $studentController;
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
        $current_user = auth()->user();
        if ($current_user->isStudent()) {
            return $this->studentController->show($user->id);
        }

        if ($current_user->isProgramChair()) {
            if ($user->role_id == 1)
                return $this->studentController->show($user->id);
            elseif ($current_user->id == $user->id)
                return $this->programChairController->show($user->id);
        }

        if ($current_user->isDean()) {
            if ($user->role_id == 1)
                return $this->studentController->show($user->id);
            elseif ($user->role_id == 2)
                return $this->programChairController->show($user->id);
            elseif ($current_user->id == $user->id)
                return $this->deanController->show($user->id);
        }

        if ($current_user->isAdmin()) {
            if ($user->role_id == 1)
                return $this->studentController->show($user->id);
            elseif ($user->role_id == 2)
                return $this->programChairController->show($user->id);
            elseif ($user->role_id == 3)
                return $this->deanController->show($user->id);
            elseif ($current_user->id == $user->id)
                return $this->adminController->show($user->id);
        }

        if ($current_user->isSuperAdmin()) {
            if ($user->role_id == 1)
                return $this->studentController->show($user->id);
            elseif ($user->role_id == 2)
                return $this->programChairController->show($user->id);
            elseif ($user->role_id == 3)
                return $this->deanController->show($user->id);
            elseif ($user->role_id == 4)
                return $this->adminController->show($user->id);
            elseif ($user->role_id == 5)
                return $this->superAdminController->show($user->id);
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
