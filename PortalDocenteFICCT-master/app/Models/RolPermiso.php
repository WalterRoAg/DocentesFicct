<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    protected $table = 'rol_permisos';
    public $timestamps = false;

    // Eloquent no soporta PK compuesta; tratamos el pivot sin PK autoincremental.
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['rol_id','permiso_id','activo'];
}
