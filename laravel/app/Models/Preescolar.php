<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Preescolar extends Model
{


    protected $table = 'preescolar';
    protected $fillable = [ 'matricula_id','asignatura_id', 'periodo_id', 'logro_a', 'logro_b',
     'logro_c', 'logro_d', 'estado'];


    public function matricula()
    {
        return $this->belongsTo('App\Models\Matricula', 'matricula_id', );
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Models\Asignatura', 'asignatura_id', );
    }

    public function periodo()
    {
        return $this->belongsTo('App\Models\Periodo', 'periodo_id', );
    }

    public function carga()
    {
        return $this->belongsTo('App\Models\CargaAcademica', 'asignatura_id', );
    }


    public static function byPeriodo($grado, $asignatura, $periodo){
        return Preescolar::where('grado_id', $grado)->where('asignatura_id', $asignatura)
        ->where('periodo_id', $periodo)->get();
    }

    public static function calificacionesPeriodo($sede, $grado, $asignatura, $periodo){
        return DB::table('preescolar as p')
        ->join('matriculas as m', 'm.id', '=', 'p.matricula_id')
        ->join('estudiantes as e', 'e.id', '=', 'm.estudiante_id')
        ->join('asignaturas as a', 'a.id', '=', 'p.asignatura_id')
        ->join('grados as g', 'g.id', '=', 'm.grado_id')
        ->select('p.id', 'm.id as matricula_id', 'p.logro_a',
         'p.logro_b', 'p.logro_c', 'p.logro_d', 'e.apellidos', 'e.nombres',
         'a.nombre', 'g.descripcion')
        ->where('m.grado_id', $grado)
        ->where('p.asignatura_id', $asignatura)
        ->where('p.periodo_id', $periodo)
        ->where('m.sede_id', $sede)
        ->orderBy('e.apellidos', 'asc')
        ->get();
    }

    public static function calificacionesPeriodoAnterior($matricula, $asignatura, $periodo){
        $periodo--;
        return Db::table('preescolar')
        ->where('matricula_id', $matricula)
        ->where('asignatura_id', $asignatura)
        ->where('periodo_id', $periodo)->first(['logro_a', 'logro_b', 'logro_c', 'logro_c']);

    }

    public static function calificacionBoletin($matricula, $periodo){
        return Db::table('preescolar as p')
        ->join('asignaturas as a', 'a.id', '=', 'p.asignatura_id')
        ->join('carga_academicas as ca', 'ca.asignatura_id', '=', 'a.id')
        ->where('p.matricula_id', $matricula)
        ->select('a.nombre', 'ca.ihs', 'p.logro_a', 'p.logro_b', 'p.logro_c', 'p.logro_d' )
       ->where('p.periodo_id', $periodo)
       ->get();

    }






}
