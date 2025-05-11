<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoriteController;
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
Route::post('/all-items', [ItemController::class, 'store'])->middleware('auth:sanctum');
Route::apiResource('/all-submissions', SubmissionController::class)->middleware('auth:sanctum');
Route::get('/recommendation', [ItemController::class, 'recomendation']);
Route::get('/favorit', [ItemController::class, 'favItem'])->middleware('auth:sanctum');
Route::post('/items/{item}/favorite', [FavoriteController::class, 'toggle'])->middleware('auth:sanctum');
Route::get('/my-items', [ItemController::class, 'myItemsApi'])->middleware('auth:sanctum');
Route::delete('/my-items/{id}', [ItemController::class, 'destroyMyItem'])->middleware('auth:sanctum');
Route::put('/my-items/{id}', [ItemController::class, 'toggleStatus'])->middleware('auth:sanctum');


