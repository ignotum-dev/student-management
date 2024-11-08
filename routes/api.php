<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class,'login']);

Route::post('/logout', [AuthController::class,'logout'])
->middleware('auth:sanctum');

Route::apiResource('courses', CourseController::class);

Route::apiResource('roles', RoleController::class);

Route::apiResource('users', UserController::class);

// Route::put('/update/{id}', [UserController::class,'updates']);
