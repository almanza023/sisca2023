<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Calificacion extends Model
{


    protected $table = 'calificaciones';
    protected $fillable = [ 'matricula_id','asignatura_id', 'periodo_id', 'logro_cognitivo', 'logro_afectivo',
     'nota', 'orden', 'estado'];


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

    public function logroCognitivo()
    {
        return $this->belongsTo('App\Models\LogroAcademico', 'logro_cognitivo', );
    }

    public function logroAfectivo()
    {
        return $this->belongsTo('App\Models\LogroAcademico', 'logro_afectivo', );
    }


    public function setNotaAttribute($value)
    {
        $this->attributes['nota'] = number_format($value, 2);
    }

    public static function byPeriodo($grado, $asignatura, $periodo){
        return Calificacion::where('grado_id', $grado)->where('asignatura_id', $asignatura)
        ->where('periodo_id', $periodo)->get();
    }

    public static function notaAnteriorEst($matricula, $asignatura, $periodo){

        $cal=Calificacion::where('matricula_id', $matricula)->where('asignatura_id', $asignatura)
        ->where('periodo_id', $periodo)->first();
        if(!empty($cal) && $cal->nota<3){
            $niv=Nivelacion::getNivelacion($matricula, $asignatura, $periodo);
            if(empty($niv)){
                return $cal;
            }else{
                return $niv;
            }
        }else{
            return $cal;
        }

    }

    public static function calificacionesPeriodo($sede, $grado, $asignatura, $periodo){
        return DB::table('calificaciones as c')
        ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
        ->join('estudiantes as e', 'e.id', '=', 'm.estudiante_id')
        ->join('asignaturas as a', 'a.id', '=', 'c.asignatura_id')
        ->join('grados as g', 'g.id', '=', 'm.grado_id')
        ->select('c.id', 'm.id as matricula_id', 'c.nota',
         'c.logro_cognitivo', 'c.logro_afectivo', 'e.apellidos', 'e.nombres',
         'a.nombre', 'g.descripcion', 'c.created_at')
        ->where('m.grado_id', $grado)
        ->where('c.asignatura_id', $asignatura)
        ->where('c.periodo_id', $periodo)
        ->where('m.sede_id', $sede)
        ->orderBy('e.apellidos', 'asc')
        ->get();
    }

    public static function calificacionesBajo($sede, $grado, $asignatura, $periodo){
        return DB::table('calificaciones as c')
        ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
        ->join('estudiantes as e', 'e.id', '=', 'm.estudiante_id')
        ->join('asignaturas as a', 'a.id', '=', 'c.asignatura_id')
        ->join('grados as g', 'g.id', '=', 'm.grado_id')
        ->select('m.id', 'c.nota',
         'e.apellidos', 'e.nombres', 'a.nombre', 'g.descripcion')
        ->where('m.grado_id', $grado)
        ->where('c.asignatura_id', $asignatura)
        ->where('c.periodo_id', $periodo)
        ->where('m.sede_id', $sede)
        ->where('c.nota', '<', '3')
        ->orderBy('e.apellidos', 'asc')
        ->get();
    }

    public static function calificacionesPeriodoAnterior($sede, $grado, $asignatura, $periodo){
       $periodo=$periodo-1;
       $calificaciones=[];
        $calif= DB::table('calificaciones as c')
        ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
        ->where('m.sede_id', $sede)
        ->where('m.grado_id', $grado)
        ->where('c.asignatura_id', $asignatura)
        ->where('c.periodo_id', $periodo)->get(['c.matricula_id', 'c.nota']);
        foreach ($calif as $cal) {
           $niv=Nivelacion::getNivelacion($cal->matricula_id, $asignatura, $periodo);
           if(empty($niv)){
            $temp=[
                'matricula_id'=>$cal->matricula_id,
                'nota'=>$cal->nota
            ];
           }else{
            $temp=[
                'matricula_id'=>$cal->matricula_id,
                'nota'=>$niv->nota
            ];
           }
           array_push($calificaciones, $temp);

        }
        return collect($calificaciones);
    }

    public static function matriculaAsignatura($matricula, $asignatura, $periodo){
        return DB::table('calificaciones')
        ->where('matricula_id', $matricula)
        ->where('asignatura_id', $asignatura)
        ->where('periodo_id', $periodo)->get(['c.matricula_id', 'c.nota']);
    }

    public static function reportCalificaciones($matricula, $periodo, $ordenI, $ordenF){

        if(empty($ordenF)){
            return Calificacion::where('matricula_id', $matricula)
            ->where('periodo_id', $periodo)
            ->where('orden','>=', $ordenI)
            ->orderBy('orden', 'asc')
            ->get();
        }else{
            return Calificacion::where('matricula_id', $matricula)
            ->where('matricula_id', $matricula)
            ->where('periodo_id', $periodo)
            ->where('orden','>=', $ordenI)
            ->where('orden','<=', $ordenF)
            ->orderBy('orden', 'asc')
            ->get();
        }
     }

     public static function matriculaCalificaciones($matricula, $periodo){
        return Calificacion::where('matricula_id', $matricula)
        ->where('periodo_id', $periodo)->get();
    }

    public static function asignaturaCalificacion($grado, $periodo, $orden1, $orden2){
        return DB::table('calificaciones as c')
        ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
        ->join('asignaturas as a', 'a.id', '=', 'c.asignatura_id')
          ->join('carga_academicas as ca', 'a.id', '=', 'ca.asignatura_id')
        ->where('m.grado_id', $grado)
        ->where('c.periodo_id', $periodo)
        ->where('c.orden', '>', $orden1)
        ->where('c.orden', '<', $orden2)
        ->select('a.acronimo', 'ca.porcentaje' )

        ->groupBy('a.acronimo')
        ->orderBy('c.orden', 'asc')
        ->get();
    }

    public static function codigoAsignatura($grado, $periodo){
        return DB::table('calificaciones as c')
        ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
        ->join('asignaturas as a', 'a.id', '=', 'c.asignatura_id')
        ->where('m.grado_id', $grado)
        ->where('c.periodo_id', $periodo)
        ->select('a.id', )
        ->orderBy('c.orden', 'asc')
        ->distinct()
        ->get();
    }

    public static function calificacionOrden($matricula, $periodo, $orden1, $orden2){
        return Calificacion::where('matricula_id', $matricula)
        ->where('periodo_id', $periodo)
        ->where('orden','>', $orden1)
        ->where('orden','<', $orden2)
        ->orderBy('orden', 'asc')
        ->get();
    }

    public static function calificacionesFinales($sede, $grado, $asignatura){
        $calificaciones=[];

         $calif= DB::table('calificaciones as c')
         ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
         ->join('estudiantes as es', 'es.id', '=', 'm.estudiante_id')
         ->where('m.sede_id', $sede)
         ->where('m.grado_id', $grado)
         ->where('c.asignatura_id', $asignatura)
         ->where('c.periodo_id', 4)
         ->select('c.matricula_id', 'c.asignatura_id', 'c.nota', 'es.nombres', 'es.apellidos')
         ->get();
         foreach ($calif as $cal) {
            $p1=0;
            $p2=0;
            $p3=0;
            $p4=0;
            $periodo1=Calificacion::notaAnteriorEst($cal->matricula_id, $cal->asignatura_id, 1);
            if(!empty($periodo1)){
                $p1=$periodo1->nota;
            }
            $periodo2=Calificacion::notaAnteriorEst($cal->matricula_id, $cal->asignatura_id, 2);
            if(!empty($periodo2)){
                $p2=$periodo2->nota;
            }
            $periodo3=Calificacion::notaAnteriorEst($cal->matricula_id, $cal->asignatura_id, 3);
            if(!empty($periodo3)){
                $p3=$periodo3->nota;
            }
            if(!empty($cal)){
                $p4=$cal->nota;
            }
            $nivFinal=Nivelacion::getNivelacion($cal->matricula_id, $cal->asignatura_id, 5);
            if(!empty($nivFinal)){
                $notaNiv=$nivFinal->nota;
            }else{
                $notaNiv='';
            }

            $promedio=round(($p1+$p2+$p3+$p4)/4, 1);

             $temp=[
                 'matricula_id'=>$cal->matricula_id,
                 'estudiante'=>$cal->apellidos.' '.$cal->nombres,
                 'periodo1'=>$p1,
                 'periodo2'=>$p2,
                 'periodo3'=>$p3,
                 'periodo4'=>$p4,
                 'promedio'=>$promedio,
                 'nivelacion'=>$notaNiv,
             ];
            array_push($calificaciones, $temp);

         }
         return ($calificaciones);
     }

     public static function notasFinalesEstudiante($matricula, $asignatura){
        $calificaciones=[];
         $calif= DB::table('calificaciones as c')
         ->join('matriculas as m', 'm.id', '=', 'c.matricula_id')
         ->join('estudiantes as es', 'es.id', '=', 'm.estudiante_id')
         ->where('c.matricula_id', $matricula)
         ->where('c.asignatura_id', $asignatura)
         ->where('c.periodo_id', 4)
         ->select('c.matricula_id', 'c.asignatura_id', 'c.nota')
         ->get();
         foreach ($calif as $cal) {

            $periodo1=Calificacion::notaAnteriorEst($cal->matricula_id, $cal->asignatura_id, 1);
            $periodo2=Calificacion::notaAnteriorEst($cal->matricula_id, $cal->asignatura_id, 1);
            $periodo3=Calificacion::notaAnteriorEst($cal->matricula_id, $cal->asignatura_id, 1);
            $nivFinal=Nivelacion::getNivelacion($cal->matricula_id, $cal->asignatura_id, 5);
            if(!empty($nivFinal)){
                $notaNiv=$nivFinal->nota;
            }else{
                $notaNiv='';
            }

            $promedio=round(($periodo1->nota+$periodo2->nota+$periodo3->nota+$cal->nota)/4, 1);

             $temp=[
                 'matricula_id'=>$cal->matricula_id,
                 'periodo1'=>$periodo1->nota,
                 'periodo2'=>$periodo2->nota,
                 'periodo3'=>$periodo3->nota,
                 'periodo4'=>$cal->nota,
                 'promedio'=>$promedio,
                 'nivelacion'=>$notaNiv,
             ];
            array_push($calificaciones, $temp);

         }
         return ($calificaciones);
     }









}
