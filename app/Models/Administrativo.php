<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    protected $table = 'administrativos';
    protected $primaryKey = 'persona_id';
    public $incrementing = false;
    protected $fillable = ['persona_id','cargo'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
