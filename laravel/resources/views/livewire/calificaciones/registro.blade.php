<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    @if(!empty($logrosAcademicos))
    @include('livewire.calificaciones.logros-academicos')
    @endif
    @if(!empty($logrosAfectivos))
    @include('livewire.calificaciones.logros-afectivos')
    @endif
    <div class="row">
       @include('filtros.filtro')
        @if(!empty($matriculas))

        <div class="col-md-12 col-lg-12 col-xl-12" >
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO DE ESTUDIANTES</h4>
                    <h5>{{ $asignatura_nombre }}</h5>
                    <h5>ESTUDIANTES ACTIVOS: {{ $total }}</h5>
                    <h5>PERIODO: {{ $periodo }}</h5>

                    @if($tipo=='create')
                    <form action="{{ route('calificaciones.store') }}" method="POST">
                    @else
                    <form action="{{ route('calificaciones.update') }}" method="POST">
                    @endif
                        <input type="hidden" name="asignatura" value="{{ $asignatura }}">
                        <input type="hidden" name="periodo" value="{{ $periodo }}">
                        <input type="hidden" name="sede" value="{{ $sede }}">
                        <input type="hidden" name="grado" value="{{ $grado }}">
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                    @csrf
                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>ID</th>
                                <th>ESTUDIANTE</th>
                                <th>LOGRO AFECTIVO - EXPRESIVO </th>
                                <td></td>
                                <th>NOTA</th>
                                @if(count($anteriores)>0 && $tipo=='create')
                                    <th>NOTA PERIODO ANTERIOR</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $item)

                                <tr>

                                    <input type="hidden" name="matriculas[]" class="form-control" value="{{ $item->id }}" required>

                                   <td>{{ $loop->iteration }}</td>
                                   <td>{{ $item->id }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td>
                                        @if($tipo=='create')
                                            @if($periodo==4)
                                            <input type="number" value="0"  name="logroAfe[]" class="form-control" min="0" step="1" required>
                                            @else
                                            <input type="number"  name="logroAfe[]" class="form-control" min="0" step="1" required>
                                            @endif
                                        @else
                                       <input type="number" name="logroAfe[]" class="form-control" min="0" step="1" value={{ $item->logro_afectivo }} required>
                                        @endif

                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-animation="bounce" data-target="#afectivo"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i></button>

                                    </td>
                                    <td>
                                        @if($tipo=='create')
                                        <input type="number" name="notas[]" class="form-control" min="1" step="0.1" max="5"  required>
                                        @else
                                        <input type="number" name="notas[]" class="form-control" min="1" step="0.1" max="5" value="{{ $item->nota }}" required>
                                        @endif
                                    </td>
                                    @if(count($anteriores)>0 && $tipo=='create')
                                       @foreach ($anteriores as $ant)
                                           @if($item->id==$ant['matricula_id'] )
                                             @if($ant['nota']>=1 && $ant['nota']<=2.99)
                                             <td class="table-danger">{{ number_format($ant['nota'], 1) }} DESEMPEÑO BAJO</td>
                                             @elseif($ant['nota']>=3 && $ant['nota']<=3.99)
                                             <td class="table-warning">{{ number_format($ant['nota'], 1)  }} DESEMPEÑO BASICO</td>
                                             @elseif($ant['nota']>=4 && $ant['nota']<=4.499)
                                             <td class="table-info">{{ number_format($ant['nota'], 1)  }} DESEMPEÑO ALTO</td>
                                             @elseif($ant['nota']>=4.5 && $ant['nota']<=5)
                                             <td class="table-success">{{ number_format($ant['nota'], 1)  }} DESEMPEÑO SUPERIOR</td>
                                             @else
                                             <td ></td>
                                             @endif
                                           @endif

                                       @endforeach

                                    @endif
                                </tr>

                            @endforeach
                            <tr>
                                <th colspan="2">LOGRO COGNITIVO</th>
                                <td>
                                    @if($tipo=='create')
                                        @if($periodo==4)
                                        <input type="number" value='0' name="logroCog" class="form-control" min="0" step="1" required>
                                        @else
                                        <input type="number" name="logroCog" class="form-control" min="0" step="1" required>
                                        @endif
                                    @else
                                    <input type="number" name="logroCog" class="form-control" min="0" step="1" value="{{ $item->logro_cognitivo }}" required>
                                    @endif


                                </td>
                                <td>
                                    <button type="button" data-toggle="modal" data-animation="bounce" data-target="#cognitivo"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i></button>

                                </td>
                            </tr>
                        </tbody>


                    </table>
                    <div class="row">
                        @include('livewire.calificaciones.notificacion')
                    <div class="col-md-12">
                        <div class="form-group">
                            @if($tipo=='create')
                            <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-animation="bounce" data-target="#notificacion"   ><span class="ai-search"></span>GUARDAR</button>
                            @else
                            <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-animation="bounce" data-target="#notificacion"   ><span class="ai-search"></span>ACTUALIZAR</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

                </div>

            </div>
            </div>
        </div>
        @endif
    </div>

