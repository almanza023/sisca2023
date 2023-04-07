<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\LogroAcademico;
use App\Models\Matricula;
use App\Models\PromedioAsignatura;
use App\Models\Repositorio;
use Illuminate\Http\Request;



class CalificacionController extends Controller
{



    public function update(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $notas=$request->notas;
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        $perdidos=0;
        $ganados=0;
        $total=count($notas);
        $suma=0;
        $orden=Repositorio::orden($asignatura, $request->grado);
        for($i=0; $i<count($notas); $i++){
            if($notas[$i]<3){
                $perdidos++;
            }else{
                $ganados++;
            }
            $suma=$suma+$notas[$i];
            $cal=Calificacion::find($request->matriculas[$i]);
            $cal->logro_cognitivo=$request->logroCog;
            $cal->logro_afectivo=$request->logroAfe[$i];
            $cal->nota=$notas[$i];
            $cal->orden=$orden;
            $cal->save();
        }
        $prom=$suma/$total;
        $promedio=PromedioAsignatura::updateOrCreate(
            [
                'sede_id'=>$sede,
                'asignatura_id'=>$asignatura,
                'grado_id'=>$grado,
                'periodo_id'=>$periodo,
            ],
            [
            'sede_id'=>$sede,
            'asignatura_id'=>$asignatura,
            'grado_id'=>$grado,
            'periodo_id'=>$periodo,
            'valor'=>number_format($prom, 1),
            'ganados'=>$ganados,
            'perdidos'=>$perdidos,
            ]
        );
        $dataArray=Calificacion::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
        $data=array(
            'data'=>$dataArray,
            'tipo'=>$tipo
        );
        return view('calificaciones.detalles', compact('data', 'tipo'));

    }

    public function store(Request $request){

        $part = explode("-", $request->asignatura);
        $asignatura=$part[0];
        $sede=$request->sede;
        $grado=$request->grado;
        $periodo=$request->periodo;
        $tipo=$request->tipo;
        $arrayData=Calificacion::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
        if(count($arrayData)>0){
            return redirect()->route('calificaciones.create')->with(['error'=>'YA EXISTEN CALIFICACIONES PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO']);
        }else{
            $orden=Repositorio::orden($asignatura, $request->grado);
            $notas=$request->notas;
            $perdidos=0;
            $ganados=0;
            $total=count($notas);
            $suma=0;
            for($i=0; $i<count($notas); $i++){
                if($notas[$i]<3){
                    $perdidos++;
                }else{
                    $ganados++;
                }
                $suma=$suma+$notas[$i];
                $cal=new Calificacion();
                $cal->matricula_id=$request->matriculas[$i];
                $cal->asignatura_id=$asignatura;
                $cal->periodo_id=$periodo;
                $cal->logro_cognitivo=$request->logroCog;
                $cal->logro_afectivo=$request->logroAfe[$i];
                $cal->nota=$notas[$i];
                $cal->orden=$orden;
                $cal->save();
            }
            $prom=$suma/$total;
            $promedio=PromedioAsignatura::updateOrCreate(
                [
                    'sede_id'=>$sede,
                    'asignatura_id'=>$asignatura,
                    'grado_id'=>$grado,
                    'periodo_id'=>$periodo,
                ],
                [
                'sede_id'=>$sede,
                'asignatura_id'=>$asignatura,
                'grado_id'=>$grado,
                'periodo_id'=>$periodo,
                'valor'=>number_format($prom, 1),
                'ganados'=>$ganados,
                'perdidos'=>$perdidos,
                ]
            );
            $arrayData=Calificacion::calificacionesPeriodo($sede, $grado, $asignatura, $periodo);
            $data=array(
                'data'=>$arrayData,
                'tipo'=>$tipo,
                'sede'=>$sede,
                'asignatura'=>$request->asignatura,
                'grado'=>$grado,
                'periodo'=>$periodo,
            );
            return view('calificaciones.detalles', compact('data', 'tipo'));
        }


    }

    public function detalles($grado, $asignatira, $periodo){

    }

    public function individual(Request $request){

        $obj = json_decode($request->matricula);
        $matricula=$obj->{'id'};
        $sede=$obj->{'sede_id'};
        $grado=$obj->{'grado_id'};
        $periodo=$request->periodo;
        $asignaturas=$request->asignaturas;

            $notas=$request->notas;
            for($i=0; $i<count($asignaturas); $i++){
                $orden=Repositorio::orden($asignaturas[$i], $grado);
                $logroCog=LogroAcademico::filtro2($sede, $grado, $asignaturas[$i], $periodo, 2);
                if(empty($logroCog)){
                    $cog=0;
                }else{
                    $cog=$logroCog->id;
                }
                $logroAfe=LogroAcademico::filtro2($sede, $grado, $asignaturas[$i], $periodo, 3);
                if(empty($logroAfe)){
                    $afe=0;
                }else{
                    $afe=$logroAfe->id;
                }

                $cal=Calificacion::updateOrCreate([
                    'matricula_id'=>$matricula,
                    'periodo_id'=>$periodo,
                    'asignatura_id'=>$asignaturas[$i],
                ],
                [
                'matricula_id'=>$matricula,
                'asignatura_id'=>$asignaturas[$i],
                'periodo_id'=>$periodo,
                'logro_cognitivo'=>$cog,
                'logro_afectivo'=>$afe,
                'nota'=>$notas[$i],
                'orden'=>$orden]);

            }
            return redirect()->route('calificaciones-estudiantes');
        }


    }

