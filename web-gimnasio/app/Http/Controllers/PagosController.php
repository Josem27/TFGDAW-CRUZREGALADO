<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagos;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
{
    public function index()
    {
        $pagos = Pagos::where('id_usuario', Auth::id())->get();

        return view('pagos.index', compact('pagos'));
    }
}
