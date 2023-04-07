<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CargaAcademica;
use App\Models\DetalleEntrega;
use App\Models\Entrega;
use App\Models\Grado;
use App\Models\Matricula;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function grados(){
        $grados=Grado::secundariosActive();
        return response()->json($grados);
    }

    public function matriculas($id){
        if(empty($id)){
            return response()->json(['status'=>'Grado ests en blanco']);
        }else{
            $matriculas=Matricula::listado2(1, $id);
            return response()->json($matriculas);
        }
    }

    public function asignaturas($id){
        if(empty($id)){
            return response()->json(['status'=>'Grado ests en blanco']);
        } else{
            $obj=DB::table('carga_academicas as c')
            ->join('asignaturas as a', 'a.id', '=', 'c.asignatura_id')
            ->where('c.sede_id', 1)
            ->where('c.grado_id', $id)
            ->get(['a.id', 'a.nombre']);
            return response()->json($obj);
        }
    }
    public function matricula($id){
        if(empty($id)){
            return response()->json(['status'=>'Grado ests en blanco']);
        } else{
            $obj=Matricula::byId($id);
            return response()->json($obj);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asignaturas[]=$request->asignasturas;
        $matricula_id=$request->matricula_id;
        $guia=$request->guia;
        $num=count($asignaturas);

        DB::beginTransaction();
        try {
            $entrega=Entrega::create([
                'matricula_id'=>$matricula_id,
                'fecha'=>Carbon::now()->format('Y-m-d')
            ]);
            for ($i=0; $i < $num; $i++) {
                DetalleEntrega::create([
                    'entrega_id'=>$entrega->id,
                    'asignatura_id'=> $asignaturas[0][$i]
                ]);
             }
            DB::commit();
            return response()->json(['status'=>'success']);

        }
          catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status'=>'No se registrarón los datos', 'details'=>$ex->getMessage()]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
