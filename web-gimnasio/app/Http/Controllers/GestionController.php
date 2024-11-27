<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuario;

/**
 * Controlador para la gestión de usuarios.
 *
 * @package App\Http\Controllers
 */
class GestionController extends Controller
{
    /**
     * Muestra la lista de usuarios con opciones de búsqueda.
     *
     * @param Request $request Objeto de solicitud HTTP que puede contener parámetros de búsqueda.
     * @return \Illuminate\View\View Vista con la lista de usuarios filtrada por el término de búsqueda.
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
     * Elimina un usuario de la base de datos.
     *
     * @param int $id_usuario El ID del usuario a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirige a la vista de usuarios con un mensaje de éxito.
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
     * @param Request $request Objeto de solicitud HTTP con los datos del tipo de usuario a actualizar.
     * @param int $id_usuario El ID del usuario a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirige a la vista de usuarios con un mensaje de éxito.
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
