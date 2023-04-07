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
                                <th>LOGRO </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($calificaciones as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td>
                                       {{ $item->logro }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th><center>No existen datos</center></th>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            @if($tipo=='create')
                            <a href="{{ route('convivencia.create') }}" class="btn btn-outline-success btn-block" ><span class="ai-search"></span>ACEPTAR</a>
                            @else
                            <a href="{{ route('convivencia.edit') }}" class="btn btn-outline-success btn-block" ><span class="ai-search"></span>ACEPTAR</a>

                            @endif
                        </div>
                    </div>

                </div>

            </div>
            </div>
        </div>
        @endif
    </div>

