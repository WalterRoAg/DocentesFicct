<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $table = 'aulas';
protected $fillable = ['numero', 'piso', 'capacidad', 'activo' /*si lo manejas */];

}
