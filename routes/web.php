<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\TematicaController;
use App\Http\Controllers\CartaController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\NotaController;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    // Main Page Route
    Route::get('/', [HomePage::class, 'index'])->name('pages-home');
    Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

    // locale
    Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

    Route::resource('tematicas', TematicaController::class);
    
    // Rutas para import/export
    Route::post('tematicas/{tematica}/cartas/import', [CartaController::class, 'import'])->name('cartas.import');
    Route::get('tematicas/{tematica}/cartas/export', [CartaController::class, 'export'])->name('cartas.export');
    
    Route::get('tematicas/{tematica}/cartas', [CartaController::class, 'index'])->name('tematicas.cartas.index');
    Route::get('tematicas/{tematica}/cartas/create', [CartaController::class, 'create'])->name('tematicas.cartas.create');
    Route::post('tematicas/{tematica}/cartas', [CartaController::class, 'store'])->name('tematicas.cartas.store');
    Route::get('tematicas/{tematica}/cartas/{carta}', [CartaController::class, 'show'])->name('tematicas.cartas.show');
    Route::get('tematicas/{tematica}/cartas/{carta}/edit', [CartaController::class, 'edit'])->name('tematicas.cartas.edit');
    Route::put('tematicas/{tematica}/cartas/{carta}', [CartaController::class, 'update'])->name('tematicas.cartas.update');
    Route::delete('tematicas/{tematica}/cartas/{carta}', [CartaController::class, 'destroy'])->name('tematicas.cartas.destroy');

    Route::resource('players', PlayerController::class);

    Route::get('/notas/export', [NotaController::class, 'export'])->name('notas.export');
    Route::get('/notas', [NotaController::class, 'index'])->name('notas.index');

    

});

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
//Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');