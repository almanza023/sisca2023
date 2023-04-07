<?php

namespace App\Http\Livewire\CargaAcademica;

use App\Models\Asignatura;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Sede;
use Livewire\Component;
use Livewire\WithPagination;

class CargaAcademicaComponet extends Component
{


    public $sede='', $docente='', $grado='', $cargas, $carga_id='';
    public function render()
    {
        $sedes=Sede::active();
        $docentes=Docente::getDocente();
        $asignaturas=Asignatura::active();
        $grados=Grado::active();
        return view('livewire.carga-academica.carga-academica', compact('sedes', 'docentes', 'asignaturas', 'grados'));
    }

    public function buscar(){

        $this->cargas=CargaAcademica::filtro($this->sede, $this->grado, $this->docente);
    }

    public function editEstado($id)
    {
        $this->carga_id = $id;

    }

    public function delete(){
        CargaAcademica::find($this->carga_id)->delete();
        session()->flash('message', 'Registro Eliminado Exitosamente.');
        $this->emit('closeModalEstado');

    }
}


