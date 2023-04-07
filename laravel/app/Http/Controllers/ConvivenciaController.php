<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Convivencia;
use App\Models\Matricula;
use App\Models\Repositorio;
use Illuminate\Http\Request;



class ConvivenciaController extends Controller
{



    public function update(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $logros=$request->logros;
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        for($i=0; $i<count($logros); $i++){
            $cal=Convivencia::find($request->matriculas[$i]);
            $cal->logro=$request->logros[$i];
            $cal->save();
        }
        $dataArray=Convivencia::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
        $data=array(
            'data'=>$dataArray,
            'tipo'=>$tipo
        );
        return view('convivencia.detalles', compact('data', 'tipo'));

    }

    public function store(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        $arrayData=Convivencia::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
        if(count($arrayData)>0){
            return redirect()->route('convivencia.create')->with(['error'=>'YA EXISTEN DATOS PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO']);
        }else{
            $logros=$request->logros;
            for($i=0; $i<count($logros); $i++){
                $cal=new Convivencia();
                $cal->matricula_id=$request->matriculas[$i];
                $cal->asignatura_id=$asignatura;
                $cal->periodo_id=$periodo;
                $cal->logro=$request->logros[$i];
                $cal->save();
            }
            $arrayData=Convivencia::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
            $data=array(
                'data'=>$arrayData,
                'tipo'=>$tipo
            );
            return view('convivencia.detalles', compact('data', 'tipo'));
        }

    }


}
