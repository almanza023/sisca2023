@extends('layouts.app')
@section('titulo')
    CALIFICACIONES INDIVIDUALES
@endsection

@section('content')
<livewire:calificaciones.calificacion-individual :iid="$id"  />

@endsection
