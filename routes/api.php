<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookServiceController;
use App\Http\Controllers\API\CategoryServiceController;


// Route::apiResource('category', CategoryServiceController::class);
Route::get('/book', [BookServiceController::class, 'index']);
Route::get('/book/{id}', [BookServiceController::class, 'show']);
Route::post('/book', [BookServiceController::class, 'store']);
Route::put('/book/{id}', [BookServiceController::class, 'update']);
Route::delete('/book/{id}', [BookServiceController::class, 'destroy']);


Route::get('/category', [CategoryServiceController::class, 'index']);
Route::get('/category/{id}', [CategoryServiceController::class, 'show']);
Route::post('/category', [CategoryServiceController::class, 'store']);
Route::put('/category/{id}', [CategoryServiceController::class, 'update']);
Route::delete('/category/{id}', [CategoryServiceController::class, 'destroy']);

