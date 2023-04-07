<?php

namespace App\Http\Controllers;

use App\Models\AperturaPeriodo;
use App\Models\Asignatura;
use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\DireccionGrado;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Nivelacion;
use App\Models\Periodo;
use App\Models\Preescolar;
use App\Models\Puesto;
use App\Models\Reportes\ConsolidadoCuatro;
use App\Models\Reportes\ConsolidadoDos;
use App\Models\Reportes\ConsolidadoUno;
use App\Models\Reportes\ConsolidadoTres;
use App\Models\Reportes\EstadisticaPeriodo;
use App\Models\Reportes\ReporteDimensiones;
use App\Models\Reportes\ReporteNotas;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function boletines()
    {
        $grados=Grado::secundariosActive();
        $sedes=Sede::active();
        $periodos=Periodo::active();
        return view('reportes.boletines', compact('grados', 'sedes', 'periodos'));
    }



    public function boletinesFinales()
    {
        $grados=Grado::secundariosActive();
        $sedes=Sede::active();
        return view('reportes.boletines-finales', compact('grados', 'sedes'));
    }

    public function consolidados()
    {
        $grados=Grado::secundariosActive();
        $sedes=Sede::active();
        $periodos=Periodo::active();
        return view('reportes.consolidados', compact('grados', 'sedes', 'periodos'));
    }

    public function estadisticas()
    {
        $grados=Grado::secundariosActive();
        $sedes=Sede::active();
        $periodos=Periodo::active();
        return view('reportes.estadisticas', compact('grados', 'sedes', 'periodos'));
    }

    public function ReportEstadisticas(Request $request)
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
        $data=Puesto::getPuestos($grado, $periodo);
        if(count($data)>0){
            EstadisticaPeriodo::reporte($pdf, $data, $periodo);
        }else{
            return redirect()->route('reporte-boletines')->with(['warning'=>'PRIMERO DEBE GENERAR LOS BOLETINES']);
        }


    }

    public function ReporteDimensiones(Request $request)
    {
        $data=[];
        $cabecera=[];
        $validated = $request->validate([
            'sede' => 'required',
            'asignatura' => 'required',
            'grado' => 'required',
            'periodo' => 'required',
        ]);
        $partes = explode("-", $request->asignatura);
        $grado=Grado::find($request->grado);
        $sede=Sede::find($request->sede);
        $asignatura=$partes[1];
        $director=DireccionGrado::getByGrado($request->grado, $request->sede);

        $cabecera=[
            'sede'=>$sede->nombre,
            'grado'=>$grado->descripcion,
            'asignatura'=>$asignatura,
            'docente'=>$director->docente->nombres.' '.$director->docente->apellidos
        ];
        $data=Preescolar::calificacionesPeriodo($request->sede, $request->grado, $request->asignatura, $request->periodo);
        $pdf = app('Fpdf');
        ReporteDimensiones::reporte($pdf, $cabecera, $data, $request->periodo);
    }

    public function reporteConsolidados(Request $request){
        $validated = $request->validate([
            'sede' => 'required',
            'grado' => 'required',
            'periodo' => 'required',

        ]);

        $pdf = app('Fpdf');
        $pdf->SetFillColor(232, 232, 232);
        $matriculas=Matricula::listado($request->sede, $request->grado);
        if($request->grado>=3 &&$request->grado<=4){
            ConsolidadoUno::reporte($request->sede, $request->grado, $request->periodo, $pdf, $matriculas);
        } else if($request->grado>=5 &&$request->grado<=7){
            ConsolidadoDos::reporte($request->sede, $request->grado, $request->periodo, $pdf, $matriculas);

        }else if($request->grado>=8 &&$request->grado<=11){
            ConsolidadoTres::reporte($request->sede, $request->grado, $request->periodo, $pdf, $matriculas);
        }
        else {
            ConsolidadoCuatro::reporte($request->sede, $request->grado, $request->periodo, $pdf, $matriculas);
        }


    }

    public function ReporteNotas($sede, $grado, $asignatura, $periodo)
    {
        $data=[];
        $cabecera=[];
        $partes = explode("-", $asignatura);
        $asignaturaNombre=$partes[1];
        $asignatura_id=$partes[0];
        $docente=CargaAcademica::getDocente($sede, $grado, $asignatura_id);
        $data=Calificacion::calificacionesPeriodo($sede, $grado, $asignatura_id, $periodo);
        $grado=Grado::find($grado);
        $sede=Sede::find($sede);




        $cabecera=[
            'sede'=>$sede->nombre,
            'grado'=>$grado->descripcion,
            'asignatura'=>$asignaturaNombre,
            'periodo'=>$periodo,
            'docente'=>$docente->docente->nombres.' '.$docente->docente->apellidos,
        ];

        $pdf = app('Fpdf');


        ReporteNotas::reporte($pdf, $cabecera, $data, $periodo);
    }


}
