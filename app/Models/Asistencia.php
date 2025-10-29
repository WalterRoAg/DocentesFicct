<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    protected $fillable = ['fecha_hora','horario_clase_id'];

    public function horarioClase()
    {
        return $this->belongsTo(HorarioClase::class, 'horario_clase_id');
    }
}
