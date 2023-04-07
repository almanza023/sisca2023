<div>
    @if (session()->has('message'))
    <script>
       success("{{ session('message') }}");
    </script>
    @endif
    <div class="row m-t-30">
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">DATOS LOGROS PREESCOLAR</h4>
                   @if(count($sedes)>0)
                   <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-2" class="control-label">SEDE</label>
                           <select  class="form-control" wire:model.defer="sede_id">
                               <option value="">SELECCIONE</option>
                               @foreach ($sedes as $item)
                               <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                           </select>
                            @error('sede_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                   @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">GRADO</label>
                                   <select  class="form-control" wire:model="grado">
                                       <option value="">SELECCIONE</option>
                                       @if(count($gradosDocente)>0)
                                       @foreach ($gradosDocente as $item)
                                       @if($item->grado->id<3)
                                       <option value="{{ $item->grado->id }}">{{ $item->grado->descripcion }}</option>
                                       @endif
                                        @endforeach
                                       @else
                                       @foreach ($grados as $item)
                                      @if($item->id<3)
                                      <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                      @endif

                                    @endforeach
                                       @endif

                                   </select>
                                    @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">DIMENSION</label>
                                   <select  class="form-control" wire:model="asignatura">
                                       <option value="">SELECCIONE</option>
                                    @if(!empty($asignaturas))
                                    @foreach ($asignaturas as $item)
                                    <option value="{{ $item->asignatura->id }}">{{ $item->asignatura->nombre }}</option>
                                @endforeach
                                    @endif
                                   </select>
                                    @error('asignatura') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">TIPO</label>
                                   <select  class="form-control" wire:model.defer="tipo">
                                       <option value="">SELECCIONE</option>
                                        <option value="ACTITUDINAL">ACTITUDINAL</option>
                                        <option value="CONCEPTUAL">CONCEPTUAL</option>
                                        <option value="PROCEDIMENTAL">PROCEDIMENTAL</option>
                                   </select>
                                    @error('tipo') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">DESCRIPCIÓN</label>
                                    <textarea type="text" wire:model.defer="descripcion" class="form-control"  required>
                                    </textarea>
                                    @error('descripcion') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                @if($updateMode)
                                <button type="button" wire:click.prevent="update" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                                </i> ACTUALIZAR</button>
                                @else
                                <button type="button" wire:click.prevent="store" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                                </i> GUARDAR</button>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <button type="button" wire:click.prevent="filtrar" class="btn btn-raised btn-info m-t-10 m-b-10" >
                                <i class="typcn typcn-eye"> </i>CONSULTAR</button>
                            </div>

                            <div class="col-md-4">
                                <button type="button" wire:click.prevent="resetInputFields" class="btn btn-raised btn-danger m-t-10 m-b-10" >
                                <i class="typcn typcn-close"> </i>CANCELAR</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">LISTADO LOGROS</h4>
                   @if(!empty($logros))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>CODIGO</td>
                                    <td>DESCRIPCION</td>
                                    <td>DIMENSIÓN</td>
                                    <td>TIPO</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logros as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><p>{{ $item->descripcion }}</p></td>
                                        <td>{{ $item->asignatura->nombre }}</td>
                                        <td>{{ $item->tipo }}</td>
                                        <td>
                                            <button class="btn btn-outline-info btn-sm" wire:click="edit({{ $item->id }})"><i class="typcn typcn-edit"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <th colspan="6"><center>No existen datos</center></th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                   @endif


                </div>
            </div>
        </div>
    </div>

</div>

