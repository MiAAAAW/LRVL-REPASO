<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $table = 'habitaciones';
    protected $primaryKey = 'id_habitacion';

    protected $fillable = [
        'id_propietario',
        'titulo',
        'descripcion', 
        'ubicacion',
        'precio',
        'tipo_contrato',
        'estado'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_publicacion' => 'datetime',
    ];

    // Relaciones
    public function propietario()
    {
        return $this->belongsTo(User::class, 'id_propietario');
    }

    public function fotos()
    {
        return $this->hasMany(FotoHabitacion::class, 'id_habitacion');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_habitacion');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_habitacion');
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    public function scopeReservadas($query)
    {
        return $query->where('estado', 'reservada');
    }

    // Accessors
    public function getPrimeraFotoAttribute()
    {
        $primeraFoto = $this->fotos()->first();
        return $primeraFoto ? $primeraFoto->url_foto : '/images/placeholder.png';
    }

    public function getPromedioCalificacionAttribute()
    {
        return $this->calificaciones()->avg('puntaje') ?? 0;
    }

    public function getTotalCalificacionesAttribute()
    {
        return $this->calificaciones()->count();
    }

    // Métodos de utilidad
    public function estaDisponible()
    {
        return $this->estado === 'disponible';
    }

    public function estaReservada()
    {
        return $this->estado === 'reservada';
    }
}
