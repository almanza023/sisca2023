@extends('layouts.app')
@section('titulo')
   DETALLES DE NIVELACIONES
@endsection

@section('content')

<livewire:nivelaciones.detalles-nivelacion :post="$data">


@endsection
