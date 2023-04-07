<?php

namespace App\Http\Livewire\NivelacionesFinales;

use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Nivelacion;
use App\Models\Sede;
use Livewire\Component;

class NivelacionesFinales extends Component
{
    public  $matriculas=[], $logros='', $grado, $sede, $asignatura, $updateMode=false,
    $logro_id, $notas1=[], $matriculas1=[];
   public function render()
   {

       $sedes=[];
       $grados=[];
       $asignaturas=[];
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
       if(empty($this->sede)){
           $this->matriculas='';
       }

       return view('livewire.nivelaciones-finales.nivelaciones-finales', compact('sedes','grados', 'asignaturas'));
   }

   public function buscar(){



    $validated = $this->validate([
        'sede' => 'required',
        'asignatura' => 'required',
        'grado' => 'required',
    ]);
    $this->matriculas=Calificacion::calificacionesFinales($this->sede, $this->grado, $this->asignatura);
    if(empty($this->matriculas)){
        session()->flash('message', 'PRIMERO DEBE INGRESAR LA NOTA DEL CUARTO PERIODO.');
    }
}

    public function store(){

        foreach ($this->notas1 as $key => $value) {


                Nivelacion::updateOrCreate(
                    [
                        'matricula_id' =>  ($this->matriculas[$key]['matricula_id']),
                        'periodo_id' =>  (5)

                   ],
                    [
                        'matricula_id' =>  ($this->matriculas[$key]['matricula_id']),
                        'asignatura_id' =>  ($this->asignatura),
                        'periodo_id' =>  (5),
                        'nota' =>  ($value),
                    ]);
               }
               $this->resetTodo();
              session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');

        }
        public function resetTodo(){
            $this->matriculas=[];
            $this->sedes=[];
            $this->grados=[];
            $this->asignasturas=[];
            $this->grado='';
            $this->sede='';
            $this->asignatura='';
            $this->notas1=[];
        }







}
