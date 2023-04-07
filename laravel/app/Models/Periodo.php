<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{


    protected $table = 'periodos';
    protected $fillable = ['descripcion', 'numero', 'porcentaje'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%')
                ->orWhere('numero', 'like', '%'.$search.'%');
    }

    public static function active(){
        return Periodo::where('estado', 1)->get();
    }

}
