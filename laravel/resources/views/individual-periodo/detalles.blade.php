@extends('layouts.app')
@section('titulo')
   DETALLES DE CALIFICACIONES
@endsection

@section('content')

<livewire:calificaciones.detalles :post="$data">


@endsection
