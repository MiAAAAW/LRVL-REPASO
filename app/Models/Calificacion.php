<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';
    protected $primaryKey = 'id_calificacion';

    protected $fillable = [
        'id_estudiante',
        'id_habitacion',
        'puntaje',
        'comentario'
    ];

    protected $casts = [
        'puntaje' => 'integer',
        'fecha' => 'datetime',
    ];

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(User::class, 'id_estudiante');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion');
    }

    // Accessors
    public function getEstrellasAttribute()
    {
        return str_repeat('★', $this->puntaje) . str_repeat('☆', 5 - $this->puntaje);
    }

    // Scopes
    public function scopePorPuntaje($query, $puntaje)
    {
        return $query->where('puntaje', $puntaje);
    }

    public function scopeExcelentes($query)
    {
        return $query->where('puntaje', '>=', 4);
    }

    public function scopeBuenas($query)
    {
        return $query->where('puntaje', '>=', 3);
    }
}
