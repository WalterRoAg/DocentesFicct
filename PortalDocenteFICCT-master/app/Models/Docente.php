<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';
    protected $primaryKey = 'persona_id';
    public $incrementing = false;
    protected $fillable = ['persona_id','anios_experiencia','fecha_ingreso','activo'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
