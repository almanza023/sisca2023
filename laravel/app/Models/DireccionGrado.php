<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class DireccionGrado extends Model
{
    protected $table = 'direcciones_grados';
    protected $fillable = [ 'sede_id','grado_id', 'docente_id', 'estado'];


     public static function search($search)
     {
         return empty($search) ? static::query()
             : static::query()->where('id', 'like', '%'.$search.'%')
                 ->orWhere('sede_id', 'like', '%'.$search.'%')
                 ->orWhere('grado_id', 'like', '%'.$search.'%')
                 ->orWhere('docente_id', 'like', '%'.$search.'%');
     }

    public function sede()
    {
        return $this->belongsTo('App\Models\Sede', 'sede_id', );
    }


    public function grado()
    {
        return $this->belongsTo('App\Models\Grado');
    }

    public function docente()
    {
        return $this->belongsTo('App\Models\Docente');
    }

    public static function active(){
        return DireccionGrado::where('estado', 1)->get();
    }

    public static function validarDuplicado($sede, $grado, $docente){
        return DireccionGrado::where('sede_id', $sede)
        ->where('grado_id', $grado)
        ->where('docente_id', $docente)
        ->where('estado', 1)
        ->get();
    }

    public static function getByDocente($docente){
        return DireccionGrado::where('docente_id', $docente)
        ->where('estado', 1)
        ->get();
    }

    public static function getByGrado($grado, $sede){
        return DireccionGrado::where('grado_id', $grado)
        ->where('sede_id', $sede)
        ->where('estado', 1)
        ->first();
    }
}
