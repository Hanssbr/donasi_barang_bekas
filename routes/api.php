<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request){
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('/all-items', ItemController::class);
Route::apiResource('/all-submissions', SubmissionController::class)->middleware('auth:sanctum');
Route::get('/recommendation', [ItemController::class, 'recomendation']);
Route::get('/favorit', [ItemController::class, 'favItem'])->middleware('auth:sanctum');
