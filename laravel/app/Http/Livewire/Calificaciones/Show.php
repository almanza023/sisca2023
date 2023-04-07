<?php

namespace App\Http\Livewire\Calificaciones;

use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroAcademico;
use App\Models\Periodo;
use App\Models\Sede;
use Livewire\Component;

class Show extends Component
{
    public $calificaciones=[], $logrosAcademicos=[], $logrosAfectivos=[], $asignatura='', $asignatura_nombre, $asignatura_id, $grado='', $sede='', $periodo='', $updateMode=false,
    $total=0;

    public function render()
    {

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
        return view('livewire.calificaciones.show', compact('sedes','grados','asignaturas', 'periodos'));
    }

    public function buscar(){
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
            $calificaciones=Calificacion::calificacionesPeriodo($this->sede, $this->grado, $this->asignatura_id, $this->periodo);

            if(count($calificaciones)>0){
                $this->calificaciones=array(
                    'data'=>$calificaciones,
                    'tipo'=>'create'
                );
            }else{
                session()->flash('error', 'NO EXISTEN CALIFICACIONES PARA EL GRADO, ASIGNATURA Y PERIODO SELECCIONADO');
                $this->calificaciones=[];

            }
            $this->total=count($this->calificaciones);
        }




    }


}
