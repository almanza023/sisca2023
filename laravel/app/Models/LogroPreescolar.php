<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogroPreescolar extends Model
{


    protected $table = 'logros_preescolar';
    protected $fillable = ['sede_id', 'grado_id', 'asignatura_id', 'descripcion', 'tipo','estado'];


    public function grado()
    {
        return $this->belongsTo('App\Models\Grado', 'grado_id');
    }

    public function sede()
    {
        return $this->belongsTo('App\Models\Sede', 'sede_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Models\Asignatura', 'asignatura_id');
    }

    public static function filtro($sede, $grado, $asignatura){

        return LogroPreescolar::where('asignatura_id', $asignatura)
        ->where('grado_id', $grado)
        ->where('sede_id', $sede)
        ->orderBy('tipo', 'asc')->get();
    }

}
