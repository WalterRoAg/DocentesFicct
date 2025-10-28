<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfesionPersona extends Model
{
    protected $table = 'profesion_personas';
    public $timestamps = false;

    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['persona_id','profesion_id','nivel'];
}
