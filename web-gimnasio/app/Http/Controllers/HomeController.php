<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener todas las rutinas del usuario autenticado (ejemplo)
        $rutinas = Rutina::where('id_usuario', auth()->user()->id)->get();

        // Pasar las rutinas a la vista
        return view('home', compact('rutinas'));
    }


    public function home()
    {
        $user = auth()->user();

        if ($user->needsProfileCompletion()) {
            return view('home')->with('showModal', true);
        }

        return view('home')->with('showModal', false);
    }

}
