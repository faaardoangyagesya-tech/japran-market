<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\GameController as AdminGameController;

// Public API
Route::get('/games', [GameController::class, 'index']);
Route::get('/games/{slug}', [GameController::class, 'show']);
Route::get('/games/{gameSlug}/accounts', [AccountController::class, 'index']);
Route::get('/accounts/{id}', [AccountController::class, 'show']);
Route::post('/visitor', [VisitorController::class, 'store']);
Route::get('/stats', [StatsController::class, 'index']);

// Admin API (separate subdomain or prefix)
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::apiResource('accounts', AdminAccountController::class);
        Route::apiResource('games', AdminGameController::class)->except(['show']);
    });
});
