<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Clase CheckRole
 * 
 * Middleware para verificar si el usuario tiene un rol especíifico.
 * Comprueba si el usuario tiene uno de los roles permitidos para acceder a la página.
 *
 * @package App\Http\Middleware
 */
class CheckRole
{
    /**
     * Maneja una solicitud entrante y verifica roles.
     *
     * @param  \Illuminate\Http\Request  $request Solicitud HTTP.
     * @param  Closure  $next Próxima acción en la cadena de solicitudes.
     * @param  array|string  $roles Roles permitidos para acceder.
     * @return mixed Redirección o acceso permitido.
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $tipoUsuario = Auth::user()->usuario->tipo_usuario;

        if (!in_array($tipoUsuario, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}