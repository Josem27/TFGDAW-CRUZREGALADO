<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GestionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $usuarios = User::whereHas('usuario', function ($query) use ($search) {
            if ($search) {
                $query->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('apellido', 'LIKE', "%{$search}%");
            }
        })
        ->with('usuario')
        ->paginate(10);

        return view('gestion_usuarios.index', compact('usuarios'));
    }
}