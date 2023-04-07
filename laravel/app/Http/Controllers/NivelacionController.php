<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Matricula;
use App\Models\Nivelacion;
use App\Models\Repositorio;
use Illuminate\Http\Request;



class NivelacionController extends Controller
{



    public function update(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $notas=$request->notas;
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        for($i=0; $i<count($notas); $i++){
            $cal=Nivelacion::find($request->matriculas[$i]);
            $cal->nota=$notas[$i];
            $cal->save();
        }
        $dataArray=Nivelacion::nivelacionesPeriodo($sede, $grado, $asignatura, $periodo);
        $data=array(
            'data'=>$dataArray,
            'tipo'=>$tipo
        );
        return view('nivelaciones.detalles', compact('data', 'tipo'));

    }

    public function store(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        $arrayData=Nivelacion::nivelacionesPeriodo($sede, $grado, $asignatura, $periodo);
        if(count($arrayData)>0){
            return redirect()->route('nivelaciones.create')->with(['error'=>'YA EXISTEN NIVELACIONES PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO']);
        }else{
            $notas=$request->notas;
            for($i=0; $i<count($notas); $i++){
                $cal=new Nivelacion();
                $cal->matricula_id=$request->matriculas[$i];
                $cal->asignatura_id=$asignatura;
                $cal->periodo_id=$periodo;
                $cal->nota=$notas[$i];
                $cal->save();
            }
            $arrayData=Nivelacion::nivelacionesPeriodo($sede, $grado, $asignatura, $periodo);
            $data=array(
                'data'=>$arrayData,
                'tipo'=>$tipo
            );
            return view('nivelaciones.detalles', compact('data', 'tipo'));
        }


    }


}
