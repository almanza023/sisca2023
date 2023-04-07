<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{


    protected $table = 'grados';
    protected $fillable = ['descripcion', 'numero'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%')
                ->orWhere('numero', 'like', '%'.$search.'%');

    }

    public static function active(){
        return Grado::where('estado', 1)->orderBy('id', 'asc')->get();
    }

    public static function preescolarActive(){
        return Grado::where('estado', 1)->where('id', '<','3')->orderBy('id', 'asc')->get();
    }
    public static function secundariosActive(){
        return Grado::where('estado', 1)->where('id', '>=','3')->orderBy('id', 'asc')->get();
    }
}
