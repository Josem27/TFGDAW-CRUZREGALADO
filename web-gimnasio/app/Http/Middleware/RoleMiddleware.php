<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene uno de los roles permitidos
        if (in_array($user->usuario->tipo_usuario, $roles)) {
            return $next($request);
        }

        // Si no tiene el rol adecuado, redirigir a la página principal con un error
        return redirect('/home')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}