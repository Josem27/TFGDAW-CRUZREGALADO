<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    use HasFactory;

    protected $table = 'rutinas';
    protected $primaryKey = 'id_rutina';

    protected $fillable = [
        'id_usuario',
        'nombre_rutina',
        'descripción',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'rutina_ejercicios', 'id_rutina', 'id_ejercicio')
            ->withPivot('dia_semana', 'repeticiones', 'series', 'minutos');
    }
}

