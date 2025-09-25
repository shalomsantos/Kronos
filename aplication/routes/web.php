<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\TipoProjetoController;
use App\Http\Controllers\BzeroController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;


// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/teste', function(){
    return Inertia::render('Teste');
});

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('home');

    Route::resource('/projeto', ProjetoController::class);
    Route::resource('/bzero', BzeroController::class);
    Route::resource('/tipoprojeto', TipoProjetoController::class);

    Route::post('/preferencia', [BzeroController::class, 'modify'])->name('preferencia.modify');

    Route::get('/usuarios', function(){
        return Inertia::render('Usuarios', [
            'usuarios' => User::all()
        ]);
    })->name('usuarios.list');

    Route::get('/todos-usuarios', function(){
        return User::all();
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
