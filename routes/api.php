<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookServiceController;

Route::get('/book', [BookServiceController::class, 'index']);
Route::get('/book/{id}', [BookServiceController::class, 'show']);
Route::post('/book', [BookServiceController::class, 'store']);
Route::put('/book/{id}', [BookServiceController::class, 'update']);
Route::delete('/book/{id}', [BookServiceController::class, 'destroy']);