<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // UserController.php

    public function edit()
    {
        $user = Auth::user();
        $user->load('usuario'); // Cargamos la relación 'usuario'

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Verificar si se ha subido una nueva foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');

            // Guardar la foto en el perfil del usuario
            $user->usuario()->update([
                'photo' => $photoPath,
            ]);
        }

        // Actualizar el resto de los datos
        $user->update([
            'name' => $request->input('nick'),
            'email' => $request->input('email'),
        ]);

        // Actualizar campos en la tabla 'usuarios'
        $user->usuario()->update([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'telefono' => $request->input('telefono'),
            'direccion' => $request->input('direccion'),
        ]);

        return redirect()->route('home')->with('success', 'Perfil actualizado correctamente');
    }

}