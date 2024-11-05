<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/task-search', [ApiController::class, 'taskSearch'])->name('api.task.search');
});
