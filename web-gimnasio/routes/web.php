<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\DietaController;
use App\Http\Controllers\PagosController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



// Ruta de inicio
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/rutinas', [RutinaController::class, 'index'])->name('rutinas.index');
Route::get('/dietas', [DietaController::class, 'index'])->name('dietas.index');
Route::get('/pagos', [PagosController::class, 'index'])->name('pagos.index');
Route::get('/gestion-usuarios', [GestionController::class, 'index'])->name('gestion.usuarios.index');


// Rutas para el perfil del usuario
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');

// Rutas para las rutinas
Route::get('/rutinas/create', [RutinaController::class, 'create'])->name('rutina.create');
Route::post('/rutinas/store', [RutinaController::class, 'store'])->name('rutinas.store');
Route::get('/rutinas/{id}/edit', [RutinaController::class, 'edit'])->name('rutina.edit');
Route::delete('/rutinas/{id}', [RutinaController::class, 'destroy'])->name('rutina.destroy');
Route::put('/rutinas/{id}', [RutinaController::class, 'update'])->name('rutina.update');

// Rutas para las dietas
Route::get('/dietas/create', [DietaController::class, 'create'])->name('dietas.create');
Route::get('/dietas/edit/{id}', [DietaController::class, 'edit'])->name('dietas.edit');
Route::delete('/dietas/{id}', [DietaController::class, 'destroy'])->name(name: 'dietas.destroy');
Route::post('/dietas/store', [DietaController::class, 'store'])->name('dietas.store');
Route::put('/dietas/update/{id}', [DietaController::class, 'update'])->name('dietas.update');


// Rutas para las pagos
Route::get('/pagos', [PagosController::class, 'index'])->name('pagos.index');


// Rutas para la gestion
