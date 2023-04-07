<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogroAcademico extends Model
{


    protected $table = 'logro_academicos';
    protected $fillable = ['sede_id', 'grado_id', 'asignatura_id', 'periodo_id', 'tipo_logro_id', 'descripcion'];

    public function tipo()
    {
        return $this->belongsTo('App\Models\TipoLogro', 'tipo_logro_id');
    }

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

    public static function filtro($sede, $grado, $asignatura, $periodo, $tipo){

        return LogroAcademico::where('asignatura_id', $asignatura)
        ->where('grado_id', $grado)
        ->where('sede_id', $sede)
        ->where('periodo_id', $periodo)
        ->where('tipo_logro_id', $tipo)
        ->orderBy('periodo_id', 'asc')->get();
    }
    
    public static function filtro2($sede, $grado, $asignatura, $periodo, $tipo){

        return LogroAcademico::where('asignatura_id', $asignatura)
        ->where('grado_id', $grado)
        ->where('sede_id', $sede)
        ->where('periodo_id', $periodo)
        ->where('tipo_logro_id', $tipo)
        ->orderBy('periodo_id', 'asc')->first();
    }


    public static function bySedeGrado($sede, $grado, $asignatura, $periodo, $tipo){

        return LogroAcademico::where('asignatura_id', $asignatura)
        ->where('grado_id', $grado)
        ->where('sede_id', $sede)
        ->where('periodo_id', $periodo)
        ->where('tipo_logro_id', $tipo)
        ->orderBy('periodo_id', 'asc')->first();
    }


}
