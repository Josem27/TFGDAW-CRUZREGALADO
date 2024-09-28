<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

/**
 * Clase ValidateSignature
 * 
 * Middleware para validar la firma de las URL.
 * Se utiliza para asegurarse de que las firmas de las URLs sean válidas y evitar modificaciones maliciosas.
 *
 * @package App\Http\Middleware
 */
class ValidateSignature extends Middleware
{
    /**
     * Nombres de los parámetros de la cadena de consulta que deben ser ignorados durante la validación de la firma.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];
}