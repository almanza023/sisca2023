<?php

namespace App\Http\Livewire\Calificaciones;

use Livewire\Component;

class Detalles extends Component
{

    public $calificaciones=[], $total=0, $posicion, $calificacion_id, $updateMode=false;
    public $logroAfe, $logroCog, $nota, $tipo;
    public $sede, $grado, $asignatura, $periodo;
    public function mount($post)
    {
       $this->calificaciones=[];
       $this->calificaciones=$post['data'];
       $this->tipo=$post['tipo'];
       $this->sede=$post['sede'];
       $this->grado=$post['grado'];
       $this->asignatura=$post['asignatura'];
       $this->periodo=$post['periodo'];
       $this->total=count($this->calificaciones);
    }

    public function render()
    {
        return view('livewire.calificaciones.detalles');
    }

    public function edit($posicion, $calificacion_id){
        $this->posicion=$posicion;
        $this->calificacion_id=$calificacion_id;
        $this->updateMode=true;
    }

    public function redireccionar(){
        if($this->tipo=='create'){
           redirect()->route('calificaciones.create');
        }else{
            redirect('/home');
        }
    }
}
