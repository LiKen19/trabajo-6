<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // 1. IMPORTAMOS LA REGLA 'RULE' PARA VALIDACIONES AVANZADAS

class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     * (Si usas modal, esta función puede omitirse)
     */
    public function create()
    {
        return view('clientes.create'); // opcional si usas modal
    }

    /**
     * Guarda un nuevo cliente.
     */
    public function store(Request $request)
    {
        // 2. VALIDACIÓN CORREGIDA (STORE)
        // Agregamos las reglas 'unique' para que Laravel las revise
        // ANTES de que la base de datos falle.
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'required|string|max:20|unique:clientes', // <-- ARREGLADO
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:clientes', // <-- ARREGLADO
        ]);

        Cliente::create($request->all());

        // 3. REDIRECCIÓN CORREGIDA
        // Usamos redirect()->back() para que regrese a la página
        // donde estaba el modal (en este caso, /dashboard).
        return redirect()->back()->with('success', 'Cliente agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un cliente.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza los datos de un cliente.
     */
    public function update(Request $request, $id)
    {
        // 4. VALIDACIÓN CORREGIDA (UPDATE)
        // Usamos Rule::unique para que ignore el DNI/Correo del
        // cliente que ESTAMOS EDITANDO.
        // Esto soluciona tu error SQLSTATE[23000]
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clientes')->ignore($id) // <-- ARREGLADO
            ],
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'correo' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clientes')->ignore($id) // <-- ARREGLADO
            ],
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        // 5. REDIRECCIÓN MEJORADA
        // También usamos back() aquí por consistencia.
        return redirect()->back()->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente.
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        // Esta redirección está bien, ya que se hace desde la tabla.
        return redirect()->route('cliente.index')->with('success', 'Cliente eliminado correctamente.');
    }
}