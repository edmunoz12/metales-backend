<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Principal\PrincipalController;
use App\Http\Controllers\Tools\ToolsController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Insertion\InsertionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Punto de entrada necesario para Sanctum + Angular. Angular lo llama antes del login.*/
Route::get('/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

// Rutas públicas (sin autenticación)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// Rutas protegidas (requieren sesión activa con Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Rutas de la aplicación
    Route::get('/menu', [PrincipalController::class, 'index'])->name('menu');
    Route::get('/submenu', [PrincipalController::class, 'submenu'])->name('submenu');

    Route::prefix('tools')->group(function () {
        Route::get('/count', [ToolsController::class, 'count'])->name('tool-count');
        Route::get('/', [ToolsController::class, 'index']);
        Route::get('/{id}', [ToolsController::class, 'show']);
        Route::post('/', [ToolsController::class, 'store']);
        Route::put('/{id}', [ToolsController::class, 'update']);
        Route::delete('/{id}', [ToolsController::class, 'destroy']);
    });

    Route::get('/toolTypes', [ToolsController::class, 'toolTypes'])->name('toolTypes');
    Route::get('/locations', [ToolsController::class, 'locations'])->name('locations');
    Route::get('/suppliers', [ToolsController::class, 'suppliers'])->name('suppliers');

    Route::get('/reports', [ReportsController::class, 'index'])->name('tools-wear-report');
    Route::get('/insertion', [InsertionController::class, 'index'])->name('insertion');
});


