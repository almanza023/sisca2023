@extends('layouts.app')
@section('titulo')
   DETALLES DE CONVIVENCIA ESCOLAR
@endsection

@section('content')

<livewire:convivencia.detalles-convivencia :post="$data">


@endsection
