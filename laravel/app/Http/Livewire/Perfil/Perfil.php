<?php

namespace App\Http\Livewire\Perfil;

use App\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Perfil extends Component
{
    public $name, $password1, $password2;
    public function render()
    {
        $user=auth()->user();
        $this->name=$user->name;
        return view('livewire.perfil.perfil');
    }

    public function update(){
        $validated = $this->validate([
            'password1' => 'required|min:6',
            'password2' => 'required|min:6',
        ]);

        if(($this->password1==$this->password2)){
                $usuario=User::find(auth()->user()->id)->update([
                    'password'=>Hash::make($this->password1)
                ]);
                $this->password1='';
                $this->password2='';
                 session()->flash('message', 'DAtTOS ACTUALIZADOS EXITOSAMENTE');
            }else{
                return  session()->flash('error', 'CONTRASEÑAS NO COINCIDEN');
        }

    }
}
