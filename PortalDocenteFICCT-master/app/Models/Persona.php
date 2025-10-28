<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['carnet','nombre','telefono'];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'persona_id');
    }

    public function docente()
    {
        return $this->hasOne(Docente::class, 'persona_id');
    }

    public function administrativo()
    {
        return $this->hasOne(Administrativo::class, 'persona_id');
    }

    public function profesiones()
    {
        return $this->belongsToMany(Profesion::class, 'profesion_personas')
                    ->withPivot('nivel');
    }
}

