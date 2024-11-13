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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateDeanRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateStudentRequest;
<<<<<<< HEAD
use App\Http\Requests\UpdateSuperAdminRequest;
=======
>>>>>>> d3f1ffb5e7265c7b67bee239ff3fbc563bf4d133
use App\Http\Requests\UpdateProgramChairRequest;

class UserController extends Controller
{
    protected $studentController;
    protected $programChairController;
    protected $deanController;
    protected $adminController;
    protected $superAdminController;
    protected $userCreateController;
<<<<<<< HEAD
    protected $userRoleUpdateController;

    

    public function __construct(StudentController $studentController, ProgramChairController $programChairController, DeanController $deanController, AdminController $adminController, SuperAdminController $superAdminController, UserCreateController $userCreateController, UserRoleUpdateController $userRoleUpdateController)
=======
    protected $userUpdateController;
    

    public function __construct(StudentController $studentController, ProgramChairController $programChairController, DeanController $deanController, AdminController $adminController, SuperAdminController $superAdminController, UserCreateController $userCreateController, UserUpdateController $userUpdateController)
>>>>>>> d3f1ffb5e7265c7b67bee239ff3fbc563bf4d133
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(User::class, 'user');
        $this->studentController = $studentController;
        $this->programChairController = $programChairController;
        $this->deanController = $deanController;
        $this->adminController = $adminController;
        $this->superAdminController = $superAdminController;
        $this->userCreateController = $userCreateController;
<<<<<<< HEAD
        $this->userRoleUpdateController = $userRoleUpdateController;
=======
        $this->userUpdateController = $userUpdateController;
>>>>>>> d3f1ffb5e7265c7b67bee239ff3fbc563bf4d133
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
        $user = auth()->user();

        if ($request->role == 'student')
            return $this->userCreateController->store($request);
        elseif ($request->role == 'program chair')
            if ($user->isProgramChair())
                return response()->json(['message' => 'Unauthorized Access'], 403);
            else
                return $this->userCreateController->store($request);
        elseif ($request->role == 'dean')
            if ($user->isProgramChair() || $user->isDean())
                return response()->json(['message' => 'Unauthorized Access'], 403);
            else
                return $this->userCreateController->store($request);
        elseif ($request->role == 'admin')
            if ($user->isProgramChair() || $user->isDean() || $user->isAdmin())
                return response()->json(['message' => 'Unauthorized Access'], 403);
            else
                return $this->userCreateController->store($request);
        elseif ($request->role == 'super admin')
            if (!$user->isSuperAdmin())
                return response()->json(['message' => 'Unauthorized Access'], 403);
            else
                return $this->userCreateController->store($request);
        else
            return response()->json(['message' => 'Invalid Role'], 400);
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
    public function update(Request $request, User $user)
    {     
        // return $this->userUpdateController->update($request, $user->id);

        $auth_user = auth()->user();

        if ($auth_user->isStudent()) {
            $validatedData = app(UpdateStudentRequest::class)->validated();
            return $this->studentController->update($validatedData, $user->id, $auth_user);
        } elseif ($auth_user->isProgramChair()) {
            if ($user->isStudent()) {
                $validatedData = app(UpdateStudentRequest::class)->validated();
                return $this->studentController->update($validatedData, $user->id, $auth_user);
            } else {
                $validatedData = app(UpdateProgramChairRequest::class)->validated();
                return $this->programChairController->update($validatedData, $user->id, $auth_user);
            }
        } elseif ($auth_user->isDean()) {
            if ($user->isStudent()) {
                $validatedData = app(UpdateStudentRequest::class)->validated();
                return $this->studentController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isProgramChair()){
                $validatedData = app(UpdateProgramChairRequest::class)->validated();
                return $this->programChairController->update($validatedData, $user->id, $auth_user);
            } else {
                $validatedData = app(UpdateDeanRequest::class)->validated();
                return $this->deanController->update($validatedData, $user->id, $auth_user);
            }
        } elseif ($auth_user->isAdmin()) {
            if ($user->isStudent()) {
                $validatedData = app(UpdateStudentRequest::class)->validated();
                return $this->studentController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isProgramChair()){
                $validatedData = app(UpdateProgramChairRequest::class)->validated();
                return $this->programChairController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isDean()) {
                $validatedData = app(UpdateDeanRequest::class)->validated();
                return $this->deanController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isAdmin()) {
                $validatedData = app(UpdateAdminRequest::class)->validated();
                return $this->adminController->update($validatedData, $user->id, $auth_user);
            }
<<<<<<< HEAD
        } elseif ($auth_user->isSuperAdmin()) {
            if ($user->isStudent()) {
                $validatedData = app(UpdateStudentRequest::class)->validated();
                $this->userRoleUpdateController->update($validatedData, $user);
                return $this->studentController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isProgramChair()) {
                $validatedData = app(UpdateProgramChairRequest::class)->validated();
                $this->userRoleUpdateController->update($validatedData, $user);
                return $this->programChairController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isDean()) {
                $validatedData = app(UpdateDeanRequest::class)->validated();
                $this->userRoleUpdateController->update($validatedData, $user);
                return $this->deanController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isAdmin()) {
                $validatedData = app(UpdateAdminRequest::class)->validated();
                $this->userRoleUpdateController->update($validatedData, $user);
                return $this->adminController->update($validatedData, $user->id, $auth_user);
            } elseif ($user->isSuperAdmin()) {
                $validatedData = app(UpdateSuperAdminRequest::class)->validated();
                $this->userRoleUpdateController->update($validatedData, $user);
                return $this->superAdminController->update($validatedData, $user->id, $auth_user);
            }
=======
>>>>>>> d3f1ffb5e7265c7b67bee239ff3fbc563bf4d133
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
