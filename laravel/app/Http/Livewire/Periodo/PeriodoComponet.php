<?php

namespace App\Http\Livewire\Periodo;

use App\Models\Periodo;
use Livewire\Component;
use Livewire\WithPagination;

class PeriodoComponet extends Component
{
    use WithPagination;
    public $descripcion, $numero, $porcentaje, $periodo_id, $updateMode=false;


    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;
    private $model=Periodo::class;
    public function render()
    {

        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.periodo.periodo', compact('data'));
    }

    public function resetInputFields(){
        $this->descripcion='';
        $this->numero='';
        $this->porcentaje='';
        $this->periodo_id='';
    }

    public function store(){
        $validated = $this->validate([
            'descripcion' => 'required',
            'numero' => 'required',
            'porcentaje' => 'required|integer',
        ]);

        if($validated){
            Periodo::create([
                'descripcion'=>strtoupper($this->descripcion),
                'numero'=>strtoupper($this->numero),
                'porcentaje'=>($this->porcentaje)
            ]);
            session()->flash('message', 'Periodo Creado Exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $periodo = Periodo::find($id);
        $this->periodo_id = $id;
        $this->descripcion = $periodo->descripcion;
        $this->numero = $periodo->numero;
        $this->porcentaje = $periodo->porcentaje;
    }

    public function editEstado($id)
    {
        $this->periodo_id = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'descripcion' => 'required',
            'numero' => 'required',
            'porcentaje'=>'required|integer'
        ]);

        if ($validatedDate) {
            $periodo = Periodo::find($this->periodo_id);
            $periodo->update([
                'descripcion'=>strtoupper($this->descripcion),
                'numero'=>($this->numero),
                'porcentaje'=>($this->porcentaje)

            ]);
            $this->updateMode = false;
            session()->flash('message', 'Periodo Actualizado exitosamente.');
            $this->resetInputFields();
            $this->emit('closeModal');

        }
    }

    public function updateEstado(){
        $periodo = Periodo::find($this->periodo_id);
        if($periodo->estado==1){
            $periodo->estado=0;
            $periodo->save();
        }else{
            $periodo->estado=1;
            $periodo->save();
        }
        session()->flash('message', 'Estado Actualizado Exitosamente.');
        $this->emit('closeModalEstado');

    }
}
