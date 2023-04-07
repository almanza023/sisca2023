<?php

namespace App\Http\Livewire\Logro;

use App\Models\CargaAcademica;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroAcademico;
use App\Models\Periodo;
use App\Models\Sede;
use App\Models\TipoLogro;
use Livewire\Component;

class LogroComponet extends Component
{
    public $asignatura, $grado, $descripcion, $logros, $tipo, $sede_id,
     $periodo, $updateMode=false, $logro_id='';

    function __construct() {
        $this->model=LogroAcademico::class;
     }

    public function render()
    {
        $asignaturas=[];
        $cargas=[];
        $grados=[];
        $sedes=[];
        $gradosDocente=[];
        $tipos=TipoLogro::secundaria();
        $periodos=Periodo::active();

        if(auth()->user()->tipo==1){
            //Docente
            $docente=auth()->user()->usable_id;
            $doc=Docente::find($docente);
            $this->sede_id=$doc->sede_id;
              
         
            $gradosDocente=CargaAcademica::gradosDocente($docente, $this->sede_id);
             
            $asignaturas=CargaAcademica::asignaturasDocente($docente, $this->grado);

        }else{
            $docente='';
            $grados=Grado::secundariosActive();
            $sedes=Sede::active();
            $asignaturas=CargaAcademica::asignaturasGrado($this->grado, $this->sede_id);
        }
        return view('livewire.logro.logro', compact('grados', 'gradosDocente', 'sedes', 'tipos', 'asignaturas', 'periodos'));
    }


    public function resetInputFields(){
        $this->grado='';
        $this->sede_id='';
        $this->asignatura='';
        $this->periodo='';
        $this->tipo='';
        $this->descripcion='';
    }



    private function reglas(){
        if(auth()->user()->tipo==1){
            return [
                'grado' => 'required',
                'asignatura' => 'required',
                'tipo' => 'required',
                'descripcion' => 'required',
                'sede_id' => 'required',
                'periodo' => 'required'
            ];
        }else{
            return [
                'grado' => 'required',
                'asignatura' => 'required',
                'tipo' => 'required',
                'descripcion' => 'required',
                'periodo' => 'required'
            ];
        }

    }

    private function data(){

        return [
            'grado_id'=>($this->grado),
            'asignatura_id'=>($this->asignatura),
            'sede_id'=>($this->sede_id),
            'periodo_id'=>($this->periodo),
            'descripcion'=>($this->descripcion),
            'tipo_logro_id'=>($this->tipo),
        ];
    }

    public function store(){
        $validated = $this->validate($this->reglas());
        if($validated){
            $this->model::create($this->data());
            session()->flash('message', 'Datos Registrados Exitosamente.');
            $this->descripcion='';
        }
    }

    public function filtrar(){

        $this->logros=LogroAcademico::filtro($this->sede_id, $this->grado, $this->asignatura, $this->periodo, $this->tipo);
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->logro_id = $id;
        $this->grado = $obj->grado_id;
        $this->periodo = $obj->periodo_id;
        $this->tipo = $obj->tipo_logro_id;
        $this->asignatura=$obj->asignatura_id;
        $this->descripcion=$obj->descripcion;
    }

    public function update()
    {
        $validatedDate = $this->validate($this->reglas());

        if ($validatedDate) {
            $obj = $this->model::find($this->logro_id);
            $obj->update($this->data());
            $this->updateMode = false;
            session()->flash('message', 'Datos Actualizados Exitosamente.');
            $this->descripcion='';
            $this->emit('closeModal');

        }
    }


}
