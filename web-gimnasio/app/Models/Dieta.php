<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Dieta
 * 
 * Modelo para representar las dietas de los usuarios.
 * Almacena información sobre las dietas asignadas a los usuarios.
 *
 * @package App\Models
 */
class Dieta extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'dietas';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_dieta';
}