<?php

namespace App\Http\Livewire\Matricula;

use App\Models\Matricula;
use Livewire\Component;
use Livewire\WithPagination;

class MatriculaComponet extends Component
{
    use WithPagination;


    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;
    private $model=Matricula::class;
    public function render()
    {
        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.matricula.matricula', compact('data'));
    }
}
