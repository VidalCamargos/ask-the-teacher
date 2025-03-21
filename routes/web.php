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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('questions')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('questions.index');
        Route::post('/', [QuestionController::class, 'store'])->name('questions.store');

        Route::prefix('{question}')->group(function () {
            Route::get('/', [QuestionController::class, 'edit'])->name('questions.edit');
            Route::put('/', [QuestionController::class, 'update'])->name('questions.update');
            Route::delete('/', [QuestionController::class, 'destroy'])->name('questions.destroy');
            Route::post('/like', LikeController::class)->name('questions.like');
            Route::post('/unlike', UnlikeController::class)->name('questions.unlike');
        });
    });
});

require __DIR__ . '/auth.php';
