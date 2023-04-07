@extends('layouts.app')
@section('titulo')
    REPORTE DE NOTAS
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">REPORTE DE NOTAS DE PERIODO</h4>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-12 col-xl-12">
    <form method="POST" action="{{ route('reporte.notas') }}" target="_blanck">
    @csrf
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title">CONSULTA DE INFORMACION</h4>
            <div class="row">
                @if(count($sedes)>0)
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-2" class="control-label"><b>SEDE</b></label>
                       <select  class="form-control" name="sede">
                           <option value="">SELECCIONE</option>
                          @foreach ($sedes as $item)
                              <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                          @endforeach
                       </select>
                        @error('sede') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                @endif
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-2" class="control-label"><b>GRADO</b></label>
                      @if(count($sedes)==0)
                      <select  class="form-control" name="grado">
                        <option value="">SELECCIONE</option>
                       @foreach ($grados as $item)
                           <option value="{{ $item->grado->id }}">{{ $item->grado->descripcion }}</option>
                       @endforeach
                    </select>
                     @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                      @else
                      <select  class="form-control" name="grado">
                        <option value="">SELECCIONE</option>
                       @foreach ($grados as $item)
                           <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                       @endforeach
                    </select>
                     @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                      @endif
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-2" class="control-label"><b>PERIODO</b></label>
                       <select  class="form-control" name="periodo">
                           <option value="">SELECCIONE</option>
                          @foreach ($periodos as $item)
                              <option value="{{ $item->id }}">{{ $item->numero}}</option>
                          @endforeach
                       </select>
                        @error('periodo') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-outline-info btn-block" type="submit"><span class="ai-search"></span>BUSCAR</button>
                    </div>
                </div>
            </div>
        </form>
</div>


@endsection


@section('scripts')
@if (session()->get('error'))
<script>
    advertencia("{{ session('error') }}");
</script>
@endif
@endsection

