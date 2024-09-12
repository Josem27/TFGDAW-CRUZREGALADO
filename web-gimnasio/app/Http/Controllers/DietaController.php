<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Dieta;
use App\Models\Alimento;
use Illuminate\Support\Facades\Log;

class DietaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todas las dietas del usuario autenticado
        $dietas = Dieta::where('id_usuario', auth()->user()->id)->get();

        // Verificar si hay una dieta seleccionada por el usuario en el select
        $dietaSeleccionada = null;
        $alimentosPorDia = [];
        $caloriasTotalesPorDia = [];

        if ($request->has('dieta_id')) {
            $dietaSeleccionada = Dieta::where('id_usuario', auth()->user()->id)
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
                        // Debugging: Verifica los valores de cantidad y calorías
                        Log::info("Alimento: " . $alimento->nombre_alimento . ", Cantidad: " . $alimento->cantidad . ", Calorías: " . $alimento->calorias);

                        $caloriasTotales += ($alimento->calorias * $alimento->cantidad) / 100;  // Calcular calorías basadas en la cantidad
                    }

                    // Guardar las calorías totales por día
                    $caloriasTotalesPorDia[$dia] = $caloriasTotales;

                    // Debugging: Verifica el total de calorías calculadas para el día
                    Log::info("Total de calorías para " . $dia . ": " . $caloriasTotales);
                }
            }
        }

        // Pasar las variables a la vista
        return view('dietas.index', compact('dietas', 'dietaSeleccionada', 'alimentosPorDia', 'caloriasTotalesPorDia'));
    }

    public function create()
    {
        $alimentosPorTipo = Alimento::all()->groupBy('tipo');
        return view('dietas.create', compact('alimentosPorTipo'));
    }

    public function store(Request $request)
    {
        // Crear una nueva dieta y guardarla
        $dieta = new Dieta();
        $dieta->nombre_dieta = $request->input('nombre_dieta');
        $dieta->descripcion = $request->input('descripcion');
        $dieta->fecha_inicio = $request->input('fecha_inicio');
        $dieta->fecha_fin = $request->input('fecha_fin');
        $dieta->id_usuario = auth()->user()->id;
        $dieta->save();  // El ID de la dieta ya estará disponible después de este paso.
    
        // Obtener el ID de la dieta recién creada
        $idDieta = $dieta->id_dieta;  // Ajuste para asegurar que se obtiene el ID correctamente
    
        // Depuración opcional para verificar si el ID es correcto
        // dd($idDieta); // Puedes descomentar esto para verificar si el ID es null o no
    
        // Definir los días de la semana
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    
        // Insertar alimentos para cada día de la semana
        foreach ($diasSemana as $dia) {
            // Verificar si se ha enviado información para ese día
            if ($request->has("alimento_" . strtolower($dia))) {
                $alimentos = $request->input("alimento_" . strtolower($dia));
                $cantidades = $request->input("cantidad_" . strtolower($dia));
                $tiempos_comida = $request->input("tiempo_comida_" . strtolower($dia));
    
                // Insertar cada alimento correspondiente a ese día
                for ($i = 0; $i < count($alimentos); $i++) {
                    DB::table('dieta_alimentos')->insert([
                        'id_dieta' => $idDieta,  // Asegurarse de que el ID de la dieta recién creada se usa aquí
                        'id_alimento' => $alimentos[$i],
                        'cantidad' => $cantidades[$i],
                        'tiempo_comida' => $tiempos_comida[$i],  // Esto ya es un enum
                        'dia_semana' => ucfirst($dia),  // Capitaliza el nombre del día
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    
        return redirect()->route('dietas.index')->with('success', 'Dieta creada exitosamente');
    }
    
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
    
    public function destroy($id)
    {
        $dieta = Dieta::findOrFail($id);
        $dieta->delete();

        return redirect()->route('dietas.index')->with('success', 'Dieta eliminada exitosamente');
    }
}