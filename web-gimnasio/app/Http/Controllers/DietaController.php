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
    public function create()
    {
        $alimentosPorCategoria = Alimento::all()->groupBy('categoria');
        return view('dietas.create', compact('alimentosPorCategoria'));
    }
    
    public function store(Request $request)
    {
        $dieta = new Dieta();
        $dieta->nombre_dieta = $request->input('nombre_dieta');
        $dieta->descripcion = $request->input('descripcion');
        $dieta->fecha_inicio = $request->input('fecha_inicio');
        $dieta->fecha_fin = $request->input('fecha_fin');
        $dieta->id_usuario = auth()->user()->id;
        $dieta->save();
    
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    
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
    
        return redirect()->route('dietas.index')->with('success', 'Dieta creada exitosamente');
    }
}    