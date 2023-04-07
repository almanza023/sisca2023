@extends('layouts.app')
@section('titulo')
    REGISTRO DE CONVIVENCIA ESCOLAR
@endsection

@section('content')


@php
$tipo="create";
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">REGISTRO CONVIVENCIA ESCOLAR</h4>
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

