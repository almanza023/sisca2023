<?php

namespace App\Http\Livewire\Estudiantes;

use App\Models\Estudiante;
use App\Models\Matricula;
use Livewire\Component;

class EditarDatos extends Component
{
    public $documento, $nombres, $apellidos, $folio, $num_doc, $visible;
    public function render()
    {
        return view('livewire.estudiantes.editar-datos');
    }

    public function buscar(){
        $estudiante=Estudiante::where('num_doc', $this->documento)->first();
        if(!empty($estudiante)){
            $this->nombres=$estudiante->nombres;
            $this->apellidos=$estudiante->apellidos;
            $this->num_doc=$estudiante->num_doc;
            $matr=Matricula::where('estudiante_id', $estudiante->id)->first();
            if(!empty($matr)){
                $this->folio=$matr->folio;
            }
            $this->visible=true;
        }
    }

    public function update(){
        $estudiante=Estudiante::where('num_doc', $this->documento)->first();
        if(!empty($estudiante)){
            $estudiante->nombres=$this->nombres;
            $estudiante->apellidos=$this->apellidos;
            $estudiante->num_doc=$this->num_doc;
            $estudiante->save();
            $matr=Matricula::where('estudiante_id', $estudiante->id)->first();
            if(!empty($matr)){
                $matr->folio=$this->folio;
                $matr->save();
            }
        }
        session()->flash('message', 'Datos Actualizados Exitosamente.');
        $this->resetInput();
    }

    public function resetInput(){
        $this->documento='';
        $this->nombres='';
        $this->num_doc='';
        $this->apellidos='';
        $this->visible=false;


    }
}
