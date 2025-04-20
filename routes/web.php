<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // profile route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // items route
    Route::resource('items', ItemController::class);
    Route::get('/myitems',[ItemController::class, 'myItems'])->name('my.items');

    // submission route
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/items/{item}/submit', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/items/{item}/submit', [SubmissionController::class, 'store'])->name('submissions.store');

});

require __DIR__.'/auth.php';
