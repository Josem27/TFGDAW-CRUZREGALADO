<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

/**
 * Class ConfirmPasswordController
 * 
 * Controlador para gestionar la confirmación de contraseñas.
 *
 * Este controlador se encarga de manejar la confirmación de contraseñas
 * utilizando un trait simple que incluye este comportamiento.
 *
 * @package App\Http\Controllers\Auth
 */
class ConfirmPasswordController extends Controller
{
    use ConfirmsPasswords;

    /**
     * Redirección predeterminada cuando la URL intentada falla.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crea una nueva instancia del controlador.
     *
     * Aplica el middleware 'auth' para asegurarse de que el usuario esté autenticado.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}