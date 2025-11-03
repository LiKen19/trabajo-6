<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\DashboardController;




Route::get('/', function () {
    return redirect()->route('dashboard');
});




Route::resource('cliente', ClienteController::class);


Route::resource('libro', LibroController::class);

Route::resource('prestamo', PrestamoController::class);


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


