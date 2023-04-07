@extends('layouts.app')
@section('titulo')
    PANEL PRINCIPAL
@endsection
@section('content')
    <div class="row m-t-20">

        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">BIENVENIDO</h1>
                <p class="lead">
                    @if(!empty($user))
                        {{ $user->name }}
                    @endif
                </p>
                <hr class="my-4">
                @php
                    $existe=false;
                @endphp
               @if(!empty($grupos))
               <p>DIRECCIONES DE GRADO</p>
               <ul class="list-group">
                   @foreach ($grupos as $item)
                   @if($item->grado_id==1 || $item->grado_id==2 )
                     @php
                        $existe=true;
                     @endphp
                     @endif
                       <li class="list-group-item m-t-5">{{ $item->grado->descripcion. '('.$item->grado->numero.'°)' }}</li>
                   @endforeach
               </ul>
               @endif
               @if(!empty($fechasPeriodos))
               <ul class="list-group">
                @foreach ($fechasPeriodos as $item)
                    <li class="list-group-item m-t-5">
                        PERIODO: {{ $item->periodo->descripcion }}
                        FECHA APERTURA: {{ $item->fecha_apertura }}
                        FECHA CIERRE: {{ $item->fecha_cierre }}
                    </li>
                @endforeach
                 </ul>

               @endif
               <br>

               @if($existe==false)
               <center>
                <a class="btn btn-primary btn-lg" href="{{ route('calificaciones.create') }}" role="button">NOTAS DE PERIODO</a>
                <a class="btn btn-primary btn-lg" href="{{ route('nivelaciones.create') }}" role="button">NIVELACIONES DE PERIODO</a>
                <a class="btn btn-primary btn-lg" href="{{ route('logros-academicos') }}" role="button">LOGROS ACADEMICOS</a>
                <a class="btn btn-primary btn-lg" href="{{ route('logros-academicos') }}" role="button">LOGROS ACADEMICOS</a>
                <a class="btn btn-primary btn-lg" href="{{ route('calificaciones.generales') }}" role="button">NOTAS ACUMULATIVAS</a>
                @if(!empty($grupos))
                <a class="btn btn-primary btn-lg" href="{{ route('logros-disciplinarios') }}" role="button">LOGROS DISCIPLINARIOS</a>
                @endif
               </center>
               @else
               <center>
                <a class="btn btn-primary btn-lg" href="{{ route('dimensiones.create') }}" role="button">CALIFICACION DE DIMENSIONES</a>
                <a class="btn btn-primary btn-lg" href="{{ route('logros-preescolar') }}" role="button">LOGROS PREESCOLAR</a>

               </center>
               @endif

              </div>
        </div>


    </div>
@endsection
