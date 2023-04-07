<div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form action="{{ route('reporte-dimensiones') }}" method="POST">
                        @csrf
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
                               <select  class="form-control" wire:model="asignatura">
                                <option value="">SELECCIONE</option>
                                @foreach ($asignaturas as $item)
                                <option value="{{ $item->asignatura->id.'-'.$item->asignatura->nombre }}">{{ $item->asignatura->nombre }}</option>
                                  @endforeach
                               </select>
                                @error('asignatura') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label"><b>PERIODO</b></label>
                               <select  class="form-control" wire:model="periodo">
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
                                <button type="submit" class="btn btn-outline-info btn-block" ><span class="ai-search"></span>BUSCAR</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="sede" value="{{ $sede }}">
                    <input type="hidden" name="grado" value="{{ $grado }}">
                    <input type="hidden" name="asignatura" value="{{ $asignatura }}">
                    <input type="hidden" name="periodo" value="{{ $periodo }}">
                </form>
                </div>
            </div>
        </div>


    </div>
</div>
