<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagos;

/**
 * Class PagosController
 * 
 * Controlador para gestionar los pagos de los usuarios.
 *
 * @package App\Http\Controllers
 */
class PagosController extends Controller
{
    /**
     * Muestra la lista de pagos de un usuario. Si no se pasa un id de usuario, utiliza el usuario autenticado.
     *
     * @param int|null $id_usuario
     * @return \Illuminate\View\View
     */
    public function index($id_usuario = null)
    {
        $idUsuarioActual = $id_usuario ?? auth()->user()->id;
        $pagos = Pagos::where('id_usuario', $idUsuarioActual)->get();

        return view('pagos.index', compact('pagos', 'idUsuarioActual'));
    }


    
    /**
     * Almacena un nuevo pago en la base de datos.
     *
     * @param Request $request
     * @param int|null $id_usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id_usuario = null)
    {
        $idUsuario = $request->input('id_usuario') ?? auth()->user()->id;

        $request->validate([
            'cantidad' => 'required|numeric',
            'método_pago' => 'required|string',
            'estado_pago' => 'required|string',
        ]);

        Pagos::create([
            'id_usuario' => $idUsuario,
            'fecha_pago' => now(),
            'cantidad' => $request->input('cantidad'),
            'método_pago' => $request->input('método_pago'),
            'estado_pago' => $request->input('estado_pago'),
        ]);

        return redirect()->route('pagos.index', ['id_usuario' => $id_usuario])
                         ->with('success', 'Pago registrado correctamente.');
    }
}