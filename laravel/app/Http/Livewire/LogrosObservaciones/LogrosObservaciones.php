<?php

namespace App\Http\Livewire\LogrosObservaciones;

use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroObservacion;
use App\Models\Periodo;
use App\Models\Sede;
use Livewire\Component;

class LogrosObservaciones extends Component
{
    public  $grado, $descripcion, $logros, $tipo, $sede_id,
    $periodo, $updateMode=false, $logro_id='';



   public function render()
   {

       $cargas=[];
       $grados=[];
       $sedes=[];
       $gradosDocente=[];
       $periodos=Periodo::active();

       if(auth()->user()->tipo==1){
           //Docente
           $docente=auth()->user()->usable_id;
           $doc=Docente::find($docente)->first('sede_id');
           $this->sede_id=$doc->sede_id;
           $gradosDocente=CargaAcademica::gradosDocente($docente, $this->sede_id);

       }else{
           $docente='';
           $grados=Grado::preescolarActive();
           $sedes=Sede::active();
       }
       return view('livewire.logros-observaciones.logros-observaciones', compact('grados', 'gradosDocente', 'sedes',  'periodos'));
   }


   public function resetInputFields(){
       $this->grado='';
       $this->sede_id='';
       $this->periodo='';
       $this->descripcion='';
   }



   private function reglas(){
       if(auth()->user()->tipo==1){
           return [
               'grado' => 'required',
               'descripcion' => 'required',
               'sede_id' => 'required',
           ];
       }else{
           return [
               'grado' => 'required',
               'descripcion' => 'required',
           ];
       }

   }

   private function data(){

       return [
           'grado_id'=>($this->grado),
           'sede_id'=>($this->sede_id),
           'descripcion'=>($this->descripcion),
       ];
   }

   public function store(){
       $validated = $this->validate($this->reglas());
       if($validated){
           LogroObservacion::create($this->data());
           session()->flash('message', 'Datos Registrados Exitosamente.');
           $this->descripcion='';
       }
   }

   public function filtrar(){

       $this->logros=LogroObservacion::filtro($this->sede_id, $this->grado);
   }

   public function edit($id)
   {
       $this->updateMode = true;
       $obj = LogroObservacion::find($id);
       $this->logro_id = $id;
       $this->grado = $obj->grado_id;
       $this->sede_id = $obj->sede_id;
       $this->descripcion=$obj->descripcion;
   }

   public function update()
   {
       $validatedDate = $this->validate($this->reglas());

       if ($validatedDate) {
           $obj = LogroObservacion::find($this->logro_id);
           $obj->update($this->data());
           $this->updateMode = false;
           session()->flash('message', 'Datos Actualizados Exitosamente.');
           $this->descripcion='';
           $this->emit('closeModal');

       }
   }
}
