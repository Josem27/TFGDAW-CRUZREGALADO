<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

/**
 * Class VerificationController
 * 
 * Controlador para gestionar la verificación de correos electrónicos.
 *
 * Este controlador se encarga de manejar la verificación de correos electrónicos para cualquier
 * usuario que se haya registrado recientemente en la aplicación. También permite reenviar los
 * correos de verificación en caso de que el usuario no haya recibido el mensaje original.
 *
 * @package App\Http\Controllers\Auth
 */
class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Ruta de redirección después de la verificación.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crea una nueva instancia del controlador.
     *
     * Aplica varios middlewares:
     * - 'auth' para asegurar que el usuario esté autenticado.
     * - 'signed' para asegurar que el enlace de verificación esté firmado.
     * - 'throttle' para limitar la cantidad de intentos de verificación y reenvío de correos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}