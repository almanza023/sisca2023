<?php

namespace App\Http\Livewire\Tipologro;

use App\Models\TipoLogro;
use Livewire\Component;
use Livewire\WithPagination;

class TipoLogroComponet extends Component
{

    use WithPagination;

    public $nombre, $nivel,  $tipo_id, $updateMode=false, $model;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    function __construct() {
       $this->model=TipoLogro::class;
    }

    public function render()
    {

        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.tipologro.tipo-logro', compact('data'));
    }

    public function resetInputFields(){
        $this->nombre='';
        $this->nivel='';
        $this->tipo_id='';
    }

    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
            'nivel' => 'required',
        ]);

        if($validated){
            $this->model::create([
                'nombre'=>strtoupper($this->nombre),
                'nivel'=>strtoupper($this->nivel)
            ]);
            session()->flash('message', 'Tipo Logro  Creado Exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->tipo_id = $id;
        $this->nombre = $obj->nombre;
        $this->nivel = $obj->nivel;
    }

    public function editEstado($id)
    {
        $this->tipo_id = $id;

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
            'nivel' => 'required',
        ]);

        if ($validatedDate) {
            $obj = $this->model::find($this->tipo_id);
            $obj->update([
                'nombre'=>strtoupper($this->nombre),
                'nivel'=>strtoupper($this->nivel),
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Tipo Logro Actualizado exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');

        }
    }

    public function updateEstado(){
        $obj = $this->model::find($this->tipo_id);
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
