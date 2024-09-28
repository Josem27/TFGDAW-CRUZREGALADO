<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserController
 * 
 * Controlador para gestionar el perfil de usuario.
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $user->load('usuario');

        return view('profile.edit', compact('user'));
    }

    /**
     * Actualiza el perfil del usuario autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');

            $user->usuario()->update([
                'photo' => $photoPath,
            ]);
        }

        $user->update([
            'name' => $request->input('nick'),
            'email' => $request->input('email'),
        ]);

        $user->usuario()->update([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'telefono' => $request->input('telefono'),
            'direccion' => $request->input('direccion'),
        ]);

        return redirect()->route('home')->with('success', 'Perfil actualizado correctamente');
    }
}