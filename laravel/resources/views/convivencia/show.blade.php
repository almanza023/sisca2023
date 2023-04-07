@extends('layouts.app')
@section('titulo')
    CONSULTA DE CONVIVENCIA ESCOLAR
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">CONSULTA CONVIVENCIA ESCOLAR</h4>
        </div>
    </div>
</div>
<livewire:convivencia.show-convivencia />

@endsection




