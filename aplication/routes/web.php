<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BzeroController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TipoProjetoController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PlataformaItemSubitemFornecedorController;
use App\Http\Controllers\SubitemController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/', [BzeroController::class, 'index'])->name('home');
    // Bzero
    Route::resource('bzero', BzeroController::class);
    Route::post('/bzerofiltro', [BzeroController::class, 'filtro'])->name('bzero.filtro');
    Route::post('/associar/plataforma/{id}', [BzeroController::class, 'associarPLataforma'])->name('associar.plataforma');
    Route::post('/preferencia', [BzeroController::class, 'modify'])->name('preferencia.modify');
    // Projetos
    Route::resource('projeto', ProjetoController::class);
    // Tipo Projeto
    Route::resource('tipoprojeto', TipoProjetoController::class);
    // Plataforma
    Route::resource('plataforma', PlataformaController::class);
    Route::get('/plataforma/associaveis/{id}', [PlataformaItemSubitemFornecedorController::class, 'show'])->name('plataforma.plataformasAssociaveis');
    // plataforma item subitem fornecedor
    Route::resource('plataformaitemsubitemfornecedor', PlataformaItemSubitemFornecedorController::class);
    // Item
    Route::resource('item', ItemController::class);
    Route::get('/item/associaveis/{id}', [ItemController::class, 'itemAssociaveis'])->name('item.itemAssociaveis');
    // Subitens
    Route::resource('subitem', SubitemController::class);
    Route::get('/subitens/associaveis/{id}', [SubitemController::class, 'subitensAssociaveis'])->name('subitem.subitensAssociaveis');
    // Fornecedor
    Route::resource('fornecedor', FornecedorController::class);
    // Status
    Route::resource('status', StatusController::class);
    // User
    Route::resource('usuarios', UserController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
