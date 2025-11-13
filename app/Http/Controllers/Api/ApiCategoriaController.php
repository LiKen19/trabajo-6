<?php

namespace App\Http\Controllers\Api;

// 👇 Este es el archivo: app/Http/Controllers/Api/ApiCategoriaController.php

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiCategoriaController extends Controller
{
    /**
     * Listar todas las categorías
     * GET /api/categorias
     */
    public function index(): JsonResponse
    {
        try {
            $categorias = Categoria::with('libros')->paginate(10);
            
            return response()->json([
                'success' => true,
                'data' => $categorias
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las categorías',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva categoría
     * POST /api/categorias
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255|unique:categorias,nombre',
                'descripcion' => 'nullable|string|max:500'
            ]);

            $categoria = Categoria::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Categoría creada exitosamente',
                'data' => $categoria
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
                'message' => 'Error al crear la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una categoría específica
     * GET /api/categorias/{id}
     */
    public function show(int $id): JsonResponse
    {
        try {
            $categoria = Categoria::with('libros')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $categoria
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar una categoría
     * PUT/PATCH /api/categorias/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $categoria = Categoria::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $id,
                'descripcion' => 'nullable|string|max:500'
            ]);

            $categoria->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Categoría actualizada exitosamente',
                'data' => $categoria
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
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
                'message' => 'Error al actualizar la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una categoría
     * DELETE /api/categorias/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $categoria = Categoria::findOrFail($id);
            
            // Verificar si tiene libros asociados
            if ($categoria->libros()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la categoría porque tiene libros asociados'
                ], 409);
            }

            $categoria->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener libros de una categoría
     * GET /api/categorias/{id}/libros
     */
    public function libros(int $id): JsonResponse
    {
        try {
            $categoria = Categoria::with('libros')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'categoria' => $categoria->nombre,
                    'libros' => $categoria->libros
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los libros',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}