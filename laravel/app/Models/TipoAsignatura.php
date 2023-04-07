<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAsignatura extends Model
{

    protected $table = 'tipo_asignaturas';
    protected $fillable = ['nombre'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%');


    }

    public static function active(){
        return TipoAsignatura::where('estado', 1)->get();
    }

}
