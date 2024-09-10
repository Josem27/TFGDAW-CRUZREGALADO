<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Rutina;
use App\Models\Ejercicio;
use Illuminate\Support\Facades\Log;

class RutinaController extends Controller
{
    public function index(Request $request)
    {
        // Obtenemos las rutinas del usuario autenticado
        $rutinas = Rutina::where('id_usuario', auth()->user()->id)->get();
    
        // Inicializamos variables adicionales
        $rutinaSeleccionada = null;
        $ejerciciosPorDia = [];
    
        // Si el usuario seleccionó una rutina
        if ($request->has('rutina_id')) {
            $rutinaSeleccionada = Rutina::find($request->rutina_id);
    
            if ($rutinaSeleccionada) {
                $ejerciciosPorDia = $this->getEjerciciosPorDia($rutinaSeleccionada->id_rutina);
            }
        }

        // Pasamos las variables a la vista
        return view('home', compact('rutinas', 'rutinaSeleccionada', 'ejerciciosPorDia'));
    }
    
    private function getEjerciciosPorDia($rutina_id)
    {
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $ejerciciosPorDia = [];
    
        foreach ($diasSemana as $dia) {
            $ejerciciosPorDia[$dia] = Ejercicio::join('rutina_ejercicios', 'ejercicios.id_ejercicio', '=', 'rutina_ejercicios.id_ejercicio')
                ->where('rutina_ejercicios.dia_semana', $dia)
                ->where('rutina_ejercicios.id_rutina', $rutina_id)
                ->select('ejercicios.*', 'rutina_ejercicios.repeticiones', 'rutina_ejercicios.series', 'rutina_ejercicios.minutos')
                ->get();
        }
    
        return $ejerciciosPorDia;
    }
    
    public function create()
    {
        // Obtener todos los ejercicios de la base de datos
        $ejercicios = Ejercicio::all();

        // Pasar los ejercicios a la vista
        return view('rutinas.create', compact('ejercicios'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $rutina = new Rutina();
        $rutina->nombre_rutina = $request->input('nombre_rutina');
        $rutina->fecha_inicio = $request->input('fecha_inicio');
        $rutina->fecha_fin = $request->input('fecha_fin');
        $rutina->id_usuario = auth()->user()->id; // No olvides el ID del usuario
        $rutina->save();

        // Días de la semana que vamos a procesar
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($diasSemana as $dia) {
            // Verificar si hay ejercicios para el día
            if ($request->has("ejercicio_" . strtolower($dia))) {
                $ejercicios = $request->input("ejercicio_" . strtolower($dia));
                $series = $request->input("series_" . strtolower($dia));
                $repeticiones = $request->input("repeticiones_" . strtolower($dia));
                $minutos = $request->input("minutos_" . strtolower($dia));

                // Insertar los ejercicios para ese día
                for ($i = 0; $i < count($ejercicios); $i++) {
                    DB::table('rutina_ejercicios')->insert([
                        'id_rutina' => $rutina->id_rutina,
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

        return redirect()->route('home')->with('success', 'Rutina creada exitosamente');
    }

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

        // Pasar la rutina seleccionada y sus ejercicios a la vista
        return view('home', compact('rutinaSeleccionada'));
    }

}
