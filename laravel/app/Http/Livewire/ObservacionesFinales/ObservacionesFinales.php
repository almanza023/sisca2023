<?php

namespace App\Http\Livewire\ObservacionesFinales;

use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroObservacion;
use App\Models\Matricula;
use App\models\ObservacionFinal;
use App\Models\Sede;
use Livewire\Component;

class ObservacionesFinales extends Component
{
    public  $matriculas=[], $logros='', $grado, $sede, $updateMode=false,
    $logro_id, $logros1=[], $matriculas1=[];
   public function render()
   {

       $sedes=[];
       $grados=[];
       $docente=auth()->user()->usable_id;
       if(auth()->user()->tipo==1){
           $doc=Docente::find($docente);
           $this->sede=$doc->sede_id;
           $grados=CargaAcademica::gradosDocente($docente, $this->sede);

       }else{
           $sedes=Sede::active();
           $grados=Grado::preescolarActive();

       }
       if(empty($this->sede)){
           $this->matriculas='';
       }

       return view('livewire.observaciones-finales.observaciones-finales', compact('sedes','grados'));
   }

   public function buscar(){

       $dataFecha='';
       $this->logros='';
       $this->matriculas=[];
       $validated = $this->validate([
           'sede' => 'required',
           'grado' => 'required',

       ]);


            $this->matriculas=Matricula::estudiantesCalificacion($this->sede, $this->grado);
            $this->total=count($this->matriculas);
            $this->logros=LogroObservacion::filtro($this->sede, $this->grado );

    }


   public function seleccionar($id){

       $this->logCog=$id;

   }

   public function store(){
   foreach ($this->matriculas as $index => $matricula) {
    ObservacionFinal::updateOrCreate(
        ['matricula_id' =>  ($matricula['id'])],
        [
            'matricula_id' =>  ($matricula['id']),
            'logro' =>  ($this->logros1[$index]),
        ]);
   }
   session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
   return redirect()->route('observaciones-finales');


}


}
