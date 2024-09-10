<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $table = 'ejercicios';
    protected $primaryKey = 'id_ejercicio';

    protected $fillable = [
        'id_rutina',
        'nombre_ejercicio',
        'repeticiones',
        'series',
        'categoria',
    ];

    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class, 'rutina_ejercicios', 'id_ejercicio', 'id_rutina')
            ->withPivot('dia_semana', 'repeticiones', 'series', 'minutos');
    }
}

