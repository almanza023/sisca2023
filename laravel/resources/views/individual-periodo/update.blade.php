@extends('layouts.app')
@section('titulo')
    ACTUALIZACION DE CALIFICACIONES
@endsection
@section('content')
@php
$tipo="update";
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">ACTUALIZACIÓN DE CALIFICACIONES</h4>
        </div>
    </div>
</div>
<livewire:calificaciones.registro-calificacion-componet :tipo="$tipo" />
@endsection
@section('scripts')
@if (session()->get('error'))
<script>
    advertencia("{{ session('error') }}");
</script>
@endif
@endsection

