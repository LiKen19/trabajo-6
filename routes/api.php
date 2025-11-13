<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiCategoriaController;
use App\Http\Controllers\Api\ApiClienteController;
use App\Http\Controllers\Api\ApiLibroController;
use App\Http\Controllers\Api\ApiPrestamoController;
use App\Http\Controllers\Api\ApiUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí están todas las rutas de tu API REST para el sistema de biblioteca
|
*/

// ============================================
// RUTAS DE CATEGORÍAS
// ============================================
Route::prefix('categorias')->group(function () {
    Route::get('/', [ApiCategoriaController::class, 'index']);           // Listar todas
    Route::post('/', [ApiCategoriaController::class, 'store']);          // Crear
    Route::get('/{id}', [ApiCategoriaController::class, 'show']);        // Ver una
    Route::put('/{id}', [ApiCategoriaController::class, 'update']);      // Actualizar
    Route::patch('/{id}', [ApiCategoriaController::class, 'update']);    // Actualizar
    Route::delete('/{id}', [ApiCategoriaController::class, 'destroy']);  // Eliminar
    Route::get('/{id}/libros', [ApiCategoriaController::class, 'libros']); // Libros de la categoría
});

// ============================================
// RUTAS DE CLIENTES
// ============================================
Route::prefix('clientes')->group(function () {
    Route::get('/', [ApiClienteController::class, 'index']);              // Listar todos
    Route::post('/', [ApiClienteController::class, 'store']);             // Crear
    Route::get('/{id}', [ApiClienteController::class, 'show']);           // Ver uno
    Route::put('/{id}', [ApiClienteController::class, 'update']);         // Actualizar
    Route::patch('/{id}', [ApiClienteController::class, 'update']);       // Actualizar
    Route::delete('/{id}', [ApiClienteController::class, 'destroy']);     // Eliminar
    Route::get('/{id}/prestamos', [ApiClienteController::class, 'prestamos']); // Préstamos del cliente
});

// ============================================
// RUTAS DE LIBROS
// ============================================
Route::prefix('libros')->group(function () {
    Route::get('/disponibles', [ApiLibroController::class, 'disponibles']); // Libros disponibles (debe ir ANTES de /{id})
    Route::get('/', [ApiLibroController::class, 'index']);                  // Listar todos (con filtros)
    Route::post('/', [ApiLibroController::class, 'store']);                 // Crear
    Route::get('/{id}', [ApiLibroController::class, 'show']);               // Ver uno
    Route::put('/{id}', [ApiLibroController::class, 'update']);             // Actualizar
    Route::patch('/{id}', [ApiLibroController::class, 'update']);           // Actualizar
    Route::delete('/{id}', [ApiLibroController::class, 'destroy']);         // Eliminar
});

// ============================================
// RUTAS DE PRÉSTAMOS
// ============================================
Route::prefix('prestamos')->group(function () {
    Route::get('/activos', [ApiPrestamoController::class, 'activos']);     // Préstamos activos (debe ir ANTES de /{id})
    Route::get('/', [ApiPrestamoController::class, 'index']);              // Listar todos (con filtros)
    Route::post('/', [ApiPrestamoController::class, 'store']);             // Crear
    Route::get('/{id}', [ApiPrestamoController::class, 'show']);           // Ver uno
    Route::put('/{id}', [ApiPrestamoController::class, 'update']);         // Actualizar
    Route::patch('/{id}', [ApiPrestamoController::class, 'update']);       // Actualizar
    Route::delete('/{id}', [ApiPrestamoController::class, 'destroy']);     // Eliminar
    Route::post('/{id}/devolver', [ApiPrestamoController::class, 'devolver']); // Marcar como devuelto
});

// ============================================
// RUTAS DE USUARIOS
// ============================================
Route::prefix('users')->group(function () {
    Route::get('/', [ApiUserController::class, 'index']);                  // Listar todos
    Route::post('/', [ApiUserController::class, 'store']);                 // Crear
    Route::get('/{id}', [ApiUserController::class, 'show']);               // Ver uno
    Route::put('/{id}', [ApiUserController::class, 'update']);             // Actualizar
    Route::patch('/{id}', [ApiUserController::class, 'update']);           // Actualizar
    Route::delete('/{id}', [ApiUserController::class, 'destroy']);         // Eliminar
    Route::post('/{id}/change-password', [ApiUserController::class, 'changePassword']); // Cambiar contraseña
});

// ============================================
// RUTA DE PRUEBA
// ============================================
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API funcionando correctamente',
        'timestamp' => now(),
        'endpoints' => [
            'categorias' => '/api/categorias',
            'clientes' => '/api/clientes',
            'libros' => '/api/libros',
            'prestamos' => '/api/prestamos',
            'users' => '/api/users'
        ]
    ]);
});