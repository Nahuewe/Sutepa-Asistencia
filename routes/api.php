<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    OrdenDiariaController,
    UserController,
    RolesController,
    SeccionalController,
    RegistroController,
    VotacionController,
    VotoController
};

// Rutas públicas
Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken'])->middleware('auth:sanctum');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {

    // Votaciones
    Route::get('/votaciones/exportar', [VotacionController::class, 'exportarVotaciones']);
    Route::apiResource('/votaciones', VotacionController::class);
    Route::get('/votaciones/{id}/conteo', [VotacionController::class, 'obtenerConteo']);
    Route::get('/votaciones/{id}/respuestas', [VotoController::class, 'votosPorVotacion']);
    Route::get('/votaciones/{votacion}/no-votaron', [VotacionController::class, 'usuariosNoVotaron']);

    // Votos
    Route::get('/votos/exportar', [VotoController::class, 'exportarVotos']);
    Route::apiResource('/votos', VotoController::class);
    Route::post('/votos/verificar', [VotoController::class, 'verificarVoto']);

    // Escaneo de QR
    Route::post('/registrar-ingreso', [RegistroController::class, 'registrarIngreso']);
    Route::post('/registrar-egreso', [RegistroController::class, 'registrarEgreso']);

    // Ingreso y egreso
    Route::get('/ingreso', [RegistroController::class, 'getIngresos']);
    Route::get('/egreso', [RegistroController::class, 'getEgresos']);
    Route::get('/ingreso/exportar', [RegistroController::class, 'exportarIngresos']);
    Route::get('/egreso/exportar', [RegistroController::class, 'exportarEgresos']);
    Route::get('buscar-registro', [RegistroController::class, 'buscarRegistro']);

    // Usuarios
    Route::get('buscar-user', [UserController::class, 'buscarUser']);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/roles', RolesController::class);
    Route::apiResource('/seccionales', SeccionalController::class);
    Route::apiResource('/ordenes-diarias', OrdenDiariaController::class);

});
