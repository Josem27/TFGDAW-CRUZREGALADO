<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RutinaController;
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

// Rutas para el perfil del usuario
Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');

// Rutas para las rutinas
Route::get('/rutinas', [RutinaController::class, 'showRutinas'])->name('rutinas.index');
Route::get('/rutinas/create', [RutinaController::class, 'create'])->name('rutina.create');
Route::post('/rutinas/store', [RutinaController::class, 'store'])->name('rutinas.store');
Route::get('/home', [RutinaController::class, 'index'])->name('home');
Route::get('/rutina/show', [RutinaController::class, 'show'])->name('rutina.show');

