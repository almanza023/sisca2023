<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Convivencia extends Model
{
    protected $table = 'convivencia';
    protected $fillable = [ 'matricula_id','asignatura_id', 'periodo_id', 'logro',  'estado'];


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

    public function logro()
    {
        return $this->belongsTo('App\Models\LogroDisciplinario', 'logro', );
    }



    public static function byPeriodo($grado, $asignatura, $periodo){
        return Convivencia::where('grado_id', $grado)->where('asignatura_id', $asignatura)
        ->where('periodo_id', $periodo)->get();
    }

    public static function calificacionesPeriodo($sede, $grado, $asignatura, $periodo){
        return DB::table('convivencia as c')
        ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
        ->join('estudiantes as e', 'e.id', '=', 'm.estudiante_id')
        ->join('asignaturas as a', 'a.id', '=', 'c.asignatura_id')
        ->join('grados as g', 'g.id', '=', 'm.grado_id')
        ->select('c.id', 'm.id as matricula_id', 'c.logro',  'e.apellidos', 'e.nombres',
         'a.nombre', 'g.descripcion')
        ->where('m.grado_id', $grado)
        ->where('c.asignatura_id', $asignatura)
        ->where('c.periodo_id', $periodo)
        ->where('m.sede_id', $sede)
        ->orderBy('e.apellidos', 'asc')
        ->get();
    }

    public static function reportConvivencia($matricula, $periodo){


        return Convivencia::where('matricula_id', $matricula)
            ->where('periodo_id', $periodo)
            ->first();

     }

     public static function byMatriculaPeriodo($matricula, $periodo){
        return Convivencia::where('matricula_id', $matricula)
        ->where('periodo_id', $periodo)->first();
    }




}
