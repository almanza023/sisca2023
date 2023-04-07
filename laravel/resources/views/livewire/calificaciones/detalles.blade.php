<div>

    @if(!empty($logrosAcademicos))
    @include('livewire.calificaciones.logros-academicos')
    @endif
    @if(!empty($logrosAfectivos))
    @include('livewire.calificaciones.logros-afectivos')
    @endif
    <div class="row m-t-30">
        @if(!empty($calificaciones))
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO DE ESTUDIANTES</h4>
                    <h5>{{ $calificaciones[0]->nombre }}</h5>
                    <h5>ESTUDIANTES ACTIVOS: {{ $total }}</h5>
                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>ESTUDIANTE</th>
                                <th>LOGRO AFECTIVO - EXPRESIVO </th>
                                <th>NOTA</th>
                                <th>DESEMPEÑO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($calificaciones as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td>
                                       {{ $item->logro_afectivo }}
                                    </td>
                                    <td>
                                       {{ number_format($item->nota, 2) }}
                                    </td>

                                        @if($item->nota>=1 && $item->nota<=2.99)
                                        <td class="table-danger">DESEMPEÑO BAJO</td>
                                        @elseif($item->nota>=3 && $item->nota<=3.99)
                                        <td class="table-warning">DESEMPEÑO BASICO</td>
                                        @elseif($item->nota>=4 && $item->nota<=4.499)
                                        <td class="table-info">DESEMPEÑO ALTO</td>
                                        @elseif($item->nota>=4.5 && $item->nota<=5)
                                        <td class="table-success">DESEMPEÑO SUPERIOR</td>
                                        @else
                                        <td ></td>
                                        @endif
                                </tr>
                            @empty
                                <tr>
                                    <th><center>No existen datos</center></th>
                                </tr>
                            @endforelse
                            <tr>
                                <th colspan="2">LOGRO COGNITIVO</th>
                                <td>
                                   {{ $item->logro_cognitivo }}
                                </td>

                            </tr>
                        </tbody>

                    </table>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            @if($tipo=='create')
                            <a href="{{ route('calificaciones.create') }}" class="btn btn-outline-success btn-block" ><span class="ai-search"></span>ACEPTAR</a>
                            @else
                            <a href="{{ route('calificaciones.edit') }}" class="btn btn-outline-success btn-block" ><span class="ai-search"></span>ACEPTAR</a>

                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="{{url('reportes/notas', ['sede' => $sede, 'grado' => $grado, 'asignatura' => $asignatura, 'periodo'=>$periodo])}}" class="btn btn-outline-info btn-block" ><span class="ai-search"></span>DESCARGAR PLANILLA</a>
                    </div>

                </div>

            </div>
            </div>
        </div>
        @endif
    </div>

