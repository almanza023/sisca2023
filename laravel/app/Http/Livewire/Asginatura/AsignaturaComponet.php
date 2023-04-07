<?php

namespace App\Http\Livewire\Asginatura;

use App\Models\Asignatura;
use App\Models\TipoAsignatura;
use Livewire\Component;
use Livewire\WithPagination;

class AsignaturaComponet extends Component
{

    use WithPagination;
    public $nombre, $acronimo,  $tipo, $asignatura_id, $updateMode=false, $model;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;



    protected $listeners = ['resetInputFields'];

    function __construct() {
       $this->model=Asignatura::class;
    }



    public function render()
    {
        $data=$this->model::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        $tipos=TipoAsignatura::where('estado', 1)->get();
        return view('livewire.asignatura.asignatura', compact('data', 'tipos'));
    }

    public function resetInputFields(){
        $this->nombre='';
        $this->tipo='';
        $this->acronimo='';
        $this->asignatura_id='';
    }

    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
            'acronimo' => 'required',
            'tipo' => 'required|integer'
        ]);

        if($validated){
            $this->model::create([
                'nombre'=>strtoupper($this->nombre),
                'acronimo'=>strtoupper($this->acronimo),
                'tipo_asignatura_id'=>strtoupper($this->tipo),
            ]);
            session()->flash('message', 'Asignatura  Creada Exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->asignatura_id = $id;
        $this->nombre = $obj->nombre;
        $this->acronimo = $obj->acronimo;
        $this->tipo = $obj->tipo_asignatura_id;
    }

    public function editEstado($id)
    {
        $this->asignatura_id = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'nombre' => 'required',
            'acronimo' => 'required',
            'tipo' => 'required|integer'
        ]);

        if ($validatedDate) {
            $obj = $this->model::find($this->asignatura_id);
            $obj->update([
                'nombre'=>strtoupper($this->nombre),
                'acronimo'=>strtoupper($this->acronimo),
                'tipo_asignatura_id'=>strtoupper($this->tipo),
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Asignatura Actualizada exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');

        }
    }

    public function updateEstado(){
        $obj = $this->model::find($this->asignatura_id);
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
