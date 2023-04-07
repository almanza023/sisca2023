<?php

namespace App\Http\Livewire\Calificaciones;

use App\Models\Calificacion;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Sede;
use Livewire\Component;

class CalificacionEstudiantes extends Component
{
    public $sede, $grado, $periodo, $total, $calificaciones=[],
     $logrosAcademicos, $logrosAfectivos, $matriculas;
    public function render()
    {
        $sedes=[];
        $grados=[];
        $periodos=[];
        $sedes=Sede::active();
        $grados=Grado::secundariosActive();
        $periodos=Periodo::active();
        if(empty($this->sede)){
            $this->matriculas='';
        }
        return view('livewire.calificaciones.calificacion-estudiantes', compact('sedes','grados'));
    }

    public function buscar(){
        $this->matriculas=[];
        $validated = $this->validate([
            'sede' => 'required',
            'grado' => 'required',
        ]);
        $this->matriculas=Matricula::estudiantesCalificacion($this->sede, $this->grado);
        $this->total=count($this->matriculas);
    }

    public function verNotas($iid){

        $this->califcaciones=[];
        $this->califcaciones=Calificacion::where('matricula_id', $iid)
        ->where('periodo_id', $this->periodo)->get();
    }

}
