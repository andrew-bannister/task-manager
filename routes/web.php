<?php

use App\Http\Controllers\EpicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', [TaskController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'tasks', 'middleware' => ['auth', 'verified']], function () {
    Route::prefix('new')->group(function () {
        Route::get('/', [TaskController::class, 'create'])->name('task.new');
        Route::post('/', [TaskController::class, 'store'])->name('task.store');
    });
    Route::prefix('{id}')->group(function () {
        Route::get('/', [TaskController::class, 'show'])->name('task');
        Route::get('/edit', [TaskController::class, 'edit'])->name('task.edit');
        Route::get('/delete', [TaskController::class, 'destroy']);
        Route::put('/', [TaskController::class, 'update']);
    });
});

Route::group(['prefix' => 'epics', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [EpicController::class, 'index'])->name('epics');
    Route::prefix('new')->group(function () {
        Route::get('/', [EpicController::class, 'create'])->name('epic.new');
        Route::post('/', [EpicController::class, 'store'])->name('epic.store');
    });
});

Route::group(['prefix' => 'statuses', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [StatusController::class, 'index'])->name('statuses');
    Route::prefix('status')->group(function () {
        Route::post('/store', [StatusController::class, 'store'])->name('status.new');
        Route::prefix('{id}')->group(function () {
            Route::put('/update', [StatusController::class, 'update'])->name('status.update');
            Route::get('/delete', [StatusController::class, 'destroy']);
        });
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
