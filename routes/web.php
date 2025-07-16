<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\CalificacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página de inicio - redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registrar_usuario', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registrar_usuario', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    
    // Dashboard - redirige según tipo de usuario
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas para estudiantes
    Route::prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones');
        Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('reservas');
    });
    
    // Rutas para propietarios
    Route::prefix('propietario')->name('propietario.')->group(function () {
        Route::get('/habitaciones', [PropietarioController::class, 'habitaciones'])->name('habitaciones');
        Route::get('/publicar', [PropietarioController::class, 'showPublicar'])->name('publicar');
        Route::post('/publicar', [PropietarioController::class, 'publicar'])->name('publicar.store');
    });
    
    // Habitaciones
    Route::resource('habitaciones', HabitacionController::class)->only(['index', 'show']);
    
    // Reservas
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reservas.store');
    
    // Calificaciones
    Route::get('/calificar', [CalificacionController::class, 'create'])->name('calificaciones.create');
    Route::post('/calificar', [CalificacionController::class, 'store'])->name('calificaciones.store');
    Route::get('/ver-calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index');
});
