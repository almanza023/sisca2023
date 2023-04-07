<?php

namespace App\Http\Controllers;

use App\Models\Preescolar;
use App\Models\Matricula;
use App\Models\Repositorio;
use Illuminate\Http\Request;



class CalificacionDimensionesController extends Controller
{



    public function update(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        $logros1=$request->logros1;
        for($i=0; $i<count($logros1); $i++){
            $cal=Preescolar::find($request->matriculas[$i]);
            $cal->logro_a=$request->logros1[$i];
                $cal->logro_b=$request->logros2[$i];
                $cal->logro_c=$request->logros3[$i];
                $cal->logro_d=$request->logros4[$i];
            $cal->save();
        }
        $dataArray=Preescolar::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
        $data=array(
            'data'=>$dataArray,
            'tipo'=>$tipo
        );
        return view('dimensiones.detalles', compact('data', 'tipo'));

    }

    public function store(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        $arrayData=Preescolar::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
        if(count($arrayData)>0){
            return redirect()->route('dimensiones.create')->with(['error'=>'YA EXISTEN CALIFICACIONES PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO']);
        }else{

            $logros1=$request->logros1;
            for($i=0; $i<count($logros1); $i++){
                $cal=new Preescolar();
                $cal->matricula_id=$request->matriculas[$i];
                $cal->asignatura_id=$asignatura;
                $cal->periodo_id=$periodo;
                $cal->logro_a=$request->logros1[$i];
                $cal->logro_b=$request->logros2[$i];
                $cal->logro_c=$request->logros3[$i];
                $cal->logro_d=$request->logros4[$i];
                $cal->save();
            }
            $arrayData=Preescolar::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
            $data=array(
                'data'=>$arrayData,
                'tipo'=>$tipo
            );
            return view('dimensiones.detalles', compact('data', 'tipo'));
        }


    }

    public function detalles($grado, $asignatira, $periodo){

    }
}
