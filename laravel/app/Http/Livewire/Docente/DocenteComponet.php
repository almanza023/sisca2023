<?php

namespace App\Http\Livewire\Docente;

use App\Models\Docente;
use App\Models\Sede;
use Livewire\Component;
use Livewire\WithPagination;

class DocenteComponet extends Component
{

    use WithPagination;
    public $sede,  $nombres, $apellidos, $documento, $correo, $telefono,
      $escalafon, $especialidad, $nivel, $tipo, $docente_id, $updateMode=false, $model;

    protected $listeners = ['resetInputFields'];

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    function __construct() {
       $this->model=Docente::class;
    }


    public function render()
    {
        $data=$this->model::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        $sedes=Sede::where('estado', 1)->get();
        return view('livewire.docente.docente', compact('data', 'sedes'));
    }

    public function resetInputFields(){
        $this->nombres='';
        $this->apellidos='';
        $this->documento='';
        $this->correo='';
        $this->telefono='';
        $this->escalafon='';
        $this->especialidad='';
        $this->nivel='';
        $this->tipo='';
        $this->sede='';
    }

    public function store(){
        $validated = $this->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'documento' => 'required|integer',
            'telefono' => 'required|integer',
            'tipo' => 'required|integer',
            'sede' => 'required|integer'

        ]);

        if($validated){
            $this->model::create([
                'nombres'=>strtoupper($this->nombres),
                'apellidos'=>strtoupper($this->apellidos),
                'documento'=>($this->documento),
                'correo'=>($this->correo),
                'telefono'=>($this->telefono),
                'especialidad'=>($this->especialidad),
                'escalafon'=>($this->escalafon),
                'nivel'=>($this->nivel),
                'tipo'=>($this->tipo),
                'sede_id'=>($this->sede),
            ]);
            session()->flash('message', 'Datos Registrados Exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->docente_id = $id;
        $this->nombres = $obj->nombres;
        $this->apellidos = $obj->apellidos;
        $this->documento = $obj->documento;
        $this->correo=$obj->documento;
        $this->telefono=$obj->telefono;
        $this->escalafon=$obj->escalafon;
        $this->especialidad=$obj->especialidad;
        $this->nivel=$obj->nivel;
        $this->tipo=$obj->tipo;
        $this->sede=$obj->sede_id;
    }

    public function editEstado($id)
    {
        $this->docente_id = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'documento' => 'required|integer',
            'telefono' => 'required|integer',
            'tipo' => 'required|integer',
            'sede' => 'required|integer'
        ]);

        if ($validatedDate) {
            $obj = $this->model::find($this->docente_id);
            $obj->update([
                'nombres'=>strtoupper($this->nombres),
                'apellidos'=>strtoupper($this->apellidos),
                'documento'=>($this->documento),
                'correo'=>($this->correo),
                'telefono'=>($this->telefono),
                'especialidad'=>($this->especialidad),
                'escalafon'=>($this->escalafon),
                'nivel'=>($this->nivel),
                'tipo'=>($this->tipo),
                'sede_id'=>($this->sede),
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Datos Actualizados Exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');

        }
    }

    public function updateEstado(){
        $obj = $this->model::find($this->docente_id);
        if($obj->estado==1){
            $obj->estado=0;
            $obj->save();
        }else{
            $obj->estado=1;
            $obj->save();
        }
        session()->flash('message', 'Estado Actualizado Exitosamente.');
        $this->emit('closeModalEstado');

    }
}
