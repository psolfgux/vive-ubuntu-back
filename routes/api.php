<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\TematicaController;
use App\Http\Controllers\CartaController;
use App\Http\Controllers\PlayerTematicaController;
use App\Http\Controllers\GameCardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([], function () {
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello World']);
    });
    
    Route::post('/players/login', [PlayerController::class, 'login']);
    Route::post('/players/google-login', [PlayerController::class, 'loginWithGoogle']);
    Route::post('/players/register', [PlayerController::class, 'register']);
    Route::get('/tematicas', [TematicaController::class, 'all']);  
    Route::get('/tematicas/{id}', [TematicaController::class, 'tematicaid']);
    Route::get('/game/{id}', [CartaController::class, 'showgame']);
    Route::apiResource('player-tematica', PlayerTematicaController::class);

    Route::get('game/{id_game}/cards', [GameCardController::class, 'index']);
    Route::post('game-card', [GameCardController::class, 'store']);
    Route::delete('game-card/{id}', [GameCardController::class, 'destroy']);
});




Route::group(['middleware' => ['auth:player']], function () {
    Route::get('players', [PlayerController::class, 'index']); // Listar jugadores
    Route::get('players/{id}', [PlayerController::class, 'show']); // Mostrar un jugador específico
    Route::put('players/{id}', [PlayerController::class, 'update']); // Actualizar un jugador
    Route::delete('players/{id}', [PlayerController::class, 'destroy']); // Eliminar un jugador
    Route::post('logout', [PlayerController::class, 'logout']); // Cerrar sesión
    Route::post('refresh', [PlayerController::class, 'refresh']); // Refrescar token

    
});
