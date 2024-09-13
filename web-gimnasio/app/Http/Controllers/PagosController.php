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

        return view('pagos.index', compact('pagos'));
    }
    
    public function store(Request $request, $id_usuario)
    {
        $request->validate([
            'cantidad' => 'required|numeric',
            'método_pago' => 'required|string',
            'estado_pago' => 'required|string',
        ]);

        Pagos::create([
            'id_usuario' => $id_usuario,
            'cantidad' => $request->input('cantidad'),
            'método_pago' => $request->input('método_pago'),
            'estado_pago' => $request->input('estado_pago'),
            'fecha_pago' => now(),
        ]);

        return redirect()->back()->with('success', 'Pago guardado exitosamente.');
    }
}
