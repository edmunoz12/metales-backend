<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Principal\PrincipalController;
use App\Http\Controllers\Tools\ToolsController;
use App\Http\Controllers\Reports\ReportsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('api')->group(function(){

    Route::get('/menu',[PrincipalController::class,'index'])->name('menu');
    Route::get('/submenu',[PrincipalController::class,'submenu'])->name('submenu');
    //Route::get('/inicio',[PrincipalController::class,'sidebar'])->name('inicio');


    //Route::get('/index', [ToolsController::class, 'index'])->name('tool');
    //Route::post('newTool', [ToolsController::class, 'newTool'])->name('new-Tool');
    Route::get('/tooTypes', [ToolsController::class, 'toolTypes'])->name('toolTypes');
    Route::get('/locations', [ToolsController::class, 'locations'])->name('locations');
    Route::get('/suppliers', [ToolsController::class, 'suppliers'])->name('suppliers');

    Route::prefix('tools')->group(function () {
        Route::get('/', [ToolsController::class, 'index']);     // Listar
        Route::get('/{id}', [ToolsController::class, 'show']);  // Mostrar una
        Route::post('/', [ToolsController::class, 'store']);    // Crear
        Route::put('/{id}', [ToolsController::class, 'update']); // Actualizar
        Route::delete('/{id}', [ToolsController::class, 'destroy']); // Eliminar
    });

    //Catalagos
    Route::get('/reports',[ReportsController::class,'index'])->name('tools-wear-report');


    //Route::apiResource('Unidad',UnidadController::class);
   //


});
