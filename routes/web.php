<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpvoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
        Route::resource('features', FeatureController::class);

        Route::post('/features/{feature}/upvote', [UpvoteController::class, 'upvote'])->name('features.upvote');
        Route::post('/features/{feature}/downvote', [UpvoteController::class, 'downvote'])->name('features.downvote');

        Route::post('/features/{feature}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::get('/features/{feature}/comments/{comment}', [CommentController::class, 'edit'])->name('comments.edit');
        Route::patch('/features/{feature}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });

});

require __DIR__ . '/auth.php';
