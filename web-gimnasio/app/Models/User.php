<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Usuario;

/**
 * Clase User
 * 
 * Modelo para gestionar a los usuarios de la aplicación.
 * Almacena información básica de cada usuario.
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atributos asignables de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    /**
     * Atributos que deben estar ocultos para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser convertidos a tipos específicos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Evento que se ejecuta cuando se crea un nuevo usuario.
     * 
     * Crea automáticamente una entrada correspondiente en la tabla 'usuarios'.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            Usuario::create([
                'nombre' => $user->name,
                'apellido' => '',
                'email' => $user->email,
                'direccion' => $user->address,
                'telefono' => $user->phone,
                'tipo_usuario' => 'miembro',
                'activo' => 1,
            ]);
        });
    }

    /**
     * Relación con el modelo Usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_usuario', 'id');
    }
}