<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminMovieController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GenreController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

// Admin Routes (không cần auth)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('movies', AdminMovieController::class)->names([
        'index' => 'admin.movies.index',
        'create' => 'admin.movies.create',
        'store' => 'admin.movies.store',
        'edit' => 'admin.movies.edit',
        'update' => 'admin.movies.update',
        'destroy' => 'admin.movies.destroy',
        'show' => 'admin.movies.show',
    ]);
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::resource('genres', GenreController::class)->names([
        'index' => 'admin.genres.index',
        'create' => 'admin.genres.create',
        'store' => 'admin.genres.store',
        'edit' => 'admin.genres.edit',
        'update' => 'admin.genres.update',
        'destroy' => 'admin.genres.destroy',
    ]);
});
