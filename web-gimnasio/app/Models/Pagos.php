<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_usuario', 'fecha_pago', 'cantidad', 'método_pago', 'estado_pago'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}

