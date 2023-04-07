<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{

    protected $table = 'sedes';
    protected $fillable = ['nombre', 'direccion', 'telefono', 'dane', 'estado'];


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('direccion', 'like', '%'.$search.'%')
                ->orWhere('telefono', 'like', '%'.$search.'%')
                ->orWhere('dane', 'like', '%'.$search.'%');

    }

    public static function active(){
        return Sede::where('estado', 1)->get();
    }
}
