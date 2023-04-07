@extends('layouts.app')
@section('titulo')
   DETALLES DE CALIFICACIONES DIMENSIONES
@endsection

@section('content')

<livewire:dimensiones.detalles-dimensiones :post="$data">


@endsection
