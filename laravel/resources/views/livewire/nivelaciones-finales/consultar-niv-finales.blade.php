<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif

    <div class="row">
       <br>
       @include('filtros.filtro4')

        @if(!empty($matriculas))
        <div class="col-md-12 col-lg-12 col-xl-12" >
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO DE ESTUDIANTES</h4>

                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>ESTUDIANTE</th>
                                <th>NOTA NIVELACION FINAL </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $item)


                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    @if($item->nota>0 && $item->nota<3)
                                    <td class="bg-danger">{{ $item->nota }}</td>
                                    @elseif($item->nota>=3 && $item->nota<4)
                                    <td class="bg-warning">{{ $item->nota }}</td>
                                    @elseif($item->nota>=4 && $item->nota<4.5)
                                    <td class="bg-info">{{ $item->nota }}</td>
                                    @else
                                    <td class="bg-success">{{ $item->nota }}</td>
                                    @endif

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
