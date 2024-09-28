<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Rutina
 * 
 * Modelo para representar las rutinas de ejercicios asignadas a los usuarios.
 * Contiene información sobre las rutinas y su relación con los ejercicios correspondientes.
 *
 * @package App\Models
 */
class Rutina extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'rutinas';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_rutina';

    /**
     * Atributos asignables de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_usuario',
        'nombre_rutina',
        'descripción',
        'fecha_inicio',
        'fecha_fin',
    ];

    /**
     * Relaciion con el modelo Ejercicio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'rutina_ejercicios', 'id_rutina', 'id_ejercicio')
            ->withPivot('dia_semana', 'repeticiones', 'series', 'minutos');
    }
}