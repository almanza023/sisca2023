<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{

    protected $table = 'entregas';
    protected $fillable = ['matricula_id', 'guia', 'fecha'];


    public function detalles()
    {
        return $this->belongsToMany('App\Models\Entrega', 'entrega_id', );
    }

    public static function active(){
        return Entrega::where('estado', 1)->get();
    }







}
