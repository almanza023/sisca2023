<?php

namespace App\Http\Livewire\Dimensiones;

use Livewire\Component;

class DetallesDimensiones extends Component
{

    public $calificaciones=[], $total=0, $posicion, $calificacion_id, $updateMode=false;
    public $logroAfe, $logroCog, $nota, $tipo;
    public function mount($post)
    {
       $this->calificaciones=[];
       $this->calificaciones=$post['data'];
       $this->tipo=$post['tipo'];
       $this->total=count($this->calificaciones);
    }

    public function render()
    {
        return view('livewire.dimensiones.detalles');
    }




}
