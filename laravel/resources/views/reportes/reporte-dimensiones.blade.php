
@extends('layouts.app')
@section('titulo')
        REPORTE CALIFICACION DE DIMENSIONES
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">REPORTE CALIFICACION DE DIMENSIONES DE PERIODO</h4>
        </div>
    </div>
</div>
<livewire:reportes.reporte-dimensiones />

@endsection


