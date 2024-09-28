<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Clase Authenticate
 * 
 * Middleware para gestionar la autenticación de usuarios.
 * Redirige a la ruta de inicio de sesión cuando el usuario no está autenticado.
 *
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * Obtiene la ruta a la que el usuario debe ser redirigido cuando no está autenticado.
     *
     * @param Request $request
     * @return ?string Ruta de redirección cuando el usuario no está autenticado.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}