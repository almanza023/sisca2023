<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromedioAsignatura extends Model
{

    protected $table = 'promedios_asignaturas';
    protected $fillable = ['sede_id', 'grado_id', 'asignatura_id', 'periodo_id', 'valor', 'ganados', 'perdidos'];



}
