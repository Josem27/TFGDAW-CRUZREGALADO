<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Ejercicio
 * 
 * Modelo para representar los ejercicios de la base de datos.
 * Cada ejercicio está asociado a una rutina y contiene información.
 *
 * @package App\Models
 */
class Ejercicio extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'ejercicios';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_ejercicio';

    /**
     * Atributos asignables de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_rutina',
        'nombre_ejercicio',
        'repeticiones',
        'series',
        'categoria',
    ];

    /**
     * Relación con el modelo Rutina.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class, 'rutina_ejercicios', 'id_ejercicio', 'id_rutina')
            ->withPivot('dia_semana', 'repeticiones', 'series', 'minutos');
    }
}