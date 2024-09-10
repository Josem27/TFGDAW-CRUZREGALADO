<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    // Mostrar el formulario para editar el perfil
    public function edit()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        return view('profile.edit', compact('user')); // Retornar la vista de edición con el usuario
    }

    // Actualizar el perfil del usuario
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        // Manejar la foto de perfil si es subida
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo); // Eliminar la foto anterior si existe
            }

            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        $user->save(); // Guardar los cambios

        return redirect()->route('home')->with('success', 'Perfil actualizado correctamente.');
    }
}