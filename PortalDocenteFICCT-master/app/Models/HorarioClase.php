<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioClase extends Model
{
    protected $table = 'horario_clases';
    protected $fillable = [
        'horario_id','aula_id',
        'grupo_materia_grupo_id','grupo_materia_materia_sigla'
    ];

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }

    // Como Eloquent no maneja FK compuesta nativa, exponemos cada relación por separado:
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_materia_grupo_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'grupo_materia_materia_sigla', 'sigla');
    }
}
