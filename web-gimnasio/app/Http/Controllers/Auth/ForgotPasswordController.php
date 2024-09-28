<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * Class ForgotPasswordController
 * 
 * Controlador para gestionar el envío de correos electrónicos de restablecimiento de contraseña.
 *
 * Este controlador se encarga de manejar los correos electrónicos de restablecimiento de contraseña.
 * Incluye un trait que facilita el envío de estas notificaciones desde tu aplicación a los usuarios.
 *
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
}