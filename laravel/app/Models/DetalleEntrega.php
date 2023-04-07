<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEntrega extends Model
{

    protected $table = 'detalles_entregas';
    protected $fillable = ['entrega_id', 'asignatura_id', 'estado'];


    public function asignatura()
    {
        return $this->belongsTo('App\Models\Asignatura', 'asignatura_id', );
    }

    public static function active(){
        return Entrega::where('estado', 1)->get();
    }







}
