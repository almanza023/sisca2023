<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaAcademica extends Model
{


    protected $table = 'carga_academicas';
    protected $fillable = ['sede_id', 'docente_id', 'grado_id', 'asignatura_id', 'ihs'];


    public function docente()
    {
        return $this->belongsTo('App\Models\Docente', 'docente_id');
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

    public static function filtro($sede, $grado, $docente)
    {
        if (!empty($sede) && !empty($grado) && !empty($docente)) {
            return CargaAcademica::where('docente_id', $docente)->where('grado_id', $grado)
                ->where('sede_id', $sede)->orderBy('grado_id', 'asc')->get();
        } else if (!empty($sede) && !empty($grado)) {
            return CargaAcademica::where('sede_id', $sede)->where('grado_id', $grado)
                ->orderBy('grado_id', 'asc')->get();
        } else if (!empty($sede) && !empty($docente)) {
            return CargaAcademica::where('sede_id', $sede)->where('docente_id', $docente)
                ->orderBy('grado_id', 'asc')->get();
        } else if (!empty($grado) && !empty($docente)) {
            return CargaAcademica::where('grado_id', $grado)->where('docente_id', $docente)
                ->orderBy('grado_id', 'asc')->get();
        } else if (!empty($sede)) {
            return CargaAcademica::where('sede_id', $sede)->orderBy('grado_id', 'asc')->get();
        } else if (!empty($grado)) {
            return CargaAcademica::where('grado_id', $grado)->where('grado_id', $grado)
                ->orderBy('grado_id', 'asc')->get();
        } else if (!empty($docente)) {
            return CargaAcademica::where('docente_id', $docente)
                ->orderBy('grado_id', 'asc')->get();
        }
    }

    public static function asignaturasDocente($docente, $grado){

        return CargaAcademica::where('docente_id', $docente)
        ->where('grado_id', $grado)->orderBy('grado_id', 'asc')->get();
    }

    public static function asignaturasGrado($grado, $sede){

        return CargaAcademica::where('sede_id', $sede)
        ->where('grado_id', $grado)->orderBy('grado_id', 'asc')->get();
    }

    public static function gradosDocente($docente, $sede){

        return CargaAcademica::where('docente_id', $docente)
        ->where('sede_id', $sede)
        ->groupBy('grado_id')->get('grado_id');
    }

    public static function validarAsignacion($sede, $docente, $grado, $asignatura){
        return CargaAcademica::where('docente_id', $docente)
        ->where('sede_id', $sede)
        ->where('grado_id', $grado)
        ->where('asignatura_id', $asignatura)
        ->get();
    }

    public static function getIhs($grado, $asignatura){
        return CargaAcademica::where('grado_id', $grado)
        ->where('asignatura_id', $asignatura)
        ->first();
    }

    public static function getDocente($sede, $grado, $asignatura){
        return CargaAcademica::where('sede_id', $sede)
        ->where('grado_id', $grado)
        ->where('asignatura_id', $asignatura)
        ->first();
    }






}
