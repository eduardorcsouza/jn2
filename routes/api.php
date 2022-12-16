<?php

use App\Http\Controllers\Api\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/cliente',[ClienteController::class, 'salvarCliente'])->name('cliente.criar');
Route::put('/cliente/{id}',[ClienteController::class, 'salvarCliente'])->name('cliente.atualizar');
Route::delete('/cliente/{id}',[ClienteController::class, 'delete'])->name('cliente.deletar');
Route::get('/cliente/{id}',[ClienteController::class, 'getCliente'])->name('cliente.dados');
Route::get('/consulta/final-placa/{numero}',[ClienteController::class, 'listaClientesPeloFinalDaPlaca'])->name('cliente.lista-pela-placa');
