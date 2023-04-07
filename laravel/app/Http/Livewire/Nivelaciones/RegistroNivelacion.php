<?php

namespace App\Http\Livewire\Nivelaciones;

use App\Models\AperturaPeriodo;
use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroAcademico;
use App\Models\Matricula;
use App\Models\Nivelacion;
use App\Models\Periodo;
use App\Models\Sede;
use App\Models\TipoLogro;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Request;

class RegistroNivelacion extends Component
{
    public  $matriculas='', $logrosAcademicos='', $logrosAfectivos='', $asignatura='', $asignatura_nombre, $asignatura_id, $grado, $sede, $periodo, $updateMode=false,
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
            $grados=CargaAcademica::gradosDocente($docente, $this->sede);
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

        return view('livewire.nivelaciones.registro', compact('sedes','grados','asignaturas', 'periodos'));
    }

    public function buscar(){

        $dataFecha='';
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

            $data=Calificacion::calificacionesPeriodo($this->sede, $this->grado, $this->asignatura_id, $this->periodo);
            if($this->tipo=='create'){
                if(count($data)==0){
                     session()->flash('error', 'NO EXISTEN CALIFICACIONES PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO');
                }else{
                    $this->matriculas=Calificacion::calificacionesBajo($this->sede, $this->grado, $this->asignatura_id, $this->periodo);
                }

            }else{
                if(count($data)==0){
                     session()->flash('error', 'NO EXISTEN CALIFICACIONES PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO');
                }else{
                    $this->matriculas=Nivelacion::nivelacionesPeriodo($this->sede, $this->grado, $this->asignatura_id, $this->periodo);;

                }
            }
                $this->total=count($this->matriculas);
                $this->logrosAcademicos=LogroAcademico::filtro($this->sede, $this->grado, $this->asignatura_id, $this->periodo, 2);
                $this->logrosAfectivos=LogroAcademico::filtro($this->sede, $this->grado, $this->asignatura_id, $this->periodo, 3);






    }

    public function seleccionar($id){

        $this->logCog=$id;

    }

    public function store(Request $request){
        dd($request);
    }


}
