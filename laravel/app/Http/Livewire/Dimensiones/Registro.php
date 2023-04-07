<?php

namespace App\Http\Livewire\Dimensiones;

use App\Models\Preescolar;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroPreescolar;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Sede;
use Livewire\Component;
use Livewire\Request;

class Registro extends Component
{
    public  $matriculas='',  $logros='', $asignatura='', $asignatura_nombre, $asignatura_id, $grado, $sede, $periodo, $updateMode=false,
     $logro_id, $tipo, $total=0, $anteriores=[];


    public function mount($tipo)
    {
        $this->tipo=$tipo;
     }

    public function render()
    {
        $asignaturas=[];
        $cargas='';
        $sedes=[];
        $grados=[];
        $periodos=[];
        $docente=auth()->user()->usable_id;
        if(auth()->user()->tipo==1){
            $doc=Docente::find($docente);
            $this->sede=$doc->sede_id;
            $grados=CargaAcademica::gradosDocente($docente, $this->sede);
            $asignaturas=CargaAcademica::asignaturasDocente($docente, $this->grado);


        }else{
            $sedes=Sede::active();
            $grados=Grado::preescolarActive();
            $asignaturas=CargaAcademica::asignaturasGrado($this->grado, $this->sede);

        }
        $periodos=Periodo::active();
        if(empty($this->sede)){
            $this->matriculas='';
        }




        return view('livewire.dimensiones.registro', compact('sedes','grados','asignaturas', 'periodos'));
    }

    public function buscar(){
        $this->matriculas=[];
        $this->logrosAcademicos='';
        $this->logrosAfectivos='';

        $validated = $this->validate([
            'sede' => 'required',
            'asignatura' => 'required',
            'grado' => 'required',
            'periodo' => 'required',

        ]);
        if(!empty($this->asignatura)){
            $part = explode("-", $this->asignatura);
            $this->asignatura_nombre=$part[1];
            $this->asignatura_id=$part[0];
        }

            $data=Preescolar::calificacionesPeriodo($this->sede, $this->grado, $this->asignatura_id, $this->periodo);
            if($this->periodo>1 && $this->periodo<=4){
                $this->anteriores=Preescolar::calificacionesPeriodoAnterior($this->sede, $this->grado, $this->asignatura_id, $this->periodo);
            }
            if($this->tipo=='create'){
                if(count($data)>0){
                     session()->flash('error', 'YA EXISTEN REGISTROS PARA EL GRADO, DIMENSION Y PERIODO SELECCIONADO');
                }else{
                    $this->matriculas=Matricula::estudiantesCalificacion($this->sede, $this->grado);
                }

            }else{
                if(count($data)==0){
                     session()->flash('error', 'NO EXISTEN REGISTROS PARA EL GRADO, DIMENSION Y PERIODO SELECCIONADO');
                }else{
                    $this->matriculas=$data;

                }
            }
                $this->total=count($this->matriculas);
                $this->logros=LogroPreescolar::filtro($this->sede, $this->grado, $this->asignatura_id);

    }

    public function show($id){
        $this->matriculas=Matricula::estudiantesCalificacion($this->sede, $this->grado);
        if($this->tipo='create'){
            $cal=Preescolar::calificacionesPeriodoAnterior($id, $this->asignatura_id, $this->periodo);
            $data=array();
            foreach ($cal as $key => $value) {
                $logro=LogroPreescolar::find($value);
                $descripcion='';
                if(!empty($logro)){
                    $descripcion=$logro->descripcion;
                }
                $temp=array(
                    'codigo'=>$value,
                    'descripcion'=>$descripcion,
                );
                array_push($data, $temp);
            }
            $this->anteriores=$data;
        }
    }




}
