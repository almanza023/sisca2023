<?php

namespace App\Http\Livewire\Calificaciones;

use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Sede;
use Livewire\Component;

class CalificacionGeneral extends Component
{
   public $sede, $grado, $asignatura, $total, $calificaciones=[], $matriculas;
   public function render()
   {
       $sedes=[];
       $grados=[];
       $asignaturas=[];
       $sedes=Sede::active();
       $grados=Grado::secundariosActive();

        if(empty($this->sede)){
            $this->matriculas='';
        }
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
      return view('livewire.calificaciones.calificacion-general', compact('sedes','grados', 'asignaturas'));
   }

   public function buscar(){
       $this->matriculas=[];
       $validated = $this->validate([
           'sede' => 'required',
           'grado' => 'required',
           'asignatura' => 'required',
       ]);
       $matriculas=Matricula::estudiantesCalificacion($this->sede, $this->grado);
       foreach ($matriculas as $item) {
            $estudiante=$item->apellidos.' '.$item->nombres;
            $notap1=Calificacion::notaAnteriorEst($item->id, $this->asignatura, 1)->nota;
            $notap2=Calificacion::notaAnteriorEst($item->id, $this->asignatura, 2)->nota;
            $notap3=Calificacion::notaAnteriorEst($item->id, $this->asignatura, 3)->nota;
            $def=round(($notap1+$notap2+$notap3)/4,1);
            if($def>=3){
                $min='';
            }else{
                $min=12-($notap1+$notap2+$notap3);
            }
            $temp=[
                'id_estudiante'=>$item->id,
                'estudiante'=>$estudiante,
                'notap1'=>$notap1,
                'notap2'=>$notap2,
                'notap3'=>$notap3,
                'min'=>$min,
                'def'=>$def,
            ];
            array_push($this->matriculas, $temp);
       }
       $this->total=count($this->matriculas);
   }

   public function verNotas($iid){

       $this->califcaciones=[];
       $this->califcaciones=Calificacion::where('matricula_id', $iid)
       ->where('periodo_id', $this->periodo)->get();

   }
}
