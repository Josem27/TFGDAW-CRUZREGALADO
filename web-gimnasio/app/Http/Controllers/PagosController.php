<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagos;

class PagosController extends Controller
{
    public function index($id_usuario = null)
    {
        // Usamos el id_usuario de la URL, y si no está, usamos el usuario autenticado.
        $idUsuarioActual = $id_usuario ?? auth()->user()->id;
    
        // Obtener los pagos del usuario con el id_usuario proporcionado en la URL
        $pagos = Pagos::where('id_usuario', $idUsuarioActual)->get();
    
        // Pasamos también el idUsuarioActual a la vista para que lo puedas usar.
        return view('pagos.index', compact('pagos', 'idUsuarioActual'));
    }    
    
    public function store(Request $request, $id_usuario = null)
    {
        // Si el id_usuario no se proporciona, usar el id del usuario autenticado
        $idUsuario = $request->input('id_usuario') ?? auth()->user()->id;
    
        // Validar los campos de entrada
        $request->validate([
            'cantidad' => 'required|numeric',
            'método_pago' => 'required|string',
            'estado_pago' => 'required|string',
        ]);
    
        // Crear un nuevo pago
        Pagos::create([
            'id_usuario' => $idUsuario, // Asegurarse de que se usa el id_usuario correcto
            'fecha_pago' => now(),
            'cantidad' => $request->input('cantidad'),
            'método_pago' => $request->input('método_pago'),
            'estado_pago' => $request->input('estado_pago'),
        ]);
    
        return redirect()->route('pagos.index', ['id_usuario' => $id_usuario])
                         ->with('success', 'Pago registrado correctamente.');
    }    
}
