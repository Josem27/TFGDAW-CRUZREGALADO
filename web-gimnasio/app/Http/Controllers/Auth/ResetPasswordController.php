<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Class ResetPasswordController
 * 
 * Controlador para gestionar las solicitudes de restablecimiento de contraseña.
 *
 * Este controlador se encarga de manejar las solicitudes de restablecimiento de contraseña y
 * utiliza un trait que incluye este comportamiento de manera sencilla.
 *
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Ruta de redirección después de restablecer la contraseña.
     *
     * @var string
     */
    protected $redirectTo = '/home';
}