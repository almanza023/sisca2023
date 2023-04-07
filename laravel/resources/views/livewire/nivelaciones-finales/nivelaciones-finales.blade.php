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



                    <form wire:submit.prevent="store">

                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>ESTUDIANTE</th>
                                <th>PERIODO 1 </th>
                                <th>PERIODO 2 </th>
                                <th>PERIODO 3 </th>
                                <th>PERIODO 4 </th>
                                <th>NOTA FINAL</th>
                                <th>NOTA NIVELACION FINAL</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $index => $item)
                                @php
                                    $nota=$item['nivelacion'];
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['estudiante'] }}</td>
                                    <td>{{ $item['periodo1'] }}</td>
                                    <td>{{ $item['periodo2'] }}</td>
                                    <td>{{ $item['periodo3'] }}</td>
                                    <td>{{ $item['periodo4'] }}</td>
                                   @if($item['promedio']>0 && $item['promedio']<3)
                                       <td class="bg-danger">{{ $item['promedio'] }}</td>
                                    @elseif($item['promedio']>=3 && $item['promedio']<4)
                                    <td class="bg-warning">{{ $item['promedio'] }}</td>
                                    @elseif($item['promedio']>=4 && $item['promedio']<4.5)
                                    <td class="bg-info">{{ $item['promedio'] }}</td>
                                    @else
                                    <td class="bg-success">{{ $item['promedio'] }}</td>
                                   @endif
                                 @if ($item['promedio']<3)
                                 <td>
                                    <input type="number" wire:model.defer="notas1.{{ $index }}" class="form-control" min="0" step="0.1" max="3" value="{{ $nota }}" required>
                                    </td>
                                 @endif
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                    <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-success btn-block"   ><span class="ai-search"></span>GUARDAR</button>

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
