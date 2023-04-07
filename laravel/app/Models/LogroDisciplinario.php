<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogroDisciplinario extends Model
{
    protected $table = 'logros_disciplinarios';
    protected $fillable = ['sede_id', 'grado_id', 'asignatura_id', 'periodo_id', 'descripcion'];



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

    public function periodo()
    {
        return $this->belongsTo('App\Models\Periodo', 'periodo_id');
    }

    public static function filtro($sede, $grado, $asignatura, $periodo){

        return LogroDisciplinario::where('asignatura_id', $asignatura)
        ->where('grado_id', $grado)
        ->where('sede_id', $sede)
        ->where('periodo_id', $periodo)
        ->orderBy('periodo_id', 'asc')->get();
    }
}
