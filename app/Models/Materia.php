<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';
    protected $primaryKey = 'sigla';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['sigla','nombre','nivel'];

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_materias', 'materia_sigla', 'grupo_id')
                    ->withPivot('activo');
    }
    

    public function getRouteKeyName()
    {
        return 'sigla'; // {materia} por sigla
    }

    public function horarioClases()
    {
        return $this->hasMany(HorarioClase::class, 'materia_sigla', 'sigla');
    }

    // Helper: grupo "principal" (el activo si existe)
    public function grupoActivo()
    {
        return $this->grupos()->wherePivot('activo', true)->first();
    }
}
