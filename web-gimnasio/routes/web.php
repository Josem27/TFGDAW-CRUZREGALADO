<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\DietaController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\GestionController;
use Illuminate\Support\Facades\Auth;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Ruta de inicio
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas protegidas para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    // Rutas para el perfil del usuario
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
});

// Rutas protegidas para administradores o entrenadores
Route::middleware(['auth', 'role:Administrador,Entrenador'])->group(function () {
    // Rutas de gestión solo accesibles por administradores o entrenadores
    Route::get('/gestion-usuarios', [GestionController::class, 'index'])->name('gestion.usuarios.index');
    Route::get('/gestion', [GestionController::class, 'index'])->name('gestion.index');
    Route::delete('gestion-usuarios/{id_usuario}', [GestionController::class, 'destroy'])->name('gestion.usuarios.destroy');
    Route::put('/gestion-usuarios/{id_usuario}/update', [GestionController::class, 'update'])->name('gestion.usuarios.update');
});

// Rutas protegidas para rutinas, dietas y pagos con middleware que verifica que sea dueño o administrador/entrenador
Route::middleware(['auth', 'ownerOrRole'])->group(function () {
    // Rutas para las rutinas
    Route::get('/rutinas/create/{id_usuario}', [RutinaController::class, 'create'])->name('rutinas.create');
    Route::post('/rutinas/store', [RutinaController::class, 'store'])->name('rutinas.store');
    Route::get('/rutinas/{id}/edit', [RutinaController::class, 'edit'])->name('rutina.edit');
    Route::delete('/rutinas/{id}', [RutinaController::class, 'destroy'])->name('rutina.destroy');
    Route::put('/rutinas/{id}', [RutinaController::class, 'update'])->name('rutina.update');
    Route::get('/rutinas/{id_usuario}', [RutinaController::class, 'index'])->name('rutinas.index');

    // Rutas para las dietas
    Route::get('/dietas/create/{id_usuario}', [DietaController::class, 'create'])->name('dietas.create');
    Route::get('/dietas/edit/{id}', [DietaController::class, 'edit'])->name('dietas.edit');
    Route::delete('/dietas/{id}', [DietaController::class, 'destroy'])->name('dietas.destroy');
    Route::post('/dietas/store', [DietaController::class, 'store'])->name('dietas.store');
    Route::put('/dietas/update/{id}', [DietaController::class, 'update'])->name('dietas.update');
    Route::get('/dietas/{id_usuario}', [DietaController::class, 'index'])->name('dietas.index');

    // Rutas para los pagos
    Route::post('/pagos/{id_usuario}/store', [PagosController::class, 'store'])->name('pagos.store');
    Route::get('/pagos/{id_usuario}', [PagosController::class, 'index'])->name('pagos.index');
});
