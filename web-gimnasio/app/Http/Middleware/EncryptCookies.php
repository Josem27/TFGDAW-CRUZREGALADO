<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * Clase EncryptCookies
 * 
 * Middleware para gestionar la encriptación de cookies.
 * Permite especificar las cookies que no deben ser encriptadas.
 *
 * @package App\Http\Middleware
 */
class EncryptCookies extends Middleware
{
    /**
     * Nombres de las cookies que no deben ser encriptadas.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}