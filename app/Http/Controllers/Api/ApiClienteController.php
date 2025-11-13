<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ApiClienteController extends Controller
{
    /**
     * Listar todos los clientes
     * GET /api/clientes
     */
    public function index(): JsonResponse
    {
        try {
            $clientes = Cliente::orderBy('nombre')->paginate(15);            
            return response()->json([
                'success' => true,
                'data' => $clientes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los clientes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo cliente
     * POST /api/clientes
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'dni' => 'required|string|max:20|unique:clientes,dni',
                'telefono' => 'required|string|max:20',
                'direccion' => 'required|string|max:255',
                'correo' => 'required|email|max:255|unique:clientes,correo',
            ]);

            $cliente = Cliente::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cliente creado exitosamente',
                'data' => $cliente
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
                'message' => 'Error al crear el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un cliente específico
     * GET /api/clientes/{id}
     */
    public function show(int $id): JsonResponse
    {
        try {
            $cliente = Cliente::with('prestamos.libro')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $cliente
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un cliente
     * PUT/PATCH /api/clientes/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $cliente = Cliente::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'dni' => ['required', 'string', 'max:20', Rule::unique('clientes')->ignore($id)],
                'telefono' => 'required|string|max:20',
                'direccion' => 'required|string|max:255',
                'correo' => ['required', 'email', 'max:255', Rule::unique('clientes')->ignore($id)],
            ]);

            $cliente->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cliente actualizado exitosamente',
                'data' => $cliente
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
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
                'message' => 'Error al actualizar el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un cliente
     * DELETE /api/clientes/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $cliente = Cliente::findOrFail($id);
            
            // Verificar si tiene préstamos activos
            if ($cliente->prestamos()->where('estado', 'Prestado')->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el cliente porque tiene préstamos activos'
                ], 409);
            }

            $cliente->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cliente eliminado exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener préstamos de un cliente
     * GET /api/clientes/{id}/prestamos
     */
    public function prestamos(int $id): JsonResponse
    {
        try {
            $cliente = Cliente::with('prestamos.libro')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'cliente' => $cliente->nombre . ' ' . $cliente->apellido,
                    'prestamos' => $cliente->prestamos
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los préstamos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}