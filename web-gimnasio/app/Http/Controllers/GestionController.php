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

        $usuarios = Usuario::with('user')
            ->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('apellido', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('gestion.index', compact('usuarios'));
    }

    public function destroy($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->delete();
        return redirect()->route('gestion.usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

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
