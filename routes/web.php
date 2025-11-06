<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController; // 👈 AGREGAR
use App\Http\Controllers\AuthController; // 👈 te faltaba este
use Illuminate\Support\Facades\Auth;


// 👇 Página principal redirige al login
Route::get('/', fn() => redirect('/login'));


// Rutas de Socialite (Google y GitHub)
Route::get('/auth/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (protegido)
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirigir raíz a login
Route::get('/', fn() => redirect('/login'));

// 👇 Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 👇 Recursos (CRUD)
Route::middleware('auth')->group(function () {
    Route::resource('cliente', ClienteController::class);
    Route::resource('libro', LibroController::class);
    Route::resource('prestamo', PrestamoController::class);
    Route::resource('user', UserController::class);
});
