<div wire:ignore.self id="modalCreate" class="modal fade bd-example-modal-form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(135, 228, 123)">
                <h5 class="modal-title" id="exampleModalform">DATOS DE USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">SEDE</label>
                            <select  class="form-control" wire:model="sede">
                                <option value="">SELECCIONE</option>
                               @foreach ($sedes as $item)
                                   <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                               @endforeach
                            </select>
                            @error('sede') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
             </div>
             <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label">GRADO</label>
                        <select  class="form-control" wire:model.defer="grado">
                            <option value="">SELECCIONE</option>
                           @foreach ($grados as $item)
                               <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                           @endforeach
                        </select>
                        @error('grado') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>

            </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">DOCENTE</label>
                            <select  class="form-control" wire:model="docente">
                                <option value="">SELECCIONE</option>
                               @foreach ($docentes as $item)
                                   <option value="{{ $item->id }}">{{ $item->nombres.' '.$item->apellidos }}</option>
                               @endforeach
                            </select>
                            @error('docente') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                @if($updateMode)
                <button type="button" wire:click="update" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                </i> ACTUALIZAR</button>
                @else
                <button type="button" wire:click="store" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                </i> GUARDAR</button>
                @endif
                <button type="button" class="btn btn-raised btn-danger ml-2" data-dismiss="modal"><i class="mdi mdi-close-octagon
                    "></i> CANCELAR</button>
            </div>
        </div>
    </div>
</div>
