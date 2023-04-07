@extends('layouts.app')
@section('titulo')
    CONSULTA DE CALIFICACIONES
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">CONSULTA CALIFICACION DE DIMENSIONES</h4>
        </div>
    </div>
</div>
<livewire:calificaciones.show />

@endsection




