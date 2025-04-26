<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\HealthProgramController;
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

    // Health Programs
    Route::apiResource('health-programs', HealthProgramController::class);
    Route::get('/health-programs/{healthProgram}/clients', [HealthProgramController::class, 'getEnrolledClients']);

    // Clients
    Route::apiResource('clients', ClientController::class);
    Route::get('/clients/search', [ClientController::class, 'search']);
    Route::get('/clients/{client}/programs', [ClientController::class, 'getEnrolledPrograms']);

    // Enrollments
    Route::apiResource('enrollments', EnrollmentController::class);
    Route::post('/enroll-client', [EnrollmentController::class, 'enrollClientInPrograms']);
});
