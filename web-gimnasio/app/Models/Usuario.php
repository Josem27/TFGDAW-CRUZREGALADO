<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Usuario
 * 
 * Modelo para representar a los usuarios extendidos en la aplicación.
 * Contiene información detallada de cada usuario.
 *
 * @package App\Models
 */
class Usuario extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Atributos asignables de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'direccion',
        'telefono',
        'tipo_usuario',
        'activo',
        'foto',
    ];

    /**
     * Indicador de timestamps automáticos.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Relación con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}