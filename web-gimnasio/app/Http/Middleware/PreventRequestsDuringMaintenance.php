<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

/**
 * Clase PreventRequestsDuringMaintenance
 * 
 * Middleware para prevenir solicitudes durante el modo de mantenimiento.
 * Permite especificar URIs que deben ser accesibles mientras el modo de mantenimiento está activo.
 *
 * @package App\Http\Middleware
 */
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * URIs que deben ser accesibles durante el modo de mantenimiento.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}