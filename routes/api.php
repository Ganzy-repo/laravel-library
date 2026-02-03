<?php

use App\Http\Controllers\API\AuthServiceController;
use App\Http\Controllers\API\BookServiceController;
use App\Http\Controllers\API\BorrowServiceController;
use App\Http\Controllers\API\CategoryServiceController;
use Illuminate\Support\Facades\Route;

// AUTH ROUTES
Route::post('/auth', [AuthServiceController::class, 'auth']);

// PUBLIC ROUTES 
Route::get('/book', [BookServiceController::class, 'index']);
Route::get('/book/{id}', [BookServiceController::class, 'show']);
Route::get('/category', [CategoryServiceController::class, 'index']);
Route::get('/category/{id}', [CategoryServiceController::class, 'show']);

// PROTECTED ROUTES
Route::middleware(['auth:sanctum'])->group(function() {
    
    Route::post('/register', [AuthServiceController::class, 'register']);

    Route::post('/book', [BookServiceController::class, 'store']);
    Route::put('/book/{id}', [BookServiceController::class, 'update']);
    Route::delete('/book/{id}', [BookServiceController::class, 'destroy']);
    
    Route::post('/category', [CategoryServiceController::class, 'store']);
    Route::put('/category/{id}', [CategoryServiceController::class, 'update']);
    Route::delete('/category/{id}', [CategoryServiceController::class, 'destroy']);
    
    Route::get('/borrow', [BorrowServiceController::class, 'index']);

});