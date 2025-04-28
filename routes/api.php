<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, UserController, RolesController, SeccionalController
};

// Rutas públicas
Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken'])->middleware('auth:sanctum');

// Rutas protegidas por middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('buscar-user', [UserController::class, 'buscarUser']);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/roles',RolesController::class);
    Route::apiResource('/seccionales',SeccionalController::class);
});
