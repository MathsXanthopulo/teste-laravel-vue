<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rotas de autenticação
require __DIR__.'/auth.php';

// Rota principal - Dashboard
Route::get('/', function () {
    return Inertia::render('Dashboard/Page');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas protegidas por autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/Page');
    })->name('dashboard.index');
    
    // Colaboradores
    Route::get('/colaboradores', [App\Http\Controllers\ColaboradoresController::class, 'index'])->name('colaboradores.index');
    Route::post('/colaboradores', [App\Http\Controllers\ColaboradoresController::class, 'store'])->name('colaboradores.store');
    Route::put('/colaboradores/{id}', [App\Http\Controllers\ColaboradoresController::class, 'update'])->name('colaboradores.update');
    Route::delete('/colaboradores/{id}', [App\Http\Controllers\ColaboradoresController::class, 'destroy'])->name('colaboradores.destroy');
    
    // Outras rotas podem ser adicionadas aqui conforme necessário
    // Route::get('/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes.index');
    // Route::get('/produtos', [App\Http\Controllers\ProdutosController::class, 'index'])->name('produtos.index');
    // Route::get('/configuracoes', [App\Http\Controllers\ConfiguracoesController::class, 'index'])->name('configuracoes.index');
});
