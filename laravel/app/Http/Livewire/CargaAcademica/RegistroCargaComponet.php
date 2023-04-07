<?php

namespace App\Http\Livewire\CargaAcademica;

use App\Models\Asignatura;
use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Sede;
use Livewire\Component;

class RegistroCargaComponet extends Component
{
    public $sede='', $docente='', $grado='', $asig='', $ihs, $por;
    public $detallesAsignatura=[];
    public $detallesIhs=[];
    public $doc=[];
    public $detallesPorcentaje=[];
    public $i = 1;
    public function render()
    {
        $sedes=Sede::active();
        $docentes=Docente::getDocente();
        $asignaturas=Asignatura::active();
        $grados=Grado::active();
        return view('livewire.carga-academica.registro-carga', compact('sedes', 'docentes', 'asignaturas', 'grados'));
    }

    public function add($i){

        $i = $i + 1;
        $this->i = $i;
        $this->validate([
            'asig' => 'required',
            'sede' => 'required',
            'docente' => 'required',
            'ihs' => 'required|integer',
            'por' => 'required|integer',
        ]);
        $data=CargaAcademica::validarAsignacion($this->sede, $this->docente, $this->grado, $this->asig);
        if(count($data)>0){
             session()->flash('error', 'YA EXISTE UN REGISTRO IGUAL');
        }else{
            for ($x = 0; $x <count($this->detallesAsignatura); $x++) {
                if($this->detallesAsignatura[$x]==$this->asig){
                    $this->asig='';
                    $this->ihs='';
                    $this->por='';
                    return session()->flash('error', 'No se puede repetir la aisgnatura');
                }
            }

            array_push($this->detallesAsignatura ,$this->asig);
            array_push($this->detallesIhs ,$this->ihs);
            array_push($this->detallesPorcentaje ,$this->por);
            array_push($this->doc ,$this->docente);
            $this->asig='';
            $this->ihs='';
            $this->por='';
        }

    }

    public function remove($i)
    {
        unset($this->detallesAsignatura[$i] );
        unset($this->detallesIhs[$i] );
        unset($this->detallesPorcentaje[$i] );
         unset($this->doc[$i] );
    }

    public function resetInputFields(){
        $this->docente='';
        $this->sede='';
        $this->grado='';
        $this->asig='';
        $this->ihs='';
        $this->por='';
        $this->detallesAsignatura=[];
        $this->detallesIhs=[];
        $this->detallesPorcentaje=[];
    }

    public function store(){
        $validatedDate = true;
        if ($validatedDate) {


            for ($x = 0; $x <count($this->detallesAsignatura); $x++) {
                $carga=new CargaAcademica();
                $carga->sede_id=$this->sede;
                $carga->docente_id=$this->doc[$x];
                $carga->grado_id=$this->grado;
                $part = explode("-", $this->detallesAsignatura[$x]);
                $carga->asignatura_id=$part[0];
                $carga->ihs=$this->detallesIhs[$x];
                $carga->porcentaje=$this->detallesPorcentaje[$x];
                $carga->save();
            }
            $this->resetInputFields();
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
        }

    }
}
