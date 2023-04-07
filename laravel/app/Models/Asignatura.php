<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{

    protected $table = 'asignaturas';
    protected $fillable = ['nombre', 'acronimo', 'tipo_asignatura_id'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('acronimo', 'like', '%'.$search.'%')
                ->orWhere('tipo_asignatura_id', 'like', '%'.$search.'%');
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper($value);
    }

    public function setAcronimoAttribute($value)
    {
        $this->attributes['acronimo'] =strtoupper($value);
    }




    public function tipo()
    {
        return $this->belongsTo('App\Models\TipoAsignatura', 'tipo_asignatura_id', );
    }

    public static function active(){
        return Asignatura::where('estado', 1)->get();
    }







}
