<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Dieta;
use App\Models\Alimento;
use Illuminate\Support\Facades\Log;

/**
 * Controlador para gestionar las dietas de los usuarios.
 *
 * @package App\Http\Controllers
 */
class DietaController extends Controller
{
    /**
     * Muestra una lista de dietas para un usuario específico o el usuario autenticado.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param int|null $id_usuario El ID del usuario, si es proporcionado, de lo contrario se usará el usuario autenticado.
     * @return \Illuminate\View\View Vista con las dietas del usuario.
     */
    public function index(Request $request, $id_usuario = null)
    {
        // Si se pasa el id_usuario, buscamos las dietas de ese usuario, si no, usamos el usuario autenticado
        $idUsuarioActual = $id_usuario ?? auth()->user()->id;

        // Obtener todas las dietas del usuario seleccionado
        $dietas = Dieta::where('id_usuario', $idUsuarioActual)->get();

        // Verificar si hay una dieta seleccionada por el usuario en el select
        $dietaSeleccionada = null;
        $alimentosPorDia = [];
        $caloriasTotalesPorDia = [];

        if ($request->has('dieta_id')) {
            $dietaSeleccionada = Dieta::where('id_usuario', $idUsuarioActual)
                ->where('id_dieta', $request->input('dieta_id'))
                ->first();

            // Si hay una dieta seleccionada, obtener los alimentos por día
            if ($dietaSeleccionada) {
                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

                foreach ($diasSemana as $dia) {
                    $alimentos = DB::table('dieta_alimentos')
                        ->join('alimentos', 'dieta_alimentos.id_alimento', '=', 'alimentos.id_alimento')
                        ->where('dieta_alimentos.id_dieta', $dietaSeleccionada->id_dieta)
                        ->where('dieta_alimentos.dia_semana', $dia)
                        ->select('alimentos.nombre_alimento', 'dieta_alimentos.cantidad', 'alimentos.calorias', 'dieta_alimentos.tiempo_comida')
                        ->get();

                    // Guardar los alimentos por día
                    $alimentosPorDia[$dia] = $alimentos;

                    // Calcular las calorías totales para el día
                    $caloriasTotales = 0;
                    foreach ($alimentos as $alimento) {
                        $caloriasTotales += ($alimento->calorias * $alimento->cantidad) / 100;
                    }

                    // Guardar las calorías totales por día
                    $caloriasTotalesPorDia[$dia] = $caloriasTotales;
                }
            }
        }

        // Pasar las variables a la vista, incluida 'idUsuarioActual'
        return view('dietas.index', compact('dietas', 'dietaSeleccionada', 'alimentosPorDia', 'caloriasTotalesPorDia', 'idUsuarioActual'));
    }

    /**
     * Muestra el formulario para crear una nueva dieta.
     *
     * @param int $id_usuario El ID del usuario que creará la dieta.
     * @return \Illuminate\View\View Vista con el formulario de creación de dieta.
     */
    public function create($id_usuario)
    {
        // Agrupar alimentos por categorías o cualquier lógica necesaria
        $alimentosPorTipo = Alimento::all()->groupBy('categoria');

        // Pasar el id_usuario a la vista
        return view('dietas.create', compact('alimentosPorTipo', 'id_usuario'));
    }

    /**
     * Guarda una nueva dieta en la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP con los datos de la dieta.
     * @return \Illuminate\Http\RedirectResponse Redirige a la vista de dietas del usuario.
     */
    public function store(Request $request)
    {
        // Crear una nueva dieta y guardarla
        $dieta = new Dieta();
        $dieta->nombre_dieta = $request->input('nombre_dieta');
        $dieta->descripcion = $request->input('descripcion');
        $dieta->fecha_inicio = $request->input('fecha_inicio');
        $dieta->fecha_fin = $request->input('fecha_fin');
        $dieta->id_usuario = $request->input('id_usuario');  // Usar el id_usuario pasado en el formulario
        $dieta->save();

        // Obtener el ID de la dieta recién creada
        $idDietaCreada = $dieta->id_dieta;  // Cambia esto si la clave primaria es 'id_dieta'

        // Definir los días de la semana
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($diasSemana as $dia) {
            if ($request->has("alimento_" . strtolower($dia))) {
                $alimentos = $request->input("alimento_" . strtolower($dia));
                $cantidades = $request->input("cantidad_" . strtolower($dia));
                $tiemposComida = $request->input("tiempo_comida_" . strtolower($dia));

                for ($i = 0; $i < count($alimentos); $i++) {
                    DB::table('dieta_alimentos')->insert([
                        'id_dieta' => $idDietaCreada,  // Usar el ID recién creado de la dieta
                        'id_alimento' => $alimentos[$i],
                        'cantidad' => $cantidades[$i],
                        'tiempo_comida' => $tiemposComida[$i],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Redirigir a la página de dietas del usuario seleccionado
        return redirect()->route('dietas.index', ['id_usuario' => $dieta->id_usuario])
            ->with('success', 'Dieta creada exitosamente');
    }

    /**
     * Actualiza una dieta existente en la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP con los datos de la dieta actualizada.
     * @param int $id El ID de la dieta a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirige a la vista de dietas.
     */
    public function update(Request $request, $id)
    {
        $dieta = Dieta::findOrFail($id);
        $dieta->nombre_dieta = $request->input('nombre_dieta');
        $dieta->descripcion = $request->input('descripcion');
        $dieta->fecha_inicio = $request->input('fecha_inicio');
        $dieta->fecha_fin = $request->input('fecha_fin');
        $dieta->save();

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        // Eliminar los alimentos actuales de la dieta para luego reinsertarlos
        DB::table('dieta_alimentos')->where('id_dieta', $dieta->id_dieta)->delete();

        // Insertar los nuevos alimentos por día
        foreach ($diasSemana as $dia) {
            if ($request->has("alimento_" . strtolower($dia))) {
                $alimentos = $request->input("alimento_" . strtolower($dia));
                $cantidades = $request->input("cantidad_" . strtolower($dia));
                $tiempos_comida = $request->input("tiempo_comida_" . strtolower($dia));

                for ($i = 0; $i < count($alimentos); $i++) {
                    DB::table('dieta_alimentos')->insert([
                        'id_dieta' => $dieta->id_dieta,
                        'id_alimento' => $alimentos[$i],
                        'cantidad' => $cantidades[$i],
                        'tiempo_comida' => $tiempos_comida[$i],
                        'dia_semana' => ucfirst($dia),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('dietas.index')->with('success', 'Dieta actualizada exitosamente');
    }

    /**
     * Muestra el formulario para editar una dieta existente.
     *
     * @param int $id El ID de la dieta a editar.
     * @return \Illuminate\View\View Vista con el formulario de edición de dieta.
     */
    public function edit($id)
    {
        $dietaSeleccionada = Dieta::findOrFail($id);
        $alimentosPorTipo = Alimento::all()->groupBy('tipo');

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $alimentosPorDia = [];

        foreach ($diasSemana as $dia) {
            $alimentos = DB::table('dieta_alimentos')
                ->join('alimentos', 'dieta_alimentos.id_alimento', '=', 'alimentos.id_alimento')
                ->where('dieta_alimentos.id_dieta', $dietaSeleccionada->id_dieta)
                ->where('dieta_alimentos.dia_semana', $dia)
                ->select('alimentos.id_alimento', 'alimentos.nombre_alimento', 'dieta_alimentos.cantidad', 'dieta_alimentos.tiempo_comida')
                ->get();
            $alimentosPorDia[$dia] = $alimentos;
        }

        return view('dietas.edit', compact('dietaSeleccionada', 'alimentosPorTipo', 'alimentosPorDia'));
    }

    /**
     * Elimina una dieta de la base de datos.
     *
     * @param int $id El ID de la dieta a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirige a la vista de dietas del usuario.
     */
    public function destroy($id)
    {
        $dieta = Dieta::findOrFail($id);

        $idUsuario = $dieta->id_usuario;

        $dieta->delete();

        return redirect()->route('dietas.index', ['id_usuario' => $idUsuario])
            ->with('success', 'Dieta eliminada exitosamente');
    }
}
