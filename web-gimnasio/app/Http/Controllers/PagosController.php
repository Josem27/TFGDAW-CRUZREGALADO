<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagos;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PagosExport;

/**
 * Controlador para gestionar los pagos de los usuarios.
 *
 * @package App\Http\Controllers
 */
class PagosController extends Controller
{
    /**
     * Muestra la lista de pagos de un usuario específico.
     *
     * @param int|null $id_usuario El ID del usuario, si se proporciona en la URL; de lo contrario, se usa el usuario autenticado.
     * @return \Illuminate\View\View Vista con la lista de pagos del usuario.
     */
    public function index($id_usuario = null)
    {
        // Usamos el id_usuario de la URL, y si no está, usamos el usuario autenticado.
        $idUsuarioActual = $id_usuario ?? auth()->user()->id;

        // Obtener los pagos del usuario con el id_usuario proporcionado en la URL
        $pagos = Pagos::where('id_usuario', $idUsuarioActual)->get();

        // Pasamos también el idUsuarioActual a la vista para que lo puedas usar.
        return view('pagos.index', compact('pagos', 'idUsuarioActual'));
    }

    /**
     * Almacena un nuevo pago en la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP con los datos del nuevo pago.
     * @param int|null $id_usuario El ID del usuario para el cual se está registrando el pago. Si no se proporciona, se utiliza el usuario autenticado.
     * @return \Illuminate\Http\RedirectResponse Redirige a la vista de pagos con un mensaje de éxito.
     */
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


    /**
     * Exporta los pagos de un usuario a un archivo Excel.
     *
     * @param int|null $id_usuario El ID del usuario, si se proporciona en la URL; de lo contrario, se usa el usuario autenticado.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse Archivo Excel con los pagos del usuario.
     */    public function export($id_usuario = null)
    {
        $idUsuarioActual = $id_usuario ?? auth()->user()->id;

        // Generar el archivo Excel con los pagos del usuario
        return Excel::download(new PagosExport, 'pagos_usuario_' . $idUsuarioActual . '.xlsx');
    }
}
