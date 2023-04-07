<?php

namespace App\Http\Controllers;

use App\Models\AperturaPeriodo;
use App\Models\DireccionGrado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user='';
        $grupos='';
        $aperturas='';
        $fechasPeriodos='';

        if(Auth::check()){
            $user=auth()->user();
           if($user->tipo==1){
            $grupos=DireccionGrado::getByDocente($user->usable_id);
            if(empty($grupos)){
                $grupos='';
            }
           }
        }
        $fechasPeriodos=AperturaPeriodo::active();

        return view('home', compact('user', 'grupos', 'fechasPeriodos'));
    }


}
