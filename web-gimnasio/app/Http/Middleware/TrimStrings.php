<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * Clase TrimStrings
 * 
 * Middleware para eliminar espacios en blanco de los atributos de las solicitudes.
 * Permite especificar los atributos que no deben ser recortados.
 *
 * @package App\Http\Middleware
 */
class TrimStrings extends Middleware
{
    /**
     * Nombres de los atributos que no deben ser recortados.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}