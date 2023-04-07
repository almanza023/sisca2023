<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLogro extends Model
{


    protected $table = 'tipo_logros';
    protected $fillable = ['nombre', 'nivel'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('nivel', 'like', '%'.$search.'%');
    }

    public static function active(){
        return TipoLogro::where('estado', 1)->get();
    }
    
     public static function secundaria(){
        return TipoLogro::where('estado', 1)->where('id',2)->orWhere('id',3)->get();
    }
}
