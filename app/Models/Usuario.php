<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <—
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $fillable = ['nombre', 'correo', 'contrasena', 'activo', 'rol_id', 'persona_id'];
    protected $hidden = ['contrasena']; #, 'remember_token'
    public $timestamps = true;

    // Laravel necesita saber qué campo es el password:
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Usaremos "correo" para autenticarnos
    public function username()
    {
        return 'correo';
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // App/Models/Usuario.php
    public function canPermiso(string $permiso): bool
    {
        $rol = $this->rol;
        if (!$rol) return false;
        return $rol->permisos()->where('nombre', $permiso)->exists();
    }
}
