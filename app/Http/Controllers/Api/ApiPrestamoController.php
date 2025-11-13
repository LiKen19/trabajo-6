<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiPrestamoController extends Controller
{
    /**
     * Listar todos los préstamos
     * GET /api/prestamos
     */
    public function index()
{
    $prestamos = \App\Models\Prestamo::all();

    return response()->json([
        'success' => true,
        'total' => $prestamos->count(),
        'data' => $prestamos
    ]);
}
    /**
     * Crear un nuevo préstamo
     * POST /api/prestamos
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'cliente_id' => 'required|integer|exists:clientes,id',
                'libro_id' => 'required|integer|exists:libros,id',
                'fecha_prestamo' => 'required|date',
                'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
                'estado' => 'required|in:Prestado,Devuelto',
            ]);

            // Verificar que el libro esté disponible
            $libro = Libro::findOrFail($validated['libro_id']);
            if ($libro->estado === 'Prestado' && $validated['estado'] === 'Prestado') {
                return response()->json([
                    'success' => false,
                    'message' => 'El libro ya está prestado actualmente'
                ], 409);
            }

            $prestamo = Prestamo::create($validated);

            // Actualizar estado del libro
            $this->actualizarEstadoLibro($libro, $validated['estado']);

            $prestamo->load(['cliente', 'libro']);

            return response()->json([
                'success' => true,
                'message' => 'Préstamo registrado exitosamente',
                'data' => $prestamo
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un préstamo específico
     * GET /api/prestamos/{id}
     */
    public function show(int $id): JsonResponse
    {
        try {
            $prestamo = Prestamo::with(['cliente', 'libro.categoria'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $prestamo
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Préstamo no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un préstamo
     * PUT/PATCH /api/prestamos/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $prestamo = Prestamo::findOrFail($id);

            $validated = $request->validate([
                'cliente_id' => 'required|integer|exists:clientes,id',
                'libro_id' => 'required|integer|exists:libros,id',
                'fecha_prestamo' => 'required|date',
                'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
                'estado' => 'required|in:Prestado,Devuelto',
            ]);

            $prestamo->update($validated);

            // Actualizar estado del libro
            $libro = Libro::findOrFail($validated['libro_id']);
            $this->actualizarEstadoLibro($libro, $validated['estado']);

            $prestamo->load(['cliente', 'libro']);

            return response()->json([
                'success' => true,
                'message' => 'Préstamo actualizado exitosamente',
                'data' => $prestamo
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Préstamo no encontrado'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un préstamo
     * DELETE /api/prestamos/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $prestamo = Prestamo::findOrFail($id);
            
            // Liberar el libro
            $libro = Libro::findOrFail($prestamo->libro_id);
            $this->actualizarEstadoLibro($libro, 'Disponible');

            $prestamo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Préstamo eliminado y libro disponible'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Préstamo no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Devolver un libro (actualizar estado a Devuelto)
     * POST /api/prestamos/{id}/devolver
     */
    public function devolver(int $id): JsonResponse
    {
        try {
            $prestamo = Prestamo::findOrFail($id);

            if ($prestamo->estado === 'Devuelto') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este préstamo ya fue devuelto'
                ], 400);
            }

            $prestamo->update([
                'estado' => 'Devuelto',
                'fecha_devolucion' => now()
            ]);

            // Actualizar estado del libro
            $libro = Libro::findOrFail($prestamo->libro_id);
            $this->actualizarEstadoLibro($libro, 'Disponible');

            $prestamo->load(['cliente', 'libro']);

            return response()->json([
                'success' => true,
                'message' => 'Libro devuelto exitosamente',
                'data' => $prestamo
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Préstamo no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al devolver el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener préstamos activos
     * GET /api/prestamos/activos
     */
    public function activos(): JsonResponse
    {
        try {
            $prestamos = Prestamo::with(['cliente', 'libro.categoria'])
                ->where('estado', 'Prestado')
                ->orderBy('fecha_prestamo', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $prestamos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener préstamos activos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método privado para actualizar el estado del libro
     */
    private function actualizarEstadoLibro(Libro $libro, string $estado): void
    {
        $libro->estado = ($estado === 'Prestado') ? 'Prestado' : 'Disponible';
        $libro->save();
    }
}