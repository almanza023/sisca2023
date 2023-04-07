<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Asignatura;
use App\Models\CargaAcademica;
use App\models\DireccionGrado;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Preescolar;
use App\Models\Reportes\ReporteDimensiones as ReportesReporteDimensiones;
use App\Models\Sede;
use Livewire\Component;

class ReporteDimensiones extends Component
{
    public $sede, $grado, $periodo, $asignatura;
    public function render()
    {
        $asignaturas=[];
        $cargas='';
        $sedes=[];
        $grados=[];
        $periodos=[];
        $docente=auth()->user()->usable_id;
        if(auth()->user()->tipo==1){
            $doc=Docente::find($docente);
            $this->sede=$doc->sede_id;
            $grados=CargaAcademica::gradosDocente($docente, $this->sede);
            $asignaturas=CargaAcademica::asignaturasDocente($docente, $this->grado);

        }else{
            $sedes=Sede::active();
            $grados=Grado::preescolarActive();
            $asignaturas=CargaAcademica::asignaturasGrado($this->grado, $this->sede);

        }
        $periodos=Periodo::active();
        return view('livewire.reportes.reporte-dimensiones', compact('sedes', 'grados', 'asignaturas', 'periodos') );
    }

}
