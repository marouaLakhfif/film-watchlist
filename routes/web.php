<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Movie routes
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::post('/movies/{movie}/toggle', [MovieController::class, 'toggle'])->name('movies.toggle');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy'); 
    Route::get('/movies/search', [App\Http\Controllers\MovieSearchController::class, 'index'])->name('movies.search');
    Route::get('/movies/search-api', [App\Http\Controllers\MovieSearchController::class, 'search'])->name('movies.search.submit'); 
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
});