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
            // Incluir el pivote en la consulta para que cargue las series, repeticiones y minutos
            $ejerciciosPorDia[$dia] = DB::table('rutina_ejercicios')
                ->join('ejercicios', 'rutina_ejercicios.id_ejercicio', '=', 'ejercicios.id_ejercicio')
                ->where('rutina_ejercicios.dia_semana', $dia)
                ->where('rutina_ejercicios.id_rutina', $rutina_id)
                ->select('ejercicios.*', 'rutina_ejercicios.series', 'rutina_ejercicios.repeticiones', 'rutina_ejercicios.minutos')
                ->get();
    
            // Log para verificar si está trayendo los ejercicios correctamente
            Log::info("Ejercicios para {$dia}: ", $ejerciciosPorDia[$dia]->toArray());
        }
    
        return $ejerciciosPorDia;
    }
    
    public function create()
    {
        // Agrupar ejercicios por categoría
        $ejerciciosPorCategoria = Ejercicio::all()->groupBy('categoria');

        return view('rutinas.create', compact('ejerciciosPorCategoria'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        $rutina = new Rutina();
        $rutina->nombre_rutina = $request->input('nombre_rutina');
        $rutina->descripcion = $request->input('descripcion_rutina'); 
        $rutina->fecha_inicio = $request->input('fecha_inicio');
        $rutina->fecha_fin = $request->input('fecha_fin');
        $rutina->id_usuario = auth()->user()->id;
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

    public function getEjerciciosPorCategoria()
    {
        // Agrupar ejercicios por categoría
        $ejercicios = Ejercicio::all()->groupBy('categoria');

        return $ejercicios;
    }

    public function edit($id)
    {
        // Obtener la rutina seleccionada
        $rutinaSeleccionada = Rutina::findOrFail($id);
        
        // Obtener los ejercicios por día
        $ejerciciosPorDia = $this->getEjerciciosPorDia($rutinaSeleccionada->id_rutina);
        
        // Agrupar ejercicios por categoría
        $ejerciciosPorCategoria = $this->getEjerciciosPorCategoria();
    
        // Pasar las variables a la vista
        return view('rutinas.edit', compact('rutinaSeleccionada', 'ejerciciosPorDia', 'ejerciciosPorCategoria'));
    }
    

    public function destroy($id)
    {
        $rutina = Rutina::findOrFail($id);
        $rutina->delete();

        return redirect()->route('home')->with('success', 'Rutina eliminada correctamente.');
    }
    public function update(Request $request, $id)
    {
        $rutina = Rutina::findOrFail($id);
        $rutina->nombre_rutina = $request->nombre_rutina;
        $rutina->descripcion = $request->descripcion_rutina;
        $rutina->fecha_inicio = $request->fecha_inicio;
        $rutina->fecha_fin = $request->fecha_fin;
        $rutina->save();
    
        // Días de la semana que vamos a procesar
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    
        foreach ($diasSemana as $dia) {
            if ($request->has("ejercicio_" . strtolower($dia))) {
                $ejercicios = $request->input("ejercicio_" . strtolower($dia));
                $series = $request->input("series_" . strtolower($dia));
                $repeticiones = $request->input("repeticiones_" . strtolower($dia));
                $minutos = $request->input("minutos_" . strtolower($dia));
    
                // Eliminar los ejercicios anteriores y actualizarlos
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
    
        return redirect()->route('home')->with('success', 'Rutina actualizada correctamente.');
    }
    
}
