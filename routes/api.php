<?php

use App\Http\Controllers\API\AuthServiceController;
use App\Http\Controllers\API\BookServiceController;
use App\Http\Controllers\API\CategoryServiceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/book', BookServiceController::class)->middleware(['auth:sanctum']);
Route::apiResource('/category', CategoryServiceController::class)->middleware(['auth:sanctum']);

Route::post('/auth', [AuthServiceController::class, 'auth']);
Route::post('/register', [AuthServiceController::class, 'register']);
// Route::get('/book', [BookServiceController::class, 'index']);
// Route::get('/book/{id}', [BookServiceController::class, 'show']);
// Route::post('/book', [BookServiceController::class, 'store']);
// Route::put('/book/{id}', [BookServiceController::class, 'update']);
// Route::delete('/book/{id}', [BookServiceController::class, 'destroy']);

// Route::get('/category', [CategoryServiceController::class, 'index']);
// Route::get('/category/{id}', [CategoryServiceController::class, 'show']);
// Route::post('/category', [CategoryServiceController::class, 'store']);
// Route::put('/category/{id}', [CategoryServiceController::class, 'update']);
// Route::delete('/category/{id}', [CategoryServiceController::class, 'destroy']);
