<?php

namespace App\Http\Livewire\AperturaPeriodos;

use App\Models\AperturaPeriodo;
use App\Models\Periodo;
use Livewire\Component;
use Livewire\WithPagination;

class AperturaPeriodos extends Component
{
    use WithPagination;
    public $fecha_apertura, $fecha_cierre, $periodo_id='', $iid, $updateMode=false;


    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;
    private $model=AperturaPeriodo::class;
    public function render()
    {

        $periodos=Periodo::active();
        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.aperturaperiodos.aperturaperiodos', compact('data', 'periodos'));
    }

    public function resetInputFields(){
        $this->fecha_cierre='';
        $this->fecha_apertura='';
        $this->periodo_id='';
        $this->iid='';
    }

    public function store(){

        $validated = $this->validate([
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'required|date',
            'periodo_id' => 'required',
        ]);

        $data=$this->model::validarPeriodo($this->periodo_id);

        if(count($data)>0){
            return session()->flash('message', 'EL PERIODO SELECCIONADO YA TIENE FECHA DE APERTURA');
        }
        if($validated){
            $this->model::create([
                'fecha_apertura'=>($this->fecha_apertura),
                'fecha_cierre'=>strtoupper($this->fecha_cierre),
                'periodo_id'=>($this->periodo_id)
            ]);
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE');
            $this->resetInputFields();
            $this->emit('closeModal');
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $this->iid=$id;
        $periodo =$this->model::find($id);
        $this->periodo_id = $periodo->periodo_id;
        $this->fecha_apertura = $periodo->fecha_apertura;
        $this->fecha_cierre = $periodo->fecha_cierre;
    }

    public function editEstado($id)
    {
        $this->iid = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'required|date',
            'periodo_id' => 'required|integer',
        ]);

        if ($validatedDate) {

            $periodo = $this->model::find($this->iid);
            $periodo->update([
                'fecha_apertura'=>($this->fecha_apertura),
                'fecha_cierre'=>strtoupper($this->fecha_cierre),
                'periodo_id'=>($this->periodo_id)
            ]);
            $this->updateMode = false;
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE');
            $this->resetInputFields();
            $this->emit('closeModal');

        }
    }

    public function updateEstado(){
        $periodo = $this->model::find($this->iid);
        if($periodo->estado==1){
            $periodo->estado=0;
            $periodo->save();
        }else{
            $periodo->estado=1;
            $periodo->save();
        }
        session()->flash('message', 'ESTADO DE PERIODO ACTUALIZADO EXITOSAMENTE');
        $this->emit('closeModalEstado');

    }
}
