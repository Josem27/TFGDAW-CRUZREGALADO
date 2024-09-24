<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuario;

/**
 * Class GestionController
 * 
 * Controlador para gestionar los usuarios y sus tipos en la plataforma.
 *
 * @package App\Http\Controllers
 */
class GestionController extends Controller
{
    /**
     * Muestra la lista de usuarios con opción de búsqueda por nombre o apellido.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $usuarios = Usuario::with('user')
            ->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('apellido', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('gestion.index', compact('usuarios'));
    }

    /**
     * Elimina un usuaurio del sistema.
     *
     * @param int $id_usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->delete();

        return redirect()->route('gestion.usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    /**
     * Actualiza el tipo de usuario de un usuario existente.
     *
     * @param Request $request
     * @param int $id_usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);

        $request->validate([
            'tipo_usuario' => 'required|in:Usuario,Entrenador,Administrador',
        ]);

        $usuario->tipo_usuario = $request->input('tipo_usuario');
        $usuario->save();

        return redirect()->route('gestion.usuarios.index')->with('success', 'Tipo de usuario actualizado correctamente.');
    }
}