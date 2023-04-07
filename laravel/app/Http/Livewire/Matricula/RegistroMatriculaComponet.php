<?php

namespace App\Http\Livewire\Matricula;

use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Sede;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistroMatriculaComponet extends Component
{



    public $nombres, $apellidos, $tipo_doc, $num_doc, $fecha_nac,
    $lugar_nac, $estrato, $direccion, $eps, $zona, $tipo_sangre, $desplazado,
    $nombre_madre, $nombre_padre, $nombre_acudiente, $telefono_acudiente, $grado, $sede, $nivel, $folio, $repitente;

    public function render()
    {
        $sedes=Sede::active();
        $grados=Grado::active();
        return view('livewire.matricula.registro-matricula', compact('sedes', 'grados'));
    }

    public function resetInputFields(){
        $this->nombres='';
        $this->apellidos='';
        $this->num_doc='';
       

    }

    private function reglas(){
        return [
            'nombres' => 'required',
            'apellidos' => 'required',
            'tipo_doc' => 'required',
            'num_doc' => 'required',
            'folio' => 'required',
            'grado' => 'required',
            'sede' => 'required',


        ];
    }

    private function data(){

        return [
            'nombres'=>strtoupper($this->nombres),
            'apellidos'=>strtoupper($this->apellidos),
            'tipo_doc'=>strtoupper($this->tipo_doc),
            'num_doc'=>($this->num_doc),
            'fecha_nac'=>($this->fecha_nac),
            'lugar_nac'=>($this->lugar_nac),
            'estrato'=>($this->estrato),
            'direccion'=>strtoupper($this->direccion),
            'eps'=>strtoupper($this->eps),
            'zona'=>strtoupper($this->zona),
            'tipo_sangre'=>strtoupper($this->tipo_sangre),
            'desplazado'=>strtoupper($this->desplazado),
            'nombre_madre'=>strtoupper($this->nombre_madre),
            'nombre_padre'=>strtoupper($this->nombre_padre),
            'nombre_acudiente'=>strtoupper($this->nombre_acudiente),
            'telefono_acudiente'=>($this->telefono_acudiente),

        ];
    }

    public function store(){
        $validated = $this->validate($this->reglas());
        DB::beginTransaction();

        try {
            if($validated){
                $est=Estudiante::create($this->data());
                Matricula::create([
                    'estudiante_id'=>$est->id,
                    'grado_id'=>$this->grado,
                    'sede_id'=>$this->sede,
                    'nivel'=>$this->nivel,
                    'folio'=>$this->folio,
                    'repitente'=>$this->repitente,
                ]);
                DB::commit();
                session()->flash('message', 'Datos Registrados Exitosamente.');
                $this->resetInputFields();
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message', $e->getMessage());
        }

    }
}
