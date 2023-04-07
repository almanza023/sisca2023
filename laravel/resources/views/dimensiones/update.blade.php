@extends('layouts.app')
@section('titulo')
    ACTUALIZACION DE CALIFICACIONES DIMENSIONES
@endsection
@section('content')
@php
$tipo="update";
@endphp
<!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">ACTUALIZACION CALIFICACION DE DIMENSIONES</h4>
                        </div>
                    </div>
                </div>
<livewire:dimensiones.registro :tipo="$tipo" />
@endsection
@section('scripts')
@if (session()->get('error'))
<script>
    advertencia("{{ session('error') }}");
</script>
@endif
@endsection

