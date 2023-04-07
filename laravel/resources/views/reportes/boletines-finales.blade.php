@extends('layouts.app')
@section('titulo')
    REPORTE DE BOLETINES FINALES
@endsection

@section('content')


@php
$tipo="create";
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">REPORTE DE BOLETINES DE FINALES</h4>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-12 col-xl-12">
    <form method="POST" action="../pdf/reporteFinal1.php" target="_blanck">
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title">GENERAR BOLETINES FINALES GRADOS  (1° - 2°)</h4>
            <div class="row">
                @if(count($sedes)>0)
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-2" class="control-label"><b>GRADO</b></label>

                      <select  class="form-control" name="grado">
                        <option value="">SELECCIONE</option>
                        @foreach ($grados as $item)
                        @if ($item->id>=3 && $item->id<=4)
                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                        @endif
                      @endforeach
                    </select>
                     @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>                 </div>
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

<div class="col-md-12 col-lg-12 col-xl-12">
    <form method="POST" action="../pdf/reporteFinal2.php" target="_blanck">
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title">GENERAR BOLETINES FINALES GRADOS  (3° - 5°)</h4>
            <div class="row">
                @if(count($sedes)>0)
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="field-2" class="control-label"><b>GRADO</b></label>
                            <select  class="form-control" name="grado">
                              <option value="">SELECCIONE</option>
                             @foreach ($grados as $item)
                               @if ($item->id>4 && $item->id<8)
                               <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                               @endif
                             @endforeach
                          </select>
                           @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                          </div>
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
<div class="col-md-12 col-lg-12 col-xl-12">
    <form method="POST" action="../pdf/reporteFinal3.php" target="_blanck">
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title">GENERAR BOLETINES FINALES GRADOS (6°-11°)</h4>
            <div class="row">
               <input type="hidden" value="1" name="sede">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-2" class="control-label"><b>GRADO</b></label>
                      <select  class="form-control" name="grado">
                        <option value="">SELECCIONE</option>
                        @foreach ($grados as $item)
                        @if ($item->id>=8)
                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                        @endif
                      @endforeach
                    </select>
                     @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror

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

