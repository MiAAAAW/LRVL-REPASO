<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'id_estudiante',
        'id_habitacion',
        'fecha_inicio',
        'fecha_fin',
        'precio_total',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'precio_total' => 'decimal:2',
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

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmada');
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('estado', 'finalizada');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('estado', 'cancelada');
    }

    // Accessors
    public function getDuracionDiasAttribute()
    {
        return $this->fecha_inicio->diffInDays($this->fecha_fin) + 1;
    }

    public function getEstaActivaAttribute()
    {
        return $this->estado === 'confirmada' && 
               Carbon::now()->between($this->fecha_inicio, $this->fecha_fin);
    }

    public function getProgresoPorcentajeAttribute()
    {
        if ($this->estado !== 'confirmada') {
            return 100;
        }

        $hoy = Carbon::now();
        $totalDias = $this->duracion_dias;
        $diasTranscurridos = min($this->fecha_inicio->diffInDays($hoy) + 1, $totalDias);
        
        return round(($diasTranscurridos / $totalDias) * 100);
    }

    // Métodos de utilidad
    public function estaPendiente()
    {
        return $this->estado === 'pendiente';
    }

    public function estaConfirmada()
    {
        return $this->estado === 'confirmada';
    }

    public function estaFinalizada()
    {
        return $this->estado === 'finalizada';
    }

    public function estaCancelada()
    {
        return $this->estado === 'cancelada';
    }
}
