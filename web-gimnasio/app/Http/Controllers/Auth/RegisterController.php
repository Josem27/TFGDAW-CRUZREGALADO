<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegisterController
 * 
 * Controlador para gestionar el registro de nuevos usuarios.
 *
 * Este controlador se encarga de manejar el registro de nuevos usuarios, así como su validación y creación.
 * Utiliza un trait para proporcionar esta funcionalidad sin requerir código adicional.
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Ruta de redirección después del registro.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crea una nueva instancia del controlador.
     *
     * Aplica el middleware 'guest' para asegurarse de que solo los usuarios no autenticados puedan acceder al registro.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Obtiene un validador para una solicitud de registro entrante.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crea una nueva instancia de usuario después de un registro válido.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}