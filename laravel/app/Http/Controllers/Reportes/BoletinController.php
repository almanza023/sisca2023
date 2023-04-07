<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Reportes\BoletinCuatro;
use App\Models\Reportes\BoletinDos;
use App\Models\Reportes\BoletinFinalDos;
use App\Models\Reportes\BoletinFinalUno;
use App\Models\Reportes\BoletinTres;
use App\Models\Reportes\BoletinUno;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class BoletinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function boletines(Request $request)
    {
        $validated = $request->validate([
            'sede' => 'required',
            'grado' => 'required',
            'periodo' => 'required',
        ]);

        $grado=$request->grado;
        $sede=$request->sede;
        $periodo=$request->periodo;
        $pdf = app('Fpdf');
        if($grado>=3 && $grado<=4){
            BoletinUno::reporte($sede, $grado, $periodo, $pdf);
        }else if($grado>=5 && $grado<=7){
            BoletinDos::reporte($sede, $grado, $periodo, $pdf);
        }else if($grado>=8 && $grado<=13){
            BoletinTres::reporte($sede, $grado, $periodo, $pdf);
        }
    }


    public function boletinesFinales(Request $request)
    {
        $validated = $request->validate([
            'sede' => 'required',
            'grado' => 'required',
        ]);
        $grado=$request->grado;
        $sede=$request->sede;
        $pdf = app('Fpdf');
        if($grado>=3 && $grado<=4){
            BoletinFinalUno::reporte($sede, $grado, $pdf);
        }else if($grado>=5 && $grado<=7){
            BoletinFinalDos::reporte($sede, $grado, $pdf);
        }else if($grado>=8 && $grado<=13){
            BoletinTres::reporte($sede, $grado, $pdf);
        }
    }



}
