<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {

    Route::get('/','Auth\LoginController@showLoginForm')->name('view.login');
    Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
    Route::get('/registrar','Auth\LoginController@register')->name('register');
    Route::post('/login', 'Auth\LoginController@login')->name('login');


});

Route::middleware(['admin'])->group(function () {

    Route::get('asignaturas','ViewController@asignaturas')->name('asignaturas');
    Route::get('personal','ViewController@docentes')->name('personal');
    Route::get('grados','ViewController@grados')->name('grados');
    Route::get('sedes','ViewController@sedes')->name('sedes');
    Route::get('periodos','ViewController@periodos')->name('periodos');
    Route::get('tipo-asignaturas','ViewController@tipoAsignaturas')->name('tipo-asignaturas');
    Route::get('tipo-logros','ViewController@tipoLogros')->name('tipo-logros');
    Route::get('usuarios','ViewController@usuarios')->name('usuarios');
    Route::get('direccion-grados','ViewController@direccionGrados')->name('direcciones-grados');
    Route::get('matriculas','ViewController@matriculas')->name('matriculas');
    Route::get('matriculas/registro','ViewController@createMatriculas')->name('matriculas.create');
    Route::get('carga-academicas/registro','ViewController@createCarga')->name('carga.create');
    Route::get('carga-academicas','ViewController@cargaAcademicas')->name('carga-academicas');
    Route::get('apertura-periodos','ViewController@aperturaPeridos')->name('apertura-periodos');
    Route::get('reportes/boletines','ReporteController@boletines')->name('reporte-boletines');
    Route::get('reportes/boletines-finales','ReporteController@boletinesFinales')->name('reporte-boletines-finales');

    Route::post('reportes/boletines','Reportes\BoletinController@boletines')->name('report.boletines');
    Route::post('reportes/generar/boletines-finales','Reportes\BoletinController@boletinesFinales')->name('report.boletines-finales');

    Route::get('reportes/estadisticas','ReporteController@estadisticas')->name('view-estadisticas');
    Route::get('reportes/consolidados','ReporteController@consolidados')->name('view-consolidados');
    Route::post('reportes/consolidados','ReporteController@reporteConsolidados')->name('report.consolidados');

    Route::post('reporte/estadisticas','ReporteController@ReportEstadisticas')->name('report.estadisticas');

    Route::get('individual/periodo','ViewController@individualPeriodo')->name('individual-periodo');
    Route::get('estudiantes/editar','ViewController@estudiantesEditar')->name('estudiantes-editar');
    Route::get('calificaciones/estudiantes','ViewController@calificacionesEstudiantes')->name('calificaciones-estudiantes');
    Route::get('calificaciones/individual/{id}','ViewController@calificacionesIndividual')->name('calificaciones-individual');
    Route::post('calificaciones/individual/store','CalificacionController@individual')->name('individual.store');


});

Route::group(['middleware' => ['auth']], function () {
Route::get('home','HomeController@index')->name('home');
Route::get('perfil','ViewController@perfil')->name('perfil');
Route::get('logros-academicos','ViewController@logrosAcademicos')->name('logros-academicos');
Route::get('logros-preescolar','ViewController@logrosPreescolar')->name('logros-preescolar');
Route::get('logros-disciplinarios','ViewController@logrosDisciplinarios')->name('logros-disciplinarios');
Route::get('logros-observaciones','ViewController@logrosObservaciones')->name('logros-observaciones');

Route::get('calificaciones/registro','ViewController@createCalificaciones')->name('calificaciones.create');
Route::get('calificaciones/ver','ViewController@showCalificaciones')->name('calificaciones.show');
Route::get('calificaciones/generales','ViewController@calificacionesGenerales')->name('calificaciones.generales');
Route::get('calificaciones/actualizar','ViewController@updateCalificaciones')->name('calificaciones.edit');


Route::get('nivelaciones/registro','ViewController@createNivelacion')->name('nivelaciones.create');
Route::get('nivelaciones/ver','ViewController@showNivelacion')->name('nivelaciones.show');
Route::get('nivelaciones/actualizar','ViewController@updateNivelacion')->name('nivelaciones.edit');

Route::get('nivelaciones-finales/registro','ViewController@nivelacionesFinales')->name('nivelaciones-finales.create');
Route::get('nivelaciones-finales/ver','ViewController@verNivelacionesFinales')->name('nivelaciones-finales.show');


Route::get('dimensiones/registro','ViewController@createDimensiones')->name('dimensiones.create');
Route::get('dimensiones/ver','ViewController@showDimensiones')->name('dimensiones.show');
Route::get('dimensiones/actualizar','ViewController@updateDimensiones')->name('dimensiones.edit');

Route::get('observaciones-finales','ViewController@observacionesFinales')->name('observaciones-finales');

Route::get('convivencia/registro','ViewController@createConvivencia')->name('convivencia.create');
Route::get('convivencia/ver','ViewController@showConvivencia')->name('convivencia.show');
Route::get('convivencia/actualizar','ViewController@updateConvivencia')->name('convivencia.edit');

Route::post('calificaciones/guardar','CalificacionController@store')->name('calificaciones.store');
Route::post('calificaciones/update','CalificacionController@update')->name('calificaciones.update');

Route::post('dimensiones/guardar','CalificacionDimensionesController@store')->name('dimensiones.store');
Route::post('dimensiones/update','CalificacionDimensionesController@update')->name('dimensiones.update');

Route::post('nivelaciones/guardar','NivelacionController@store')->name('nivelaciones.store');
Route::post('nivelaciones/update','NivelacionController@update')->name('nivelaciones.update');

Route::post('convivencia/guardar','ConvivenciaController@store')->name('convivencia.store');
Route::post('convivencia/update','ConvivenciaController@update')->name('convivencia.update');
 Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

 Route::get('reportes/boletines/preescolar','Reportes\BoletinPreescolarController@index')->name('reporte-boletines-preescolar');
 Route::post('reportes/boletines-preescolar','Reportes\BoletinPreescolarController@boletines')->name('boletines-preescolar');

 Route::get('reportes/dimensiones','ViewController@reporteDimensiones')->name('view-reporte-dimensiones');

 Route::post('reportes/dimensiones','ReporteController@ReporteDimensiones')->name('reporte-dimensiones');

 Route::get('reportes/notas-periodos','ViewController@reporteNotas')->name('view-reporte-notas');
 Route::get('reportes/notas/{sede}/{grado}/{asignatura}/{periodo}','ReporteController@ReporteNotas')->name('reporte.notas');


});










