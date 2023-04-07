<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogroObservacion extends Model
{


    protected $table = 'logros_observaciones';
    protected $fillable = ['sede_id', 'grado_id', 'descripcion','estado'];


    public function grado()
    {
        return $this->belongsTo('App\Models\Grado', 'grado_id');
    }

    public function sede()
    {
        return $this->belongsTo('App\Models\Sede', 'sede_id');
    }

    public static function filtro($sede, $grado){

        return LogroObservacion::where('grado_id', $grado)
        ->where('sede_id', $sede)
        ->orderBy('id', 'asc')->get();
    }

}
