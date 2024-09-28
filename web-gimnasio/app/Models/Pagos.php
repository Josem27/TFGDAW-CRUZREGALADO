<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Pagos
 * 
 * Modelo para representar los pagos realizados por los usuarios.
 * Almacena información sobre cada pago.
 *
 * @package App\Models
 */
class Pagos extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'pagos';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_pago';

    /**
     * Atributos asignables de forma mayor.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_usuario',
        'fecha_pago',
        'cantidad',
        'método_pago',
        'estado_pago',
    ];

    /**
     * Relacion con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}