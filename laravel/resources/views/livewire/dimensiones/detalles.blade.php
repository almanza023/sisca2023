<div>


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
                                <th>LOGRO N° 1 </th>
                                <th>LOGRO N° 2 </th>
                                <th>LOGRO N° 3 </th>
                                <th>LOGRO N° 4 </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($calificaciones as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td>
                                       {{ $item->logro_a }}
                                    </td>
                                    <td>
                                        {{ $item->logro_b }}
                                     </td>
                                     <td>
                                        {{ $item->logro_c }}
                                     </td>
                                     <td>
                                        {{ $item->logro_d }}
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
                            <a href="{{ route('dimensiones.create') }}" class="btn btn-outline-success btn-block" ><span class="ai-search"></span>ACEPTAR</a>
                            @else
                            <a href="{{ route('dimensiones.edit') }}" class="btn btn-outline-success btn-block" ><span class="ai-search"></span>ACEPTAR</a>

                            @endif
                        </div>
                    </div>

                </div>

            </div>
            </div>
        </div>
        @endif
    </div>

