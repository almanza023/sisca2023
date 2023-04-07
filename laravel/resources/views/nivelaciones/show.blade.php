@extends('layouts.app')
@section('titulo')
    CONSULTA DE NIVELACIONES
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">CONSULTA NIVELACIONES DE PERIODO</h4>
        </div>
    </div>
</div>
<livewire:nivelaciones.show-nivelacion />

@endsection




