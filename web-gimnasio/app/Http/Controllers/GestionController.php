<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuario;

class GestionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Aquí obtenemos los usuarios junto con la relación 'user'
        $usuarios = Usuario::with('user')
            ->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('apellido', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('gestion.index', compact('usuarios'));
    }

    public function destroy($id)
    {
        // Buscar en la tabla `usuarios` en lugar de `users`
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('gestion.usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
