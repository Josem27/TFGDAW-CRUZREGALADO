<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

/**
 * Clase TrustHosts
 * 
 * Middleware para gestionar los hosts de confianza para la aplicación.
 * Define los patrones de host que deben ser considerados como confiables.
 *
 * @package App\Http\Middleware
 */
class TrustHosts extends Middleware
{
    /**
     * Obtiene los patrones de host que deben ser de confianza.
     *
     * @return array<int, string|null> Lista de patrones de hosts de confianza.
     */
    public function hosts(): array
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}