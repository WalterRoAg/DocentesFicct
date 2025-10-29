<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    protected $table = 'profesions'; // quedó 'profesions'
    protected $fillable = ['nombre'];

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'profesion_personas')
                    ->withPivot('nivel');
    }
}
