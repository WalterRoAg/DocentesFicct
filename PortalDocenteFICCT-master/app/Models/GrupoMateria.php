<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoMateria extends Model
{
    protected $table = 'grupo_materias';
    public $timestamps = false;

    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['grupo_id','materia_sigla','activo'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_sigla', 'sigla');
    }
}
