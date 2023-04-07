@extends('layouts.app')
@section('titulo')
    REGISTRO DE NIVELACIONES
@endsection

@section('content')


@php
$tipo="create";
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">REGISTRO DE NIVELACIONES</h4>
        </div>
    </div>
</div>
<livewire:nivelaciones.registro-nivelacion :tipo="$tipo" />

@endsection


@section('scripts')
@if (session()->get('error'))
<script>
    advertencia("{{ session('error') }}");
</script>
@endif
@endsection

