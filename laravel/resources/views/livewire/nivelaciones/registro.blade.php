<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
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
                    <form action="{{ route('nivelaciones.store') }}" method="POST">
                    @else
                    <form action="{{ route('nivelaciones.update') }}" method="POST">
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
                                <th>ESTUDIANTE</th>
                                @if($tipo=='create')
                                <th>NOTA DE PERIODO</th>
                                @endif
                                <th>NOTA</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $item)

                                <tr>

                                   <input type="hidden" name="matriculas[]" class="form-control" value="{{ $item->id }}" required>
                                   <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                   @if($tipo=='create')
                                   @if($item->nota>=1 && $item->nota<=2.99)
                                   <td class="table-danger">{{ number_format($item->nota, 1) }} DESEMPEÑO BAJO</td>
                                   @elseif($item->nota>=3 && $item->nota<=3.99)
                                   <td class="table-warning">{{ number_format($item->nota, 1)  }} DESEMPEÑO BASICO</td>
                                   @elseif($item->nota>=4 && $item->nota<=4.499)
                                   <td class="table-info">{{ number_format($item->nota, 1)  }} DESEMPEÑO ALTO</td>
                                   @elseif($item->nota>=4.5 && $item->nota<=5)
                                   <td class="table-success">{{ number_format($item->nota, 1)  }} DESEMPEÑO SUPERIOR</td>
                                   @else
                                   <td ></td>
                                   @endif
                                   @endif
                                    <td>
                                        @if($tipo=='create')
                                        <input type="number" name="notas[]" class="form-control" min="1" step="0.1" max="3" required>
                                        @else
                                        <input type="number" name="notas[]" class="form-control" min="1" step="0.1" max="3" value="{{ $item->nota }}" required>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                    <div class="row">
                        @include('livewire.nivelaciones.notificacion')
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

