<div>
    @if (session()->get('warning'))
    <script>
        advertencia("{{ session('warning') }}");
    </script>
    @endif

    @if (session()->get('success'))
    <script>
        mensaje("{{ session('success') }}");
    </script>
    @endif
    @include('livewire.individual-periodo.logros')

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
                          <select  class="form-control" wire:model="grado">
                            <option value="">SELECCIONE</option>
                           @foreach ($grados as $item)
                               <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                           @endforeach
                        </select>
                         @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-2" class="control-label"><b>ESTUDIANTE</b></label>
                           <select  class="form-control" wire:model.defer="matricula">
                            <option value="">SELECCIONE</option>
                            @foreach ($matriculas as $item)
                            <option value="{{ $item->id }}">{{ $item->apellidos.' '.$item->nombres }}</option>
                            @endforeach
                           </select>
                            @error('matricula') <span class="text-danger error">{{ $message }}</span>@enderror
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

    @if(count($asignaturas)>0)
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">LISTADO DE AREÁS/ASIGNATURAS</h4>
                <table class="table table-hover">

                    @foreach ($asignaturas as $item)
                    <tr>
                        <th> {{ $item->asignatura->nombre }}</th>
                        @foreach ($notas as $nota)
                            @if($nota->asignatura_id==$item->asignatura->id)
                                <td>{{ $nota->nota }}</td>
                            @endif
                        @endforeach

                        <td><input type="number" class="form-control" wire:model.defer='nota'></td>
                        <td><button type="button" wire:click="add({{ $loop->iteration - 1 }})" class="btn btn-info btn-sm">ENVIAR</button></td>
                    </tr>

                     @endforeach
                     <tr>
                         <th>DISCIPLINA</th>
                         <td>{{ $logroActual }}</td>
                         <td><input type="number" class="form-control" wire:model.defer='logro' min="0" step="1"></td>
                        <td>
                         <button type="button" data-toggle="modal" data-animation="bounce" data-target="#logros"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i></button>

                        </td>

                     </tr>

                </table>

            </div>
        </div>
    </div>

    @endif
</div>
