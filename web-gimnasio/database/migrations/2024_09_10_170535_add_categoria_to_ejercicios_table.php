<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Usuario;

class MigrateUsersToUsuarios extends Command
{
    protected $signature = 'migrate:users-to-usuarios';
    protected $description = 'Migrar usuarios existentes de la tabla users a la tabla usuarios';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Obtener todos los usuarios
        $users = User::all();

        foreach ($users as $user) {
            // Verificar si el usuario ya existe en la tabla usuarios
            $usuarioExistente = Usuario::where('email', $user->email)->first();

            if (!$usuarioExistente) {
                // Crear un nuevo registro en la tabla usuarios
                Usuario::create([
                    'nombre' => $user->name,
                    'apellido' => '', // Completa si es necesario
                    'email' => $user->email,
                    'direccion' => $user->address,
                    'telefono' => $user->phone,
                    'tipo_usuario' => 'miembro',
                    'activo' => 1,
                ]);

                $this->info("Usuario {$user->email} migrado correctamente.");
            } else {
                $this->info("Usuario {$user->email} ya existe en la tabla usuarios.");
            }
        }

        return Command::SUCCESS;
    }
}
