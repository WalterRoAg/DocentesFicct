<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rols'; // quedó 'rols'
    protected $fillable = ['nombre'];

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'rol_permisos');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}
