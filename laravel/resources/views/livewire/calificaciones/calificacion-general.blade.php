<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif


    <div class="row">
       @include('filtros.filtro1')
        @if(!empty($matriculas))

        <div class="col-md-12 col-lg-12 col-xl-12" >
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO DE ESTUDIANTES</h4>
                    <h5>ESTUDIANTES ACTIVOS: {{ $total }}</h5>
                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>ESTUDIANTE</th>
                                <th>NOTA PERIODO 1</th>
                                <th>NOTA PERIODO 2</th>
                                <th>NOTA PERIODO 3</th>
                                <th>DEFINITIVA TODOS LOS PERIODOS</th>
                                <th>NOTA MINIMA CUARTO PERIDO</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['estudiante'] }}</td>
                                    <td>{{ $item['notap1'] }}</td>
                                    <td>{{ $item['notap2'] }}</td>
                                    <td>{{ $item['notap3'] }}</td>
                                   @if($item['def']>=3)
                                   <td class="bg-success">{{ $item['def'] }}</td>
                                   @else
                                   <td class="bg-danger">{{ $item['def'] }}</td>
                                   @endif
                                    <td>{{ $item['min'] }}</td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>


                </div>

            </div>
            </div>
        </div>
        @endif
    </div>

