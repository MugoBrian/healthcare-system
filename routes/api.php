<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\HealthProgramController;
use App\Http\Middleware\UserIsAdmin;
use Illuminate\Support\Facades\Route;

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

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/doctors', [AuthController::class, 'listDoctors']);

    // Health Programs - Read operations available to all authenticated users
    Route::get('/health-programs', [HealthProgramController::class, 'index']);
    Route::get('/health-programs/{healthProgram}', [HealthProgramController::class, 'show']);
    Route::get('/health-programs/{healthProgram}/clients', [HealthProgramController::class, 'getEnrolledClients']);

    // Health Programs - Write operations restricted to admins
    Route::middleware(UserIsAdmin::class)->group(function () {
        Route::post('/health-programs', [HealthProgramController::class, 'store']);
        Route::put('/health-programs/{healthProgram}', [HealthProgramController::class, 'update']);
        Route::patch('/health-programs/{healthProgram}', [HealthProgramController::class, 'update']);
        Route::delete('/health-programs/{healthProgram}', [HealthProgramController::class, 'destroy']);
    });

    // Clients
    Route::apiResource('clients', ClientController::class);
    Route::get('/clients/search', [ClientController::class, 'search']);
    Route::get('/clients/{client}/programs', [ClientController::class, 'getEnrolledPrograms']);

    // Enrollments
    Route::apiResource('enrollments', EnrollmentController::class);
    Route::post('/enroll-client', [EnrollmentController::class, 'enrollClientInPrograms']);
});
