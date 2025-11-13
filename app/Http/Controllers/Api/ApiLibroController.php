<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiLibroController extends Controller
{
    /**
     * Listar todos los libros
     * GET /api/libros
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Libro::query();

            // Filtro por categoría
            if ($request->has('categoria_id')) {
                $query->where('categoria_id', $request->categoria_id);
            }

            // Filtro por estado
            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            // Búsqueda por título o autor
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                      ->orWhere('autor', 'like', "%{$search}%");
                });
            }

            $libros = $query->paginate(15);
            
            return response()->json([
                'success' => true,
                'data' => $libros
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los libros',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo libro
     * POST /api/libros
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:150',
                'categoria_id' => 'required|integer|exists:categorias,id',
                'idioma' => 'required|string|max:50',
                'autor' => 'required|string|max:100',
                'editorial' => 'required|string|max:100',
                'estado' => 'nullable|in:Disponible,Prestado'
            ]);

            // Si no se envía estado, por defecto es Disponible
            $validated['estado'] = $validated['estado'] ?? 'Disponible';

            $libro = Libro::create($validated);
            $libro->load('categoria');

            return response()->json([
                'success' => true,
                'message' => 'Libro creado exitosamente',
                'data' => $libro
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
                'message' => 'Error al crear el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un libro específico
     * GET /api/libros/{id}
     */
    public function show(int $id): JsonResponse
    {
        try {
            $libro = Libro::with(['categoria', 'prestamos.cliente'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $libro
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un libro
     * PUT/PATCH /api/libros/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $libro = Libro::findOrFail($id);

            $validated = $request->validate([
                'titulo' => 'required|string|max:150',
                'categoria_id' => 'required|integer|exists:categorias,id',
                'idioma' => 'required|string|max:50',
                'autor' => 'required|string|max:100',
                'editorial' => 'required|string|max:100',
                'estado' => 'nullable|in:Disponible,Prestado'
            ]);

            $libro->update($validated);
            $libro->load('categoria');

            return response()->json([
                'success' => true,
                'message' => 'Libro actualizado exitosamente',
                'data' => $libro
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
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
                'message' => 'Error al actualizar el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un libro
     * DELETE /api/libros/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $libro = Libro::findOrFail($id);
            
            // Verificar si tiene préstamos activos
            if ($libro->prestamos()->where('estado', 'Prestado')->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el libro porque está prestado actualmente'
                ], 409);
            }

            $libro->delete();

            return response()->json([
                'success' => true,
                'message' => 'Libro eliminado exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener libros disponibles
     * GET /api/libros/disponibles
     */
    public function disponibles(): JsonResponse
    {
        try {
            $libros = Libro::with('categoria')
                ->where('estado', 'Disponible')
                ->orderBy('titulo')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $libros
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener libros disponibles',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}