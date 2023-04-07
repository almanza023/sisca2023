<?php

namespace App\Http\Livewire\NivelacionesFinales;

use Livewire\Component;
use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Nivelacion;
use App\Models\Sede;

class ConsultarNivFinales extends Component
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

       return view('livewire.nivelaciones-finales.consultar-niv-finales', compact('sedes','grados', 'asignaturas'));
   }

   public function buscar(){

    $validated = $this->validate([
        'sede' => 'required',
        'asignatura' => 'required',
        'grado' => 'required',
    ]);
    $this->matriculas=Nivelacion::nivelacionesPeriodo($this->sede, $this->grado, $this->asignatura, 5);
    }



}
