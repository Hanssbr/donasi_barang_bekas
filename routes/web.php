<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubmissionController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
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
    Route::get('/my-items/{item}/submissions', [SubmissionController::class, 'incoming'])->name('submissions.incoming');
    Route::post('/submissions/{submission}/approve', [SubmissionController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{submission}/reject', [SubmissionController::class, 'reject'])->name('submissions.reject');

    // comment route
    Route::get('/items/{item}/comments', [CommentController::class, 'show'])->name('comments.show');
    Route::post('/items/{item}/comments', [CommentController::class, 'store'])->name('comments.store');

    // report route
    Route::get('items/{item}/reports', [ReportController::class, 'index'])->name('report.index');
    Route::post('items/{item}/reports', [ReportController::class, 'store'])->name('report.store');


    // favorite
    Route::post('/favorite/{item}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/my-favorites', [FavoriteController::class, 'index'])->name('favorites.index');



});

Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/reports', [ReportController::class, 'show'])->name('report.show');
    Route::delete('/admin/delete/{item}', [ItemController::class, 'adminDestroy'])->name('admin.destroy');
});

require __DIR__.'/auth.php';
