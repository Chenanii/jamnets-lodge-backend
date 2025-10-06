<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\VacancyController;

Route::apiResource('posts', PostController::class);
Route::apiResource('vacancies', VacancyController::class);
