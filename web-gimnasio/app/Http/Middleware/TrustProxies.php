<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

/**
 * Clase TrustProxies
 * 
 * Middleware para gestionar proxies de confianza.
 * Configura los proxies de confianza para la aplicación y define los encabezados utilizados para detectar proxies.
 *
 * @package App\Http\Middleware
 */
class TrustProxies extends Middleware
{
    /**
     * Proxies de confianza para esta aplicación.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * Encabezados que se deben utilizar para detectar proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}