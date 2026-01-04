<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\UserGameController;

// Breeze verwacht vaak dashboard; maak hem simpel
Route::get('/dashboard', function () {
    return redirect()->route('games.index');
})->middleware(['auth'])->name('dashboard');

// Publiek: lijst + detail
Route::get('/', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

// Auth-only
Route::middleware('auth')->group(function () {
    Route::post('/favourites/{game}', [FavouriteController::class, 'store'])->name('favourites.store');
    Route::delete('/favourites/{game}', [FavouriteController::class, 'destroy'])->name('favourites.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/my/games', [UserGameController::class, 'index'])->name('my.games.index');

    Route::get('/my/games/create', [UserGameController::class, 'create'])->name('my.games.create');
    Route::post('/my/games', [UserGameController::class, 'store'])->name('my.games.store');

    Route::get('/my/games/{game}/edit', [UserGameController::class, 'edit'])->name('my.games.edit');
    Route::put('/my/games/{game}', [UserGameController::class, 'update'])->name('my.games.update');

    Route::post('/my/games/{game}/toggle-active', [UserGameController::class, 'toggleActive'])->name('my.games.toggle');
});

// Admin CRUD
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('games', AdminGameController::class)->except(['show']);
    Route::post('games/{game}/toggle-active', [AdminGameController::class, 'toggleActive'])
        ->name('games.toggle');
});

// BELANGRIJK: Breeze auth routes laden (login/register/logout)
require __DIR__.'/auth.php';
