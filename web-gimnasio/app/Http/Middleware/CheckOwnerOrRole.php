<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOwnerOrRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $idUsuarioRuta = $request->route('id_usuario'); // Obtiene el id_usuario de la ruta

        // Si el usuario es administrador o entrenador, permitir el acceso
        if ($user->usuario->tipo_usuario === 'Administrador' || $user->usuario->tipo_usuario === 'Entrenador') {
            return $next($request);
        }

        // Si el id del usuario autenticado coincide con el id en la ruta, permitir el acceso
        if ($idUsuarioRuta && $idUsuarioRuta == $user->id) {
            return $next($request);
        }

        // De lo contrario, negar el acceso
        return redirect()->route('home')->with('error', 'No tienes acceso a esta página.');
    }
}