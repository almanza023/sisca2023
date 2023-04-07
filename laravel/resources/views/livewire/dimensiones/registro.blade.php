<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    @if(!empty($logros))
    @include('livewire.dimensiones.logros')
    @endif
    @if(!empty($anteriores))
    @include('livewire.dimensiones.periodoAnterior')
    @endif
    <div class="row">

       @include('filtros.filtro')

        @if(!empty($matriculas))
        <div class="col-md-12 col-lg-12 col-xl-12" >
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO DE ESTUDIANTES</h4>
                    <h5>{{ $asignatura_nombre }}</h5>
                    <h5>ESTUDIANTES ACTIVOS: {{ $total }}</h5>
                    <h5>PERIODO: {{ $periodo }}</h5>

                    @if($tipo=='create')
                    <form action="{{ route('dimensiones.store') }}" method="POST">
                    @else
                    <form action="{{ route('dimensiones.update') }}" method="POST">
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
                                <th>LOGRO N° 1 </th>
                                <th>LOGRO N° 2 </th>
                                <th>LOGRO N° 3 </th>
                                <th>LOGRO N° 4 </th>
                                <td></td>
                                @if($periodo>1 && $tipo=='create')
                                <th>PERIODO ANTERIOR</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $item)

                                <tr>

                                    <input type="hidden" name="matriculas[]" class="form-control" value="{{ $item->id }}" required>

                                   <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td style="width: 120px;">
                                        @if($tipo=='create')
                                        <input type="number" name="logros1[]" class="form-control" min="0" step="1" required>

                                        @else
                                       <input type="number" name="logros1[]" class="form-control" min="0" step="1" value={{ $item->logro_a }} required>

                                        @endif
                                    </td>
                                    <td style="width: 120px;">
                                        @if($tipo=='create')
                                        <input type="number" name="logros2[]" class="form-control" min="0" step="1" required>
                                        @else
                                       <input type="number" name="logros2[]" class="form-control" min="0" step="1" value={{ $item->logro_b }} required>
                                        @endif
                                    </td>
                                    <td style="width: 120px;">
                                        @if($tipo=='create')
                                        <input type="number" name="logros3[]" class="form-control" min="0" step="1" required>
                                        @else
                                       <input type="number" name="logros3[]" class="form-control" min="0" step="1" value={{ $item->logro_c }} required>
                                        @endif
                                    </td>
                                    <td style="width: 120px;">
                                        @if($tipo=='create')
                                        <input type="number" name="logros4[]" class="form-control" min="0" step="1" >
                                        @else
                                       <input type="number" name="logros4[]" class="form-control" min="0" step="1" value={{ $item->logro_d }} >
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-animation="bounce" data-target="#logros"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i></button>

                                    </td>
                                    @if($periodo>1 && $tipo=='create')
                                    <td>
                                        <button type="button" wire:click="show({{ $item->id }})" data-toggle="modal" data-animation="bounce" data-target="#periodoAnterior"  class="btn btn-info btn-sm"><i class="typcn typcn-eye-outline"></i> </button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
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

