@extends('layouts.app')
@section('titulo')
    ACTUALIZACION DE CONVIVENCIA ESCOLAR
@endsection
@section('content')
@php
$tipo="update";
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">ACTUALIZACIÓN DE CONVIVENCIA ESCOLAR</h4>
        </div>
    </div>
</div>
<livewire:convivencia.registro-convivencia :tipo="$tipo" />
@endsection
@section('scripts')
@if (session()->get('error'))
<script>
    advertencia("{{ session('error') }}");
</script>
@endif
@endsection

