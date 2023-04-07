<?php

namespace App\Http\Livewire\DireccionGrado;

use App\Models\DireccionGrado as ModelsDireccionGrado;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Sede;
use App\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class DireccionGrado extends Component
{

    use WithPagination;

    public $grado, $sede, $docente, $iid, $updateMode=false, $model;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    function __construct() {
        $this->model=ModelsDireccionGrado::class;
     }

    public function render()
    {
        $docentes=[];
        $sedes=Sede::active();
        $grados=Grado::active();
        if(!empty($this->sede)){
            $docentes=Docente::getDocentePorSede($this->sede);
        }
        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.direcciongrados.direccion-grado', compact('docentes', 'sedes', 'grados', 'data'));
    }

    public function resetInputFields(){
        $this->docente='';
        $this->grado='';
        $this->sede='';
    }

    public function store(){
        $validated = $this->validate([
            'sede' => 'required',
            'grado' => 'required',
            'docente' => 'required'
        ]);

        $data=$this->model::validarDuplicado($this->sede, $this->grado, $this->docente);
        if(count($data)>0){
            return session()->flash('error', 'YA EXISTE ASIGNACIÓN DE GRADO PARA LA SEDE, GRADO Y DOCENTE SELECCIONADO');
        }
            $this->model::create([
                'sede_id'=>$this->sede,
                'grado_id'=>$this->grado,
                'docente_id'=>$this->docente,
            ]);
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');


    }
    public function editEstado($id)
    {
        $this->iid = $id;

    }

    public function edit($id)
    {
       $this->updateMode = true;
       $obj=$this->model::find($id);
       $this->grado=$obj->grado_id;
       $this->sede=$obj->sede_id;
       $this->docente=$obj->docente_id;
       $this->iid=$id;
    }

    public function update(){

        $validated = $this->validate([
            'sede' => 'required',
            'grado' => 'required',
            'docente' => 'required'
        ]);
        $obj = $this->model::find($this->iid);

            $obj->update([
                'sede_id'=>$this->sede,
                'grado_id'=>$this->grado,
                'docente_id'=>$this->docente,
            ]);
            session()->flash('message', 'DATOS ACTUALIZADOS EXITOSAMENTE.');
            $this->resetInputFields();
            $this->emit('closeModal');
        }

    public function updateEstado(){
        $obj = $this->model::find($this->iid);
        if($obj->estado==1){
            $obj->estado=0;
            $obj->save();
        }else{
            $obj->estado=1;
            $obj->save();
        }
        session()->flash('message', 'ESTADO ACTUALIZADO EXITOSAMENTE.');
        $this->emit('closeModalEstado');

    }
}
