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
    @if(!empty($logros))
    @include('livewire.observaciones-finales.logros')
    @endif

    <div class="row">
       <br>
       @include('filtros.filtro3')

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
                                <th>LOGRO N° 1 </th>
                                <td></td>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $index => $item)


                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td style="width: 120px;">
                                    <input type="number" wire:model.defer="logros1.{{ $index }}" class="form-control" min="0" step="1" required>
                                    </td>



                                    <td>
                                        <button type="button" data-toggle="modal" data-animation="bounce" data-target="#logros"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i></button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                    <div class="row">
                        @include('livewire.calificaciones.notificacion')
                    <div class="col-md-12">
                        <div class="form-group">

                            <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-animation="bounce" data-target="#notificacion"   ><span class="ai-search"></span>GUARDAR</button>

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

