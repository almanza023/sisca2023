<?php

namespace App\Http\Livewire\LogroDisciplinario;


use App\Models\Asignatura;
use App\Models\CargaAcademica;
use App\Models\DireccionGrado as ModelsDireccionGrado;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\LogroAcademico;
use App\Models\LogroDisciplinario as ModelsLogroDisciplinario;
use App\Models\Periodo;
use App\Models\Sede;
use App\Models\TipoLogro;
use Livewire\Component;

class LogroDisciplinario extends Component
{
    public $asignatura='29', $grado, $descripcion, $logros, $tipo, $sede_id,
     $periodo, $updateMode=false, $logro_id='';

    function __construct() {
        $this->model=ModelsLogroDisciplinario::class;
     }

    public function render()
    {
        $asignaturas=[];
        $cargas=[];
        $grados=[];
        $sedes=[];
        $gradosDocente=[];
        $tipos=TipoLogro::active();
        $periodos=Periodo::active();
        $asignatura=Asignatura::find(29);

        if(auth()->user()->tipo==1){
            //Docente
            $docente=auth()->user()->usable_id;
            $doc=Docente::find($docente);
            $this->sede_id=$doc->sede_id;
            $gradosDocente=ModelsDireccionGrado::getByDocente($docente);

        }else{
            $docente='';
            $grados=Grado::secundariosActive();
            $sedes=Sede::active();
        }
        return view('livewire.logro-disciplinario.logro', compact('grados', 'gradosDocente', 'sedes', 'tipos', 'asignatura', 'periodos'));
    }


    public function resetInputFields(){
        $this->grado='';
        $this->asignatura='';
        $this->periodo='';
        $this->descripcion='';
    }



    private function reglas(){
        if(auth()->user()->tipo==1){
            return [
                'grado' => 'required',
                'descripcion' => 'required',
                'sede_id' => 'required',
                'asignatura' => 'required',
                'periodo' => 'required'
            ];
        }else{
            return [
                'grado' => 'required',
                'descripcion' => 'required',
                'asignatura' => 'required',
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
        ];
    }

    public function store(){
        $validated = $this->validate($this->reglas());
        if($validated){
            $this->model::create($this->data());
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
            $this->descripcion='';
        }
    }

    public function filtrar(){

        $this->logros=$this->model::filtro($this->sede_id, $this->grado, $this->asignatura, $this->periodo);
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->logro_id = $id;
        $this->periodo = $obj->periodo_id;
        $this->descripcion=$obj->descripcion;
    }

    public function update()
    {
        $validatedDate = $this->validate($this->reglas());

        if ($validatedDate) {
            $obj = $this->model::find($this->logro_id);
            $obj->update($this->data());
            $this->updateMode = false;
            session()->flash('message', 'DATOS ACTUALIZADOS EXITOSAMENTE.');
            $this->descripcion='';
            $this->emit('closeModal');

        }
    }


}
