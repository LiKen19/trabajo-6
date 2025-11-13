<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Exception;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'required|string|max:20|unique:clientes',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:clientes',
        ]);

        Cliente::create($validated);

        return redirect()->back()->with('success', 'Cliente agregado correctamente.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => ['required', 'string', 'max:20', Rule::unique('clientes')->ignore($cliente->id)],
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'correo' => ['required', 'email', 'max:255', Rule::unique('clientes')->ignore($cliente->id)],
        ]);

        $cliente->update($validated);

        return redirect()->back()->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
            return redirect()->route('cliente.index')->with('success', 'Cliente eliminado correctamente.');
        } catch (Exception $e) {
            return redirect()->route('cliente.index')->with('error', 'No se pudo eliminar el cliente.');
        }
    }
}

