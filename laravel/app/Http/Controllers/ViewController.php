<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function home()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function asignaturas()
    {
        return view('asignaturas.index');
    }

    public function docentes()
    {
        return view('docentes.index');
    }

    public function grados()
    {
        return view('grados.index');
    }

    public function sedes()
    {
        return view('sedes.index');
    }

    public function periodos()
    {
        return view('periodos.index');
    }

    public function tipoAsignaturas()
    {
        return view('tipo-asignaturas.index');
    }

    public function tipoLogros()
    {
        return view('tipo-logros.index');
    }

    public function usuarios()
    {
        return view('usuarios.index');
    }

    public function matriculas()
    {
        return view('matriculas.index');
    }

    public function perfil()
    {
        return view('perfil.index');
    }

    public function aperturaPeridos()
    {
        return view('apertura-periodos.index');
    }



    public function createMatriculas()
    {
        return view('matriculas.create');
    }

    public function createCalificaciones()
    {
        return view('calificaciones.create');
    }



    public function updateCalificaciones()
    {
        return view('calificaciones.update');
    }

    public function showCalificaciones()
    {
        return view('calificaciones.show');
    }

    public function createNivelacion()
    {
        return view('nivelaciones.create');
    }

    public function updateNivelacion()
    {
        return view('nivelaciones.update');
    }

    public function showNivelacion()
    {
        return view('nivelaciones.show');
    }

    public function observacionesFinales()
    {
        return view('observaciones-finales.index');
    }


    public function createDimensiones()
    {
        return view('dimensiones.create');
    }

    public function updateDimensiones()
    {
        return view('dimensiones.update');
    }

    public function showConvivencia()
    {
        return view('convivencia.show');
    }
    public function createConvivencia()
    {
        return view('convivencia.create');
    }

    public function updateConvivencia()
    {
        return view('convivencia.update');
    }



    public function showDimensiones()
    {
        return view('dimensiones.show');
    }

    public function logrosAcademicos()
    {
        return view('logros-academicos.index');
    }

    public function logrosPreescolar()
    {
        return view('logros-preescolar.index');
    }

    public function logrosObservaciones()
    {
        return view('logros-observaciones.index');
    }

    public function logrosDisciplinarios()
    {
        return view('logros-disciplinarios.index');
    }

    public function createCarga()
    {
        return view('carga_academicas.create');
    }
    public function cargaAcademicas()
    {
        return view('carga_academicas.index');
    }

    public function direccionGrados()
    {
        return view('direcciongrados.index');
    }

    public function individualPeriodo()
    {
        return view('individual-periodo.index');
    }

    public function reporteDimensiones()
    {
        return view('reportes.reporte-dimensiones');
    }

    public function nivelacionesFinales()
    {
        return view('nivelaciones-finales.index');
    }

    public function verNivelacionesFinales()
    {
        return view('nivelaciones-finales.consultar');
    }

    public function estudiantesEditar()
    {
        return view('estudiantes.editar');
    }

    public function calificacionesEstudiantes()
    {
        return view('calificaciones.cal-estudiantes');
    }

    public function calificacionesGenerales()
    {
        return view('calificaciones.cal-generales');
    }

    public function calificacionesIndividual($id)
    {
        return view('calificaciones.cal-individual', compact('id'));
    }

    public function reporteNotas()
    {
        return view('reportes.notas');
    }

}
