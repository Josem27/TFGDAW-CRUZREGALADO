<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Clase VerifyCsrfToken
 * 
 * Middleware para verificar el token CSRF (Cross-Site Request Forgery).
 * Protege la aplicación de ataques de falsificación de solicitudes entre sitios, asegurándose de que las solicitudes sean válidas.
 *
 * @package App\Http\Middleware
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * URIs que deben excluirse de la verificación CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}