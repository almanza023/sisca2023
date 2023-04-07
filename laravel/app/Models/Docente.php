<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{


    protected $table = 'docentes';
    protected $fillable = [ 'sede_id','nombres', 'apellidos', 'documento', 'correo', 'telefono', 'escalafon',
     'especialidad', 'nivel', 'tipo', 'estado'];


     public static function search($search)
     {
         return empty($search) ? static::query()
             : static::query()->where('id', 'like', '%'.$search.'%')
                 ->orWhere('nombres', 'like', '%'.$search.'%')
                 ->orWhere('apellidos', 'like', '%'.$search.'%')
                 ->orWhere('documento', 'like', '%'.$search.'%')
                 ->orWhere('telefono', 'like', '%'.$search.'%')
                 ->orWhere('sede_id', 'like', '%'.$search.'%');
     }

     public function sede()
    {
        return $this->belongsTo('App\Models\Sede', 'sede_id', );
    }


    public static function getDocente(){
        return Docente::where('tipo', 1)->where('estado', 1)->get();
    }

    public static function getDocentePorSede($sede){
        return Docente::where('tipo', 1)
        ->where('sede_id', $sede)
        ->where('estado', 1)->get();
    }

    public static function active(){
        return Docente::where('estado', 1)->get();
    }
}
