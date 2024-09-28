<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Clase CheckOwnerOrRole
 * 
 * Middleware para verificar si el usuario autenticado es el dueño del recurso o tiene un rol específico.
 * Permite el acceso a administradores, entrenadores o si el usuario autenticado es el dueño del recurso.
 *
 * @package App\Http\Middleware
 */
class CheckOwnerOrRole
{
    /**
     * Maneja una solicitud entrante y verifica permisos.
     *
     * @param  Request $request Solicitud HTTP.
     * @param  Closure $next Próxima acción en la cadena de solicitudes.
     * @param  string  $role Rol necesario para acceder.
     * @return mixed Redirección o acceso permitido.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $idUsuarioRuta = $request->route('id_usuario');

        if ($user->usuario->tipo_usuario === 'Administrador' || $user->usuario->tipo_usuario === 'Entrenador') {
            return $next($request);
        }

        if ($idUsuarioRuta && $idUsuarioRuta == $user->id) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'No tienes acceso a esta página.');
    }
}