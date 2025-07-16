<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoHabitacion extends Model
{
    use HasFactory;

    protected $table = 'fotos_habitacion';
    protected $primaryKey = 'id_foto';

    protected $fillable = [
        'id_habitacion',
        'url_foto',
        'descripcion'
    ];

    // Relaciones
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion');
    }
}
