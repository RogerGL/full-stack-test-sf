<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('home');
});
//Rotas para o CRUD de produtos
Route::get('/produtos', [ProductController::class, 'create']);
Route::post('/produtos/create', [ProductController::class, 'store']);
Route::delete('/produtos/{id}', [ProductController::class, 'destroy']);
Route::put('/produtos/{id}', [ProductController::class, 'update']);
Route::get('/produtos/{id}/details', [ProductController::class, 'show']);


//Rotas para o CRUD de fornecedores
Route::get('/fornecedores', [SupplierController::class, 'create']);
Route::post('/fornecedores/create', [SupplierController::class, 'store']);
Route::delete('/fornecedores/{id}', [SupplierController::class, 'destroy']);
Route::put('/fornecedores/{id}', [SupplierController::class, 'update']);
Route::get('/fornecedores/{id}/details', [SupplierController::class, 'show']);
?>