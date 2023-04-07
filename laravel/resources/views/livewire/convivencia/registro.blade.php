<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    @if(!empty($logros))
    @include('livewire.convivencia.logros')
    @endif

    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">CONSULTA DE INFORMACION</h4>
                    <div class="row">
                        @if(count($sedes)>0)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label"><b>SEDE</b></label>
                               <select  class="form-control" wire:model.defer="sede">
                                   <option value="">SELECCIONE</option>
                                  @foreach ($sedes as $item)
                                      <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                  @endforeach
                               </select>
                                @error('sede') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label"><b>GRADO</b></label>
                              @if(count($sedes)==0)
                              <select  class="form-control" wire:model="grado">
                                <option value="">SELECCIONE</option>
                               @foreach ($grados as $item)
                                   <option value="{{ $item->grado->id }}">{{ $item->grado->descripcion }}</option>
                               @endforeach
                            </select>
                             @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                              @else
                              <select  class="form-control" wire:model="grado">
                                <option value="">SELECCIONE</option>
                               @foreach ($grados as $item)
                                   <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                               @endforeach
                            </select>
                             @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                              @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label"><b>ASIGNATURA</b></label>
                               <select  class="form-control" wire:model.defer="asignatura">
                                <option value="">SELECCIONE</option>
                                <option value="29-DISCIPLINA">DISCIPLINA</option>

                               </select>
                                @error('asignatura') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label"><b>PERIODO</b></label>
                               <select  class="form-control" wire:model.defer="periodo">
                                   <option value="">SELECCIONE</option>
                                  @foreach ($periodos as $item)
                                      <option value="{{ $item->id }}">{{ $item->numero}}</option>
                                  @endforeach
                               </select>
                                @error('periodo') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-outline-info btn-block" wire:click="buscar()"><span class="ai-search"></span>BUSCAR</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @if(!empty($matriculas))

        <div class="col-md-12 col-lg-12 col-xl-12" >
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO DE ESTUDIANTES</h4>
                    <h5>{{ $asignatura_nombre }}</h5>
                    <h5>ESTUDIANTES ACTIVOS: {{ $total }}</h5>
                    <h5>PERIODO: {{ $periodo }}</h5>
                    @if($tipo=='create')
                    <form action="{{ route('convivencia.store') }}" method="POST">
                    @else
                    <form action="{{ route('convivencia.update') }}" method="POST">
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
                                <th>LOGRO</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matriculas as $item)

                                <tr>

                                    <input type="hidden" name="matriculas[]" class="form-control" value="{{ $item->id }}" required>

                                   <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->apellidos.' '.$item->nombres }}</td>
                                    <td>
                                        @if($tipo=='create')
                                        <input type="number" name="logros[]" class="form-control" min="0" step="1" required>
                                        @else
                                       <input type="number" name="logros[]" class="form-control" min="0" step="1" value={{ $item->logro }} required>

                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-animation="bounce" data-target="#logros"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i></button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                    <div class="row">
                        @include('livewire.convivencia.notificacion')
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

