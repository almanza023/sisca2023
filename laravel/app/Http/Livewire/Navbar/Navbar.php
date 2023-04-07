<?php

namespace App\Http\Livewire\Navbar;

use App\Models\DireccionGrado;
use Livewire\Component;

class Navbar extends Component
{
    public $tipo, $direcciones=0, $grado, $admin=false;
    

    public function render()
    {
        $this->tipo=auth()->user()->tipo;
        if($this->tipo==1){
            $direcciones=DireccionGrado::getByDocente(auth()->user()->usable_id);
           
            if(count($direcciones)>0){
                $this->grado=$direcciones[0]->grado_id;
                $this->direcciones=count($direcciones);
            }else{
                $this->grado='';
                $this->direcciones=0;
            }
            
        }else{
            $this->admin=true;
        }


        return view('livewire.navbar.navbar');
    }
}
