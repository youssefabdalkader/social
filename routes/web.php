<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/logout', function () {
        auth()->logout();
        return route('login');
    })->name('logout');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {

        Route::get('/', [PostController::class, 'index'])->name('posts.index');

        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

        Route::post('/posts/{id}/like', [LikeController::class, 'toggle'])->name('posts.like');

        Route::post('/posts/{id}/comment', [CommentController::class, 'store'])->name('comments.store');
        Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
        Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');



        Route::get('/profile', function () {
            return view('posts.profile');
        })->middleware('auth')->name('profile');

        Route::get('/profile/edit', function () {
            return view('posts.edit-profile');
        })->name('profile.edit')->middleware('auth');

        Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
    });
