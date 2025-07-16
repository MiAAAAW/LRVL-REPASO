<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
        'tipo_usuario',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Accesor para mantener compatibilidad con Laravel Auth
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    // Laravel Auth necesita estos métodos
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    public function getAuthIdentifierName()
    {
        return 'id_usuario';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    // Relaciones
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class, 'id_propietario');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_estudiante');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_estudiante');
    }

    // Scopes
    public function scopeEstudiantes($query)
    {
        return $query->where('tipo_usuario', 'estudiante');
    }

    public function scopePropietarios($query)
    {
        return $query->where('tipo_usuario', 'propietario');
    }

    // Métodos de utilidad
    public function esEstudiante()
    {
        return $this->tipo_usuario === 'estudiante';
    }

    public function esPropietario()
    {
        return $this->tipo_usuario === 'propietario';
    }
}
