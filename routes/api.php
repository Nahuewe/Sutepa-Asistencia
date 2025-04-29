<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, UserController, RolesController, SeccionalController, RegistroController
};

// Rutas públicas
Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken'])->middleware('auth:sanctum');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {

    // Ingreso y egreso
    Route::get('/ingreso', [RegistroController::class, 'getIngresos']);
    Route::get('/egreso', [RegistroController::class, 'getEgresos']);
    Route::get('buscar-registro', [RegistroController::class, 'buscarRegistro']);

    // Escaneo de QR
    Route::post('/registrar-ingreso', [RegistroController::class, 'registrarIngreso']);
    Route::post('/registrar-egreso', [RegistroController::class, 'registrarEgreso']);

    // Usuarios
    Route::get('buscar-user', [UserController::class, 'buscarUser']);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/roles', RolesController::class);
    Route::apiResource('/seccionales', SeccionalController::class);
});