<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Clase RoleMiddleware
 * 
 * Middleware para verificar si el usuario tiene uno de los roles permitidos.
 * Redirige a la página principal con un error si no se tiene el rol adecuado.
 *
 * @package App\Http\Middleware
 */
class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante y verifica roles.
     *
     * @param  \Illuminate\Http\Request  $request Solicitud HTTP.
     * @param  Closure  $next Próxima acción en la cadena de solicitudes.
     * @param  array|string  ...$roles Roles permitidos para acceder.
     * @return mixed Redirección o acceso permitido.
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (in_array($user->usuario->tipo_usuario, $roles)) {
            return $next($request);
        }

        return redirect('/home')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}