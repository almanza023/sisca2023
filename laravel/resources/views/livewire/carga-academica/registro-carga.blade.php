<div>
    @if (session()->has('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif
    <div class="row m-t-30">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">Sede</label>
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
                                <label for="field-2" class="control-label">Grado</label>
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
                                <label for="field-2" class="control-label">Docente</label>
                               <select  class="form-control" wire:model.defer="docente">
                                   <option value="">SELECCIONE</option>
                                  @foreach ($docentes as $item)
                                      <option value="{{ $item->id }}">{{ $item->nombres.' '.$item->apellidos }}</option>
                                  @endforeach
                               </select>
                                @error('docente') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">Asignatura</label>
                               <select  class="form-control" wire:model.defer="asig">
                                   <option value="">SELECCIONE</option>
                                  @foreach ($asignaturas as $item)
                                      <option value="{{ $item->id.'-'.$item->nombre }}">{{ $item->nombre.'-'.$item->tipo->nombre }}</option>
                                  @endforeach
                               </select>
                                @error('asig') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">IHS</label>
                                <input type="number" wire:model.defer="ihs" class="form-control"  required>
                                @error('ihs') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">Porcentaje</label>
                               <select  class="form-control" wire:model.defer="por">
                                   <option value="">SELECCIONE</option>
                                 <option value="10">10%</option>
                                 <option value="20">20%</option>
                                 <option value="30">30%</option>
                                 <option value="40">40%</option>
                                 <option value="50">50%</option>
                                 <option value="60">60%</option>
                                 <option value="70">70%</option>
                                 <option value="80">80%</option>
                                 <option value="90">90%</option>
                                 <option value="100">100%</option>
                               </select>
                                @error('por') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-outline-primary btn-block"  wire:click="add({{$i}})">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-b-30">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th></th>
                            <th>ASIGNATURA</th>
                            <th>IHS</th>
                            <th>PORCENTAJE</th>
                            <th></th>
                        </thead>
                        @php
                            $suma=0;
                        @endphp
                        <tbody>
                            @forelse ($detallesAsignatura as $key => $value)
                            <tr>
                                @php
                                    $suma+=$detallesIhs[$key];
                                @endphp
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value }}</td>
                                <td>{{ $detallesIhs[$key] }}</td>
                                <td>{{ $detallesPorcentaje[$key] }}%</td>
                                <td>
                                <button type="button" class="btn btn-danger btm-sm"><i class="mdi mdi-close-octagon"
                                    wire:click.prevent="remove({{$key}})"></i> </button>
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <th colspan="5"><center>No existen datos</center></th>
                                </tr>
                            @endforelse

                        </tbody>
                        <tr>
                            <tr>
                                <td colspan="3"></td>
                                <th >IHS</th>
                                <th >{{ $suma }}</th>
                            </tr>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" wire:click.prevent="store" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                            </i> GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
