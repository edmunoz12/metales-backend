<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Principal\PrincipalController;
use App\Http\Controllers\Tools\ToolsController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Insertion\InsertionController;
use App\Http\Controllers\Assembly\AssemblyController;
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

    Route::prefix('insertion')->group(function () {
        Route::get('/', [InsertionController::class, 'index']);
        Route::get('/{id}', [InsertionController::class, 'show']);
        Route::post('/', [InsertionController::class, 'create']);
        Route::put('/{id}', [InsertionController::class, 'update']);
        Route::delete('/{id}', [InsertionController::class, 'destroy']);
    });

    Route::prefix('assemblies')->group(function () {
        Route::get('/', [AssemblyController::class, 'index']);
        Route::get('/{id}', [AssemblyController::class, 'show']);
        Route::post('/', [AssemblyController::class, 'create']);
        Route::put('/{id}', [AssemblyController::class, 'update']);
        Route::delete('/{id}', [AssemblyController::class, 'destroy']);
    });

});


