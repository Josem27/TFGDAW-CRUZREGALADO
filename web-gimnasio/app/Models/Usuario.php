<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre', 'apellido', 'email', 'direccion', 'telefono', 'tipo_usuario', 'activo', 'foto',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
