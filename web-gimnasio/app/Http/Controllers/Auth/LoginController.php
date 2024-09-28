<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class LoginController
 * 
 * Controlador para gestionar la autenticación de usuarios.
 *
 * Este controlador se encarga de autenticar a los usuarios en la aplicación y redirigirlos a la pantalla principal.
 * Utiliza un trait para proporcionar su funcionalidad de manera conveniente.
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Ruta de redirección después del inicio de sesión.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crea una nueva instancia del controlador.
     *
     * Aplica el middleware 'guest' excepto en la acción de cierre de sesión ('logout').
     * Aplica el middleware 'auth' únicamente en la acción de cierre de sesión.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}