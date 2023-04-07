<?php

namespace App\Http\Livewire\IndividualPeriodo;

use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Convivencia;
use App\Models\Grado;
use App\Models\LogroAcademico;
use App\Models\LogroDisciplinario;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Sede;
use Livewire\Component;

class IndividualPeriodo extends Component
{
    public $grado, $sede, $periodo, $matricula, $asignaturas=[], $nota, $notas=[],
     $show=false, $logro, $logros=[], $logroActual;
    public function render()
    {
        $sedes=[];
        $grados=[];
        $periodos=[];
        $matriculas=[];
        $sedes=Sede::active();
        $grados=Grado::secundariosActive();
        $matriculas=Matricula::listado($this->sede, $this->grado, );
        $periodos=Periodo::active();

        return view('livewire.individual-periodo.individual-periodo', compact('sedes',
         'grados', 'matriculas', 'periodos'));
    }

    private function getCalificaciones($matricula, $periodo){
        $this->notas=Calificacion::matriculaCalificaciones($matricula, $periodo );
    }
    public function buscar(){
        $this->getCalificaciones($this->matricula, $this->periodo);
        $this->asignaturas=CargaAcademica::asignaturasGrado($this->grado, $this->sede);
        $this->logros=LogroDisciplinario::filtro($this->sede, $this->grado, 29, $this->periodo);
        $conv=Convivencia::byMatriculaPeriodo($this->matricula, $this->periodo);
        if(!empty($logro)){
            $this->logroActual=$conv->logro;
        }

    }

    public function add($id){

        if(empty($this->nota) || $this->nota<1 || $this->nota>5  ){
            $this->nota='';
            session()->flash('warning', 'Nota no valida');

        }else{
            $asignatura=$this->asignaturas[$id]->asignatura->id;
            $logroC=0;
            $logroA=0;
            $logro1=LogroAcademico::filtro($this->sede, $this->grado, $asignatura, $this->periodo, 2);
            $logro2=LogroAcademico::filtro($this->sede, $this->grado, $asignatura, $this->periodo, 3);
            $logro2=LogroAcademico::filtro($this->sede, $this->grado, $asignatura, $this->periodo, 3);

            if(count($logro1)>0){
                if($logro1[0]->id>0){
                    $logroC=$logro1[0]->id;
                }
            }
            if(count($logro2)>0){
                if($logro2[0]->id>0){
                    $logroA=$logro2[0]->id;
                }
            }
            $Calificacion=Calificacion::updateOrCreate(
                ['matricula_id' => $this->matricula, 'periodo_id' => $this->periodo, 'asignatura_id'=>$asignatura],
                ['matricula_id' => $this->matricula, 'periodo_id' => $this->periodo,
                 'asignatura_id'=>$asignatura,
                 'nota'=>$this->nota,
                 'logro_cognitivo'=>$logroC,
                 'logro_afectivo'=>$logroA]
            );
            if($Calificacion){
                $this->getCalificaciones($this->matricula, $this->periodo);
                $this->nota='';

                if(!empty($this->logro)){
                    Convivencia::updateOrCreate(
                        ['matricula_id' => $this->matricula, 'periodo_id' => $this->periodo],
                        ['matricula_id' => $this->matricula, 'periodo_id' => $this->periodo,
                         'asignatura_id'=>29, 'logro'=>$this->logro]);
                }

                session()->flash('success', 'CALIFICACION REGISTRADA CON EXITO');
                $this->render();
            }
        }

    }
}
