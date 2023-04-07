<div>
    @include('livewire.carga-academica.bloquear')
    @if (session()->has('message'))
    <script>
        alertify.success("{{ session('message') }}").delay(3000);
    </script>
    @endif
    <div class="row m-t-30">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-2" class="control-label">SEDE</label>
                           <select  class="form-control" wire:model.defer="sede">
                               <option value="">SELECCIONE</option>
                              @foreach ($sedes as $item)
                                  <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                              @endforeach
                           </select>
                            @error('sede') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-2" class="control-label">GRADO</label>
                           <select  class="form-control" wire:model.defer="grado">
                               <option value="">SELECCIONE</option>
                              @foreach ($grados as $item)
                                  <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                              @endforeach
                           </select>
                            @error('sede') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <label for="field-2" class="control-label">DOCENTE</label>
                           <select  class="form-control" wire:model.defer="docente">
                               <option value="">SELECCIONE</option>
                              @foreach ($docentes as $item)
                                  <option value="{{ $item->id }}">{{ $item->nombres.' '.$item->apellidos }}</option>
                              @endforeach
                           </select>
                           @error('docente') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                    <button class="btn btn-info" wire:click="buscar">BUSCAR</button>
                   </div>
                </div>

                </div>
            </div>

            @if(!empty($cargas))
            <div class="card m-b-30">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>ASIGNATURA</th>
                                    <th>IHS</th>
                                    <th>PORCENTAJE</th>
                                    <th>GRADO</th>
                                    <th>DOCENTE</th>
                                    <th>SEDE</th>
                                    <td></td>
                                </tr>
                                <tbody>
                                    @php
                                    $class="";
                                    @endphp
                                   @foreach ($cargas as $item)
                                       @if($item->asignatura->tipo_asignatura_id==1)
                                      @php
                                      $class="table-primary";
                                      @endphp
                                       @endif
                                       @if($item->asignatura->tipo_asignatura_id==2)
                                      @php
                                      $class="table-info";
                                      @endphp
                                       @endif
                                       @if($item->asignatura->tipo_asignatura_id==3)
                                      @php
                                      $class="table-danger";
                                      @endphp
                                       @endif
                                       <tr  class="{{ $class }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->asignatura->nombre }}</td>
                                        <td>{{ $item->ihs }}</td>
                                        <td>{{ $item->porcentaje }}%</td>
                                        <td>{{ $item->grado->descripcion.' ('.$item->grado->numero.'°)' }}</td>
                                        <td>{{ $item->docente->nombres.' '.$item->docente->apellidos }}</td>
                                        <td>{{ $item->sede->nombre }}</td>
                                        <td>
                                            <button data-toggle="modal" data-animation="bounce" wire:click="editEstado({{ $item->id }})" data-target=".bs-example-modal-center"  class="btn btn-outline-danger btn-sm"><i class="typcn typcn-delete-outline"></i>ELIMINAR</button>
                                        </td>
                                    </tr>

                                   @endforeach
                                </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            </div>
            @endif
        </div>
</div>
