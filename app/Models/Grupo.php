<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $fillable = ['nombre','activo'];
    protected $casts = ['activo'=>'boolean'];


    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'grupo_materias', 'grupo_id', 'materia_sigla')
                    ->withPivot('activo');
    }
    
}
