<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\VacancyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\VacancyApplicationController;


Route::middleware('auth:sanctum')->group(function () {
    // Posts
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Vacancies
    Route::post('/vacancies', [VacancyController::class, 'store']);
    Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update']);
    Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy']);
    Route::get('/vacancy-applications', [VacancyApplicationController::class, 'index']);
    
});

// Public routes
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/vacancies', [VacancyController::class, 'index']);
Route::get('/vacancies/{vacancy}', [VacancyController::class, 'show']);
Route::post('/vacancy-applications', [VacancyApplicationController::class, 'store']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
