<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SesiKasirController;
use App\Http\Controllers\Api\MapUsersToRoleController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::apiResource('roles', RoleController::class);
        Route::apiResource('mapuserstorole', MapUsersToRoleController::class);
    });
});

Route::middleware('auth:sanctum')->prefix('pos')->group(function () {
    Route::get('/sessions/current', [SesiKasirController::class, 'current']);
    Route::post('/sessions/open', [SesiKasirController::class, 'open']);
    Route::post('/sessions/close', [SesiKasirController::class, 'close']);
    Route::get('/sessions/history', [SesiKasirController::class, 'history']);
});