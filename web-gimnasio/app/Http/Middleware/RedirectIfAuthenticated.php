<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Clase RedirectIfAuthenticated
 * 
 * Middleware para redirigir a usuarios autenticados.
 * Si un usuario ya está autenticado, se le redirige a la página de inicio.
 *
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next Próxima acción en la cadena de solicitudes.
     * @param  string  ...$guards Tipos de autenticación a verificar.
     * @return \Symfony\Component\HttpFoundation\Response Redirección o acceso permitido.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}