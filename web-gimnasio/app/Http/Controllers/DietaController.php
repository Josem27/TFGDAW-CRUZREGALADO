<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Dieta;
use App\Models\Alimento;
use Illuminate\Support\Facades\Log;

/**
 * Class DietaController
 * 
 * Controlador para gestionar las dietas de los usuarios.
 *
 * @package App\Http\Controllers
 */
class DietaController extends Controller
{
    /**
     * Muestra las dietas de un usuario. Si no se pasa un id de usuario, utiliza el usuario autenticado.
     *
     * @param Request $request
     * @param int|null $id_usuario
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $id_usuario = null)
    {
        $idUsuarioActual = $id_usuario ?? auth()->user()->id;
        $dietas = Dieta::where('id_usuario', $idUsuarioActual)->get();

        $dietaSeleccionada = null;
        $alimentosPorDia = [];
        $caloriasTotalesPorDia = [];

        if ($request->has('dieta_id')) {
            $dietaSeleccionada = Dieta::where('id_usuario', $idUsuarioActual)
                ->where('id_dieta', $request->input('dieta_id'))
                ->first();

            if ($dietaSeleccionada) {
                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

                foreach ($diasSemana as $dia) {
                    $alimentos = DB::table('dieta_alimentos')
                        ->join('alimentos', 'dieta_alimentos.id_alimento', '=', 'alimentos.id_alimento')
                        ->where('dieta_alimentos.id_dieta', $dietaSeleccionada->id_dieta)
                        ->where('dieta_alimentos.dia_semana', $dia)
                        ->select('alimentos.nombre_alimento', 'dieta_alimentos.cantidad', 'alimentos.calorias', 'dieta_alimentos.tiempo_comida')
                        ->get();

                    $alimentosPorDia[$dia] = $alimentos;

                    $caloriasTotales = 0;
                    foreach ($alimentos as $alimento) {
                        $caloriasTotales += ($alimento->calorias * $alimento->cantidad) / 100;
                    }
                    $caloriasTotalesPorDia[$dia] = $caloriasTotales;
                }
            }
        }

        return view('dietas.index', compact('dietas', 'dietaSeleccionada', 'alimentosPorDia', 'caloriasTotalesPorDia', 'idUsuarioActual'));
    }

    /**
     * Muestra el formulario para crear una nueva dieta para el usuario especificado.
     *
     * @param int $id_usuario
     * @return \Illuminate\View\View
     */
    public function create($id_usuario)
    {
        $alimentosPorTipo = Alimento::all()->groupBy('categoria');
        return view('dietas.create', compact('alimentosPorTipo', 'id_usuario'));
    }

    /**
     * Almacena una nueva dieta en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $dieta = new Dieta();
        $dieta->nombre_dieta = $request->input('nombre_dieta');
        $dieta->descripcion = $request->input('descripcion');
        $dieta->fecha_inicio = $request->input('fecha_inicio');
        $dieta->fecha_fin = $request->input('fecha_fin');
        $dieta->id_usuario = $request->input('id_usuario');
        $dieta->save();

        $idDietaCreada = $dieta->id_dieta;

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($diasSemana as $dia) {
            if ($request->has("alimento_" . strtolower($dia))) {
                $alimentos = $request->input("alimento_" . strtolower($dia));
                $cantidades = $request->input("cantidad_" . strtolower($dia));
                $tiemposComida = $request->input("tiempo_comida_" . strtolower($dia));

                for ($i = 0; $i < count($alimentos); $i++) {
                    DB::table('dieta_alimentos')->insert([
                        'id_dieta' => $idDietaCreada,
                        'id_alimento' => $alimentos[$i],
                        'cantidad' => $cantidades[$i],
                        'tiempo_comida' => $tiemposComida[$i],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('dietas.index', ['id_usuario' => $dieta->id_usuario])
            ->with('success', 'Dieta creada exitosamente');
    }

    /**
     * Actualiza una dieta existente
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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

        DB::table('dieta_alimentos')->where('id_dieta', $dieta->id_dieta)->delete();

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
     * @param int $id
     * @return \Illuminate\View\View
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
     * Elimina una dieta.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $dieta = Dieta::findOrFail($id);
        $dieta->delete();

        return redirect()->route('dietas.index')->with('success', 'Dieta eliminada exitosamente');
    }
}