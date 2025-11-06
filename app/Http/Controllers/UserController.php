<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     */
    public function create()
    {
        // No necesario porque usamos modal
    }

    /**
     * Almacena un nuevo usuario en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Muestra los detalles de un usuario específico
     */
    public function show($id)
    {
        // No necesario porque usamos modal
    }

    /**
     * Muestra el formulario para editar un usuario
     */
    public function edit($id)
    {
        // No necesario porque usamos modal
    }

    /**
     * Actualiza un usuario en la base de datos
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // Solo actualizar contraseña si se proporciona una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Elimina un usuario de la base de datos
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Opcional: prevenir que se elimine a sí mismo
        // if (auth()->id() == $id) {
        //     return redirect()->route('user.index')->with('error', 'No puedes eliminar tu propio usuario');
        // }
        
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Usuario eliminado exitosamente');
    }
}