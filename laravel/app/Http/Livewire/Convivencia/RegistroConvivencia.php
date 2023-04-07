<?php

namespace App\Http\Livewire\Convivencia;

use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Convivencia;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroAcademico;
use App\Models\LogroDisciplinario;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Sede;
use App\Models\TipoLogro;
use App\Models\DireccionGrado;
use Livewire\Component;
use Livewire\Request;

class RegistroConvivencia extends Component
{
    public  $matriculas='', $logros='',  $asignatura='', $asignatura_nombre, $asignatura_id, $grado, $sede, $periodo, $updateMode=false,
     $logro_id, $logCog, $tipo, $total=0, $anteriores=[];


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
            $grados=DireccionGrado::getByDocente($docente);
            $asignaturas=CargaAcademica::asignaturasDocente($docente, $this->grado);

        }else{
            $sedes=Sede::active();
            $grados=Grado::secundariosActive();
            $asignaturas=CargaAcademica::asignaturasGrado($this->grado, $this->sede);

        }
        $periodos=Periodo::active();
        if(empty($this->sede)){
            $this->matriculas='';
        }

        return view('livewire.convivencia.registro', compact('sedes','grados','asignaturas', 'periodos'));
    }

    public function buscar(){

        $this->logrosAcademicos='';
        $this->logrosAfectivos='';
        $this->matriculas=[];
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

            $data=Convivencia::calificacionesPeriodo($this->sede, $this->grado, $this->asignatura_id, $this->periodo);
            if($this->periodo>1 && $this->periodo<=4){
               // $this->anteriores=Convivencia::calificacionesPeriodoAnterior($this->sede, $this->grado, $this->asignatura_id, $this->periodo);
            }
            if($this->tipo=='create'){
                if(count($data)>0){
                     session()->flash('error', 'YA EXISTEN DATOS PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO');
                }else{
                    $this->matriculas=Matricula::estudiantesCalificacion($this->sede, $this->grado);
                }

            }else{
                if(count($data)==0){
                     session()->flash('error', 'NO EXISTEN DATOS PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO');
                }else{
                    $this->matriculas=$data;

                }
            }
                $this->total=count($this->matriculas);
                $this->logros=LogroDisciplinario::filtro($this->sede, $this->grado, $this->asignatura_id, $this->periodo);






    }

    public function seleccionar($id){

        $this->logCog=$id;

    }

    public function store(Request $request){
        dd($request);
    }


}
