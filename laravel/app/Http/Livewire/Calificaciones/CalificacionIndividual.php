<?php

namespace App\Http\Livewire\Calificaciones;

use App\Models\CargaAcademica;
use App\Models\Matricula;
use Livewire\Component;

class CalificacionIndividual extends Component
{
    public $iid, $asignaturas=[], $matricula, $notas=[];

    public function mount($iid)
    {
        $this->iid = $iid;
    }

    public function render()
    {
        $this->matricula=Matricula::find($this->iid);
        $this->asignaturas=CargaAcademica::asignaturasGrado($this->matricula->grado_id, $this->matricula->sede_id);
        return view('livewire.calificaciones.calificacion-individual');
    }

}
