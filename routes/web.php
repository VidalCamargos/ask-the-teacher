<?php

use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    Question\LikeController,
    Question\QuestionController,
    Question\UnlikeController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('questions')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('questions.index');
        Route::post('/store', [QuestionController::class, 'store'])->name('questions.store');

        Route::prefix('{question}')->group(function () {
            Route::put('/update', [QuestionController::class, 'update'])->name('questions.update');
            Route::post('/like', LikeController::class)->name('questions.like');
            Route::post('/unlike', UnlikeController::class)->name('questions.unlike');
        });
    });
});

require __DIR__ . '/auth.php';
