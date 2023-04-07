<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif


        @include('livewire.calificaciones.ver-notas')


    <div class="row">
       @include('filtros.filtro3')
        @if(!empty($matriculas))

        <div class="col-md-12 col-lg-12 col-xl-12" >
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO DE ESTUDIANTES</h4>
                    <h5>ESTUDIANTES ACTIVOS: {{ $total }}</h5>
                    <h5>PERIODO: {{ $periodo }}</h5>
                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>ESTUDIANTE</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td>


                                         <a class="btn btn-success" href="{{ route('calificaciones-individual', $item->id) }}">
                                            Calificar
                                        </a>
                                    </td>

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

