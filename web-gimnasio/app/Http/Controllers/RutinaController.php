<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Rutina;
use App\Models\Ejercicio;
use Illuminate\Support\Facades\Log;

/**
 * Class RutinaController
 * 
 * Controlador para gestionar las rutinas de ejercicios de los usuarios.
 *
 * @package App\Http\Controllers
 */
class RutinaController extends Controller
{
    /**
     * Muestra la lista de rutinas de un usuario. Si no se pasa un id de usuario, utiliza el usuario autenticado.
     *
     * @param Request $request
     * @param int|null $id_usuario
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $id_usuario = null)
    {
        $idUsuarioActual = $id_usuario ?? auth()->user()->id;
        $rutinas = Rutina::where('id_usuario', $idUsuarioActual)->get();

        $rutinaSeleccionada = null;
        $ejerciciosPorDia = [];

        if ($request->has('rutina_id')) {
            $rutinaSeleccionada = Rutina::find($request->rutina_id);

            if ($rutinaSeleccionada) {
                $ejerciciosPorDia = $this->getEjerciciosPorDia($rutinaSeleccionada->id_rutina);
            }
        }

        return view('rutinas.index', compact('rutinas', 'rutinaSeleccionada', 'ejerciciosPorDia', 'idUsuarioActual'));
    }

    /**
     * Obtiene los ejercicios agrupados por día para una rutina específica.
     *
     * @param int $rutina_id
     * @return array
     */
    private function getEjerciciosPorDia($rutina_id)
    {
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $ejerciciosPorDia = [];

        foreach ($diasSemana as $dia) {
            $ejerciciosPorDia[$dia] = DB::table('rutina_ejercicios')
                ->join('ejercicios', 'rutina_ejercicios.id_ejercicio', '=', 'ejercicios.id_ejercicio')
                ->where('rutina_ejercicios.dia_semana', $dia)
                ->where('rutina_ejercicios.id_rutina', $rutina_id)
                ->select('ejercicios.*', 'rutina_ejercicios.series', 'rutina_ejercicios.repeticiones', 'rutina_ejercicios.minutos')
                ->get();

            Log::info("Ejercicios para {$dia}: ", $ejerciciosPorDia[$dia]->toArray());
        }

        return $ejerciciosPorDia;
    }

    /**
     * Muestra el formulario para crear una nueva rutina para el usuario especificado.
     *
     * @param int $id_usuario
     * @return \Illuminate\View\View
     */
    public function create($id_usuario)
    {
        $ejerciciosPorCategoria = Ejercicio::all()->groupBy('categoria');
        return view('rutinas.create', compact('ejerciciosPorCategoria', 'id_usuario'));
    }

    /**
     * Almacena una nueva rutina en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rutina = new Rutina();
        $rutina->nombre_rutina = $request->input('nombre_rutina');
        $rutina->descripcion = $request->input('descripcion');
        $rutina->fecha_inicio = $request->input('fecha_inicio');
        $rutina->fecha_fin = $request->input('fecha_fin');
        $rutina->id_usuario = $request->input('id_usuario');
        $rutina->save();

        $idRutinaCreada = $rutina->id_rutina;

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($diasSemana as $dia) {
            if ($request->has("ejercicio_" . strtolower($dia))) {
                $ejercicios = $request->input("ejercicio_" . strtolower($dia));
                $series = $request->input("series_" . strtolower($dia));
                $repeticiones = $request->input("repeticiones_" . strtolower($dia));
                $minutos = $request->input("minutos_" . strtolower($dia));

                for ($i = 0; $i < count($ejercicios); $i++) {
                    DB::table('rutina_ejercicios')->insert([
                        'id_rutina' => $idRutinaCreada,
                        'id_ejercicio' => $ejercicios[$i],
                        'series' => $series[$i],
                        'repeticiones' => $repeticiones[$i],
                        'minutos' => $minutos[$i],
                        'dia_semana' => ucfirst($dia),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('rutinas.index', ['id_usuario' => $rutina->id_usuario])->with('success', 'Rutina creada exitosamente');
    }

    /**
     * Muestra una rutina específica con sus ejercicios.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request)
    {
        $rutinaId = $request->input('rutina_id');
        $rutinaSeleccionada = Rutina::with('ejercicios')->find($request->rutina_id);

        if ($rutinaSeleccionada) {
            $ejerciciosPorDia = $this->getEjerciciosPorDia($rutinaSeleccionada->id_rutina);
        }

        if (!$rutinaSeleccionada) {
            return redirect()->back()->with('error', 'Rutina no encontrada');
        }

        return view('rutinas.index', compact('rutinaSeleccionada'));
    }

    /**
     * Obtiene los ejercicios agrupados por categoría.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEjerciciosPorCategoria()
    {
        $ejercicios = Ejercicio::all()->groupBy('categoria');
        return $ejercicios;
    }

    /**
     * Muestra el formulario para editar una rutina existente.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $rutinaSeleccionada = Rutina::findOrFail($id);
        $ejerciciosPorDia = $this->getEjerciciosPorDia($rutinaSeleccionada->id_rutina);
        $ejerciciosPorCategoria = $this->getEjerciciosPorCategoria();

        return view('rutinas.edit', compact('rutinaSeleccionada', 'ejerciciosPorDia', 'ejerciciosPorCategoria'));
    }

    /**
     * Elimina una rutina específica.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $rutina = Rutina::findOrFail($id);
        $rutina->delete();

        return redirect()->route('rutinas.index', ['id_usuario' => $rutina->id_usuario])->with('success', 'Rutina eliminada correctamente.');
    }

    /**
     * Actualiza una rutina existente en la base de dattos.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $rutina = Rutina::findOrFail($id);
        $rutina->nombre_rutina = $request->nombre_rutina;
        $rutina->descripcion = $request->descripcion_rutina;
        $rutina->fecha_inicio = $request->fecha_inicio;
        $rutina->fecha_fin = $request->fecha_fin;
        $rutina->save();

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($diasSemana as $dia) {
            if ($request->has("ejercicio_" . strtolower($dia))) {
                $ejercicios = $request->input("ejercicio_" . strtolower($dia));
                $series = $request->input("series_" . strtolower($dia));
                $repeticiones = $request->input("repeticiones_" . strtolower($dia));
                $minutos = $request->input("minutos_" . strtolower($dia));

                DB::table('rutina_ejercicios')
                    ->where('id_rutina', $id)
                    ->where('dia_semana', ucfirst($dia))
                    ->delete();

                for ($i = 0; $i < count($ejercicios); $i++) {
                    DB::table('rutina_ejercicios')->insert([
                        'id_rutina' => $id,
                        'id_ejercicio' => $ejercicios[$i],
                        'series' => $series[$i],
                        'repeticiones' => $repeticiones[$i],
                        'minutos' => $minutos[$i],
                        'dia_semana' => ucfirst($dia),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('rutinas.index', ['id_usuario' => $rutina->id_usuario])->with('success', 'Rutina actualizada correctamente.');
    }
}